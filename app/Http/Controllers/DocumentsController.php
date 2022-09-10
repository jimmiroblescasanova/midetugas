<?php

namespace App\Http\Controllers;

use App\Price;
use App\Client;
use App\Project;
use App\Document;
use App\Measurer;
use Carbon\Carbon;
use App\Traits\SendSmsTrait;
use App\Traits\GraphBarTrait;
use App\Mail\AuthorizeReceipt;
use App\Traits\UpdateProjectTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\SaveDocumentRequest;

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
        return view('documents.index', [
            'documents' => Document::orderByDesc('id')->get(),
        ]);
    }

    public function create()
    {
        return view('documents.create', [
            'clients' => Client::all(),
        ]);
    }

    public function store(SaveDocumentRequest $request)
    {
        // Primero obtenemos el precio actual de la BD
        $price = Price::latest()->first()->price;
        // Se obtiene el cliente capturado
        $client = Client::find($request->client_id);
        // Calcula el saldo a favor del cliente
        $saldoAFavor = Document::where([
            ['client_id', $client->id],
            ['pending', '>=', 0.01]
        ])->sum('pending');
        // Se calcula el día de pago a partir de la fecha de captura
        $payment_date = Carbon::create($request->date)->addDays(10);
        // Guarda la foto y asigna la ruta
        $photo = $request->file('photo')->store('images');
        // Consumo del mes
        $month_quantity = $request->final_quantity - $client->measurer->actual_measure;
        // Factor de correccion
        $correction_factor = $client->measurer->correction_factor;
        // Subtotal del mes
        $subtotal = (100 + ($month_quantity * $correction_factor) * $price);
        // Calculo del IVA
        $iva = ($subtotal * 1.16) - $subtotal;
        // Importe total del mes
        $total = $subtotal + $iva;
        // Se valida si el cliente tiene cargo adicional y se suma
        if ($client->reconnection_charge == TRUE) {
            $total += 99;
        }
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
            'adm_charge' => 100,
            'price' => $price,
            'subtotal' => $subtotal * 100,
            'iva' => $iva * 100,
            'total' => $total * 100,
            'pending' => $total * 100,
            'previous_balance' => $saldoAFavor,
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
            // Si es correcto, guarda los cambios
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            abort(403, $e->getMessage());
        }

        return redirect()->route('documents.create')->with('message', 'Lectura capturada correctamente.');
    }

    public function show(Document $document)
    {
        // Obtener datos para la tabla de barras
        $historic = Document::select('id', 'period', 'month_quantity')
            ->where([
                ['client_id', $document->client_id],
                ['id', '<=', $document->id],
                ['status', '!=', 3]
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
        // Datos del token para Twilio
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');

        try {
            DB::beginTransaction();
            $docto = Document::findOrFail($id);
            // Guarda el PDF en la ruta public
            $pdf = $this->generarPDF($docto);
            Storage::put('/pdf/' . $docto->reference . '.pdf', $pdf->output());
            // Envía correo de generación del recibo
            Mail::to($docto->client->email)->queue(new AuthorizeReceipt($docto->reference));
            // enviar recibo por sms AWS
            //            $this->receiptGenerated($docto->client->phoneNumber);
            // Cambia el status el documento a "autorizado"
            $docto->status = 2;
            $docto->save();
            // Enviar notificación por mensaje
            /* $twilio = new \Twilio\Rest\Client($sid, $token);
            $message = $twilio->messages
            ->create("whatsapp:+5219981576290", // to
                array(
                    "from" => "whatsapp:+14155238886",
                    "body" => "Se ha generado su recibo de consumo de gas, por un total de $" . $docto->total . ", con fecha limite de pago el " . $docto->payment_date->format('d/m/Y') . ", puede consultar el documento PDF en su correo electrónico."
                )
            ); */
            // Si todo se ejecuta sin error, se guardan los cambios
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }

        Alert::success('Autorizado', 'El registro ha sido autorizado con éxito.');
        return redirect()->route('documents.index');
    }

    public function cancel(Document $document)
    {
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
            abort(403, $th->getMessage());
        }

        Alert::info('Cancelado', 'El registro ha sido cancelado con éxito.');
        return redirect()->route('documents.index');
    }

    public function print($id)
    {
        $docto = Document::findOrFail($id);
        $file = "/pdf/{$docto->reference}.pdf";

        if (Storage::disk('public')->exists($file)) {
            return response()->file(storage_path("app/public/{$file}"));
        } else {
            $pdf = $this->generarPDF($docto);
            return $pdf->stream();
        }
    }

    public function generarPDF($docto)
    {
        // Se obtiene los históricos de meses anteriores
        $historic = Document::select('id', 'period', 'month_quantity', 'total')
            ->where([
                ['client_id', $docto->client_id],
                ['id', '<=', $docto->id],
                ['status', '!=', 3]
            ])->orderByDesc('id')->get();

        // Trait to generate the chart
        $chart = $this->generateChart($historic);

        // Generar el PDF
        $pdf = \PDF::loadView('print.document', [
            'docto' => $docto,
            'chart' => urlencode($chart),
            'historic' => $historic->take(2),
        ]);
        $pdf->setPaper('A4', 'portrait');
        return $pdf;
    }
}
