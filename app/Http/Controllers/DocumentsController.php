<?php

namespace App\Http\Controllers;

use App\admConceptos;
use App\admDocumentos;
use App\admMovimientos;
use App\Mail\AuthorizeReceipt;
use App\Measurer;
use App\Price;
use App\Client;
use App\Project;
use App\Document;
use Carbon\Carbon;
use App\Traits\SendSmsTrait;
use App\Traits\GraphBarTrait;
use App\Traits\UpdateProjectTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SaveDocumentRequest;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Storage;

class DocumentsController extends Controller
{
    use SendSmsTrait;
    use GraphBarTrait;
    use UpdateProjectTrait;

    public function __construct()
    {
        $this->middleware('auth')->except('print');
    }

    public function index()
    {
        return view('documents.index',[
            'documents' => Document::orderByDesc('id')->get(),
        ]);
    }

    public function create()
    {
        $measurer = Measurer::where('active', '=', 1)->get();

        return view('documents.create', [
            'clients' => Client::all(),
            'measurer' => $measurer,
        ]);
    }

    public function store(SaveDocumentRequest $request)
    {
        // Primero obtenemos el precio actual de la BD
        $price = Price::latest()->first()->price;
        // Se obtiene el cliente capturado
        $client = Client::find($request->client_id);
        // Se calcula el día de pago a partir de la fecha de captura
        $payment_date = Carbon::create($request->date)->addDays(10);
        // Guarda la foto y asigna la ruta
        $photo = $request->file('photo')->store('images');
        // Consumo del mes
        $month_quantity = $request->final_quantity - $client->measurer->actual_measure;
        // Factor de correccion
        $correction_factor = $client->measurer->correction_factor;
        // Importe total del mes
        $total = ($month_quantity * ($price * $correction_factor)) + $client->balance;
        // Se valida si el cliente tiene cargo adicional y se suma
        if ($client->reconnection_charge == TRUE) {
            $total += 99;
        }
        // Separar decimales
        $arr_total = explode('.', round($total,2));
        // Se obtiene el condominio del cliente
        $project = Project::find($client->project_id);
        // Guarda todos los valores en un array
        $data = [
            'client_id' => $request->client_id,
            'date' => $request->date,
            'payment_date' => $payment_date,
            'final_quantity' => $request->final_quantity,
            'start_quantity' => $client->measurer->actual_measure,
            'month_quantity' => $month_quantity,
            'correction_factor' => $correction_factor,
            'period' => Carbon::create($request->date)->subMonth()->isoFormat('MMMM, Y'),
            'price' => $price,
            'total' => $arr_total[0],
            'pending' => $arr_total[0],
            'previous_balance' => $client->balance,
            'photo' => $photo,
            'created_at' => NOW(),
        ];

        try {
            DB::beginTransaction();
            // Crea el documento a partir de array
            $document_id = DB::table('documents')->insertGetId($data);
            // Actualiza el balance del cliente
            DB::table('clients')
                ->where('id', $request->client_id)
                ->update([
                    'balance' => array_key_exists(1, $arr_total) ? $arr_total[1] : 0,
                    'reconnection_charge' => FALSE,
                ]);
            // Crear la referencia de pago
            DB::table('documents')
                ->where('id', $document_id)
                ->update([
                    'reference' => $payment_date->format('Ym') . str_pad($document_id, 4, '0', STR_PAD_LEFT)
                ]);
            // Obtener el id del medidor usado y actualiza su valor
            DB::table('measurers')
                ->where('id', $client->measurer->id)
                ->update([
                    'actual_measure' => $request['final_quantity'],
                ]);
            DB::table('projects')
                ->where('id', $client->project_id)
                ->update([
                    'actual_capacity' => $project->actual_capacity - ($month_quantity * 4.1848), // Se multiplica por la conversión a litros
                    'percentage' => $this->calculatePercentage($project),
                ]);
            // Si es correcto, guarda los cambios
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }

        return redirect()->route('documents.create')
            ->with('message', 'Lectura capturada correctamente.');
    }

    public function show(Document $document)
    {
        // Obtener datos para la tabla de barras
        $historic = Document::select('id', 'period', 'month_quantity')
            ->where([
                ['client_id', $document->client_id],
                ['id', '<=', $document->id]
            ])->orderByDesc('id')->get();

        $chart = $this->generateChart($historic);

        return view('documents.show', [
            'document' => $document,
            'chart' => $chart,
            'advance_payment' => Client::findOrFail($document->client_id)->advance_payment,
        ]);
    }

    public function authorizeDocument($id)
    {
        $docto = Document::findOrFail($id);
        $pdf = $this->getPDF($docto);
        Storage::put('/pdf/'. $docto->reference .'.pdf', $pdf->output());

        try {
            DB::beginTransaction();
            Mail::to($docto->client->email)->queue(new AuthorizeReceipt( $docto->reference ));
            $this->receiptGenerated($docto->client->phoneNumber);
            $docto->status = 2;
            $docto->save();
            DB::commit();
        } catch (\Exception $e)
        {
            DB::rollBack();
            return $e;
        }

        return redirect()->route('documents.index');
    }

    public function cancel($id)
    {
        $docto = Document::findOrFail($id);
        $docto->status = 3;
        $docto->pending = 0;
        $docto->save();

        return back();
    }

