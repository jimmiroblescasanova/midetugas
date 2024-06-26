<?php

namespace App\Http\Controllers;

use App\Price;
use App\Client;
use App\Project;
use App\Document;
use App\Measurer;
use Carbon\Carbon;
use App\Traits\GetPDFTrait;
use Illuminate\Support\Str;
use App\Traits\SendSmsTrait;
use Illuminate\Http\Request;
use App\Traits\GraphBarTrait;
use App\Mail\AuthorizeReceipt;
use App\Traits\UpdateProjectTrait;
use Illuminate\Support\Facades\DB;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SaveDocumentRequest;

class DocumentsController extends Controller
{
    use GetPDFTrait;
    use SendSmsTrait;
    use GraphBarTrait;
    use UpdateProjectTrait;

    public function __construct()
    {
        $this->middleware('auth')->except('print');
    }

    public function index()
    {
        return view('documents.index', [
            'documents' => Document::orderByDesc('id')->get(),
        ]);
    }

    public function create()
    {
        return view('documents.create', [
            'clients' => Client::has('project')->get(),
        ]);
    }

    public function store(SaveDocumentRequest $request)
    {
        // Se obtiene el cliente capturado
        $client = Client::with('project')->find($request->client_id);
        // Se valida si existen documentos pendientes por autorizar
        if ($client->documents()->pending()->exists()) {
            // En caso de existir, se detiene el proceso
            return redirect()
                ->back()
                ->with('alert-message', 'Existen documentos sin autorizar del cliente, autoriza o cancela los documentos pendientes, click <a href="/documents?search='.Str::replace(' ', '+', $client->name). '&status=1">AQUI</a> para dirigirte al listado');
        }
        // Se valida si el condominio tiene existencia suficiente
        if ($client->project->actual_capacity <= 0) {
            Flasher::addWarning('El condominio del cliente no tiene inventario.');
            return redirect()->back();
        }

        // almacena la ruta tmp de foto
        $files = $request->file('photo');
        // convert image
        $ImageUpload = Image::make($files);
        // Corrige la orientacion de la imagen
        if ($ImageUpload->exif('Orientation') == 6) {
            $ImageUpload->rotate(-90)->heighten(800);
        } elseif($ImageUpload->exif('Orientation') == 8) {
            $ImageUpload->rotate(90)->heighten(800);
        } else {
            $ImageUpload->heighten(800);
        }
        $ImageUpload->encode('jpg');

        // Primero obtenemos el precio actual de la BD
        $price = Price::latest()->first()->price;
        // Calcula el saldo a favor del cliente
        $saldoAFavor = Document::where([
            ['client_id', $client->id],
            ['pending', '>=', 0.01]
        ])->sum('pending');
        // Se calcula el día de pago a partir de la fecha de captura
        $payment_date = Carbon::create($request->date)->addDays(10);
        // Guarda la foto y asigna la ruta
        $photo = 'images/' . $files->hashName();
        // Consumo del mes
        $month_quantity = round($request->final_quantity - $client->measurer->actual_measure, 3);
        // Factor de correccion
        $correction_factor = $client->measurer->factor->value;
        // Subtotal del mes
        $neto = round(($month_quantity * $correction_factor) * $price, 2);
        $subtotal = $neto + $request->admCharge + $request->reconnection;
        // Calculo del IVA
        $iva = round( ($subtotal * 1.16) - $subtotal, 2);
        // Importe total del mes
        $total = $subtotal + $iva;
        // Se valida si el cliente tiene cargo adicional y se suma
        /* if ($client->reconnection_charge == TRUE) {
            $total += 99;
        } */
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
            'period' => Carbon::create($request->date)->isoFormat('MMMM, Y'),
            'adm_charge' => $request->admCharge * 100,
            'reconnection' => $request->reconnection * 100,
            'price' => $price,
            'subtotal' => $neto * 100,
            'iva' => $iva * 100,
            'total' => $total * 100,
            'pending' => $total * 100,
            // 'previous_balance' => $saldoAFavor,
            'photo' => $photo,
            'created_at' => NOW(),
        ];

        try {
            DB::beginTransaction();
            // Crea el documento a partir de array
            $document_id = DB::table('documents')->insertGetId($data);
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
            // Descuenta la capacidad actual y calcula el pocentaje
            DB::table('projects')
                ->where('id', $client->project_id)
                ->update([
                    'actual_capacity' => $project->actual_capacity - ($month_quantity * 4.1848), // Se multiplica por la conversión a litros
                    'percentage' => $this->calculatePercentage($project),
                ]);
            // Guarda la foto en BD
            Storage::put($photo, $ImageUpload->__toString());
            // Si es correcto, guarda los cambios
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            abort(403, $e->getMessage());
        }

        Flasher::addSuccess('Recibo generado correctamente');

        return redirect()->route('documents.create');
    }

    public function show(Document $document)
    {
        // Obtener datos para la tabla de barras
        $historic = Document::select('id', 'period', 'month_quantity', 'correction_factor')
            ->where([
                ['client_id', $document->client_id],
                ['id', '<=', $document->id],
                ['status', '!=', 3]
            ])->orderByDesc('id')->get();

        $chart = $this->generateChart($historic);

        return view('documents.show', [
            'document' => $document,
            'chart' => $chart,
            'acumulado' => $this->calcularAcumulado($document->client_id, $document->date),
        ]);
    }

    public function authorizeDocument($id)
    {
        try {
            DB::beginTransaction();
            $docto = Document::findOrFail($id);
            // Guarda el PDF en la ruta public
            $pdf = $this->generarPDF($docto);
            Storage::put('/pdf/' . $docto->reference . '.pdf', $pdf->output());
            // Envía correo de generación del recibo
            //Mail::to($docto->client->email)->queue(new AuthorizeReceipt($docto->reference));
            // Cambia el status el documento a "autorizado"
            $docto->status = 2;
            $docto->save();
            // Si todo se ejecuta sin error, se guardan los cambios
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }

        Flasher::addSuccess('El registro ha sido autorizado con éxito.');
        return redirect()->route('documents.index');
    }

    public function discount(Document $document, Request $request)
    {
        $subtotal = ($document->subtotal + $document->adm_charge + $document->reconnection) - $request->discount;
        $iva = round( ($subtotal * 1.16) - $subtotal, 2);
        $total = $subtotal + $iva;

        $document->update([
            'discount' => $request->discount,
            'iva' => $iva,
            'total' => $total,
            'pending' => $total,
        ]);

        Flasher::addInfo('El descuento se ha aplicado correctamente.');
        return redirect()->back();
    }

    public function cancel(Document $document)
    {
        $activeDocuments = Document::where([
            ['client_id', $document->client_id], 
            ['id', '>', $document->id],
            ])
            ->whereIn('status', [1,2])
            ->count();

        if ($document->payments()->exists() || $activeDocuments >= 1) {
            Flasher::addWarning('No se puede cancelar, cancele los pagos existentes o documentos futuros.');
            return redirect()->back();
        }

        try {
            $measurer = Measurer::where('client_id', $document->client_id)->first();
            $project = Project::findOrFail($document->client->project_id);

            DB::beginTransaction();

            $document->status = 3;
            $document->pending = 0;
            $document->save();
            // Regresar el valor del medidor
            $measurer->actual_measure = $document->start_quantity;
            $measurer->save();
            // Actualizar el porcentaje del proyecto
            $project->actual_capacity += ($document->month_quantity * 4.1848);
            $project->percentage = $this->calculatePercentage($project);
            $project->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            abort(500, $th->getMessage());
        }

        Flasher::addWarning('El registro ha sido cancelado con éxito.');
        return redirect()->route('documents.index');
    }

    public function print($id)
    {
        $docto = Document::findOrFail($id);
        $pdf = $this->generarPDF($docto);

        return $pdf->stream();
    }

    public function sendEmail(Document $document)
    {
        Mail::to($document->client->email)->queue(new AuthorizeReceipt($document));

        flash()->addSuccess('Correo enviado con éxito');

        return back();
    }
}