    public function print($id)
    {
        $docto = Document::findOrFail($id);
        $file = "/pdf/{$docto->reference}.pdf";
        if (Storage::disk('public')->exists( $file ))
        {
            return response()->file( storage_path("app/public/{$file}") );
        }
        else {
            $pdf = $this->getPDF($docto);
            return $pdf->stream();
        }
    }

    public function linkCtiComercial(Document $document)
    {
        $idDocumento = admDocumentos::orderBy('CIDDOCUMENTO', 'DESC')->first()->CIDDOCUMENTO;
        $idMovimiento = admMovimientos::orderBy('CIDMOVIMIENTO', 'DESC')->first()->CIDMOVIMIENTO;

        // Crea el array para los datos generales del pedido
        $dEncabezados = [
            'CIDDOCUMENTO' => $idDocumento+1,
            'CIDDOCUMENTODE' => env('DOCUMENTO_ID'),
            'CIDCONCEPTODOCUMENTO' => env('CONCEPTO_ID'),
            'CSERIEDOCUMENTO' => 'S',
            'CFOLIO' => $document['id'],
            'CFECHA' => NOW(),
            'CIDCLIENTEPROVEEDOR' => $document->client->admCode,
            'CRAZONSOCIAL' => $document->client->name,
            'CRFC' => $document->client->rfc,
            'CFECHAVENCIMIENTO' => NOW(),
            'CFECHAPRONTOPAGO' => NOW(),
            'CFECHAENTREGARECEPCION' => NOW(),
            'CFECHAULTIMOINTERES' => NOW(),
            'CIDMONEDA' => 1,
            'CTIPOCAMBIO' => 1,
            'CREFERENCIA' => $document['reference'],
            'CNATURALEZA' => 2,
            'CUSACLIENTE' => 1,
            'CUSAPROVEEDOR' => 0,
            'CAFECTADO' => 1,
            'CESTADOCONTABLE' => 1,
            'CNETO' => ($document->total / 1.16),
            'CIMPUESTO1' => $document->total - ($document->total / 1.16),
            'CTOTAL' => $document->total,
            'CPENDIENTE' => $document->total,
            'CTOTALUNIDADES' => 1,
            'CUNIDADESPENDIENTES' => 1,
            'CTIMESTAMP' => NOW(),
            'CIMPCHEQPAQ' => 116,
            'CSISTORIG' => 205,
            'CIDMONEDCA' => 0,
        ];
        // Crea el array para el movimiento del pedido
        $dMovimiento = [
            'CIDMOVIMIENTO' => $idMovimiento+1,
            'CIDDOCUMENTO' => $dEncabezados['CIDDOCUMENTO'],
            'CNUMEROMOVIMIENTO' => 1,
            'CIDDOCUMENTODE' => 2,
            'CIDPRODUCTO' => env('PRODUCTO_ID'),
            'CIDALMACEN' => 1,
            'CUNIDADES' => 1,
            'CUNIDADESCAPTURADAS' => 1,
            'CPRECIO' => round(($document->total / 1.16), 2),
            'CPRECIOCAPTURADO' => round(($document->total / 1.16), 2),
            'CNETO' => round(($document->total / 1.16), 2),
            'CIMPUESTO1' => round($document->total - ($document->total / 1.16), 2),
            'CPORCENTAJEIMPUESTO1' => 16,
            'CTOTAL' => $document->total,
            'CAFECTAEXISTENCIA' => 3,
            'CAFECTADOSALDOS' => 1,
            'CFECHA' => NOW(),
            'CUNIDADESPENDIENTES' => 1,
            'CTIPOTRASPASO' => 1,
        ];

        try {
            DB::connection('mssql')->beginTransaction();
            // Crea el documento a partir de array
            DB::connection('mssql')->table('admDocumentos')->insert($dEncabezados);
            // Crea el movimiento en la tabla
            DB::connection('mssql')->table('admMovimientos')->insert($dMovimiento);
            // Asocia el ID del documento comercial en la webapp
            $document->admDocumentId = $dEncabezados['CIDDOCUMENTO'];
            $document->save();
            DB::connection('mssql')->commit();
        } catch (\Throwable $e) {
            DB::connection('mssql')->rollBack();
            throw $e;
        }

        Alert::success('Creado', "El documento se ha creado en el sistema comercial con ID {$dEncabezados['CIDDOCUMENTO']}");
        return redirect()->back();
    }

    public function getPDF($docto)
    {
        // Se obtiene los históricos de meses anteriores
        $historic = Document::select('id', 'period', 'month_quantity', 'total')
            ->where([
                ['client_id', $docto->client_id],
                ['id', '<=', $docto->id]
            ])->orderByDesc('id')->get();

        // Trait to generate the chart
        $chart = $this->generateChart($historic);

        // Generar el PDF
        $pdf = \PDF::loadView('print.document', [
            'docto' => $docto,
            'chart' => urlencode($chart),
            'historic' => $historic->take(2),
        ]);
        $pdf->setPaper('statement', 'portrait');
//        Storage::put('/pdf/'. $docto->reference .'.pdf', $pdf->output());
        return $pdf;
    }
}
