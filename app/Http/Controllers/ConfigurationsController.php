<?php

namespace App\Http\Controllers;

use App\Tank;
use App\Client;
use App\Payment;
use App\Project;
use App\Document;
use App\Inventory;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
use App\Jobs\GeneratePDFFile;
use App\Traits\UpdateProjectTrait;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use App\Jobs\CompressMassPdfGeneration;
use Illuminate\Support\Facades\Storage;

class ConfigurationsController extends Controller
{
    use UpdateProjectTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function tasks()
    {
        return view('configurations.tasks', [
            'projects' => Project::pluck('id', 'name'),
            'clients' => Client::orderBy('name', 'asc')->get(),
        ]);
    }

    public function recalcularInventario(Request $request)
    {
        try {
            // Proyecto / condominio
            $project = Project::findOrFail($request->project_id);
            echo "Condominio: obtenido correctamente...<br/>";
            // Calcular la cantidad del inventario del condominio
            $quantity = Inventory::where('project_id', $request->project_id)->sum('quantity') / 100;
            echo "Ingresos al inventario: obtenido correctamente...<br/>";
            // Seleccionar a los clientes que pertenecen al condominio
            $clients = Project::find($request->project_id)->clients;
            echo "Clientes: obtenidos correctamente del condominio...<br/>";
            // Obtener los tanques del condominio
            $sum_quantity_tanks = Tank::where('project_id', $request->project_id)->sum('capacity');
            echo "Capacidad total del condominio calculada...<br/>";
            // Totales del condominio/proyecto
            $month_quantity_total = 0;

            // Sumar las consumos mensuales
            foreach ($clients as $client)
            {
                echo "Calculando cliente: {$client->name}<br/>";
                  $month_quantity = Document::where([
                      ['client_id', $client->id],
                      ['status', '!=', 3]
                  ])->sum('month_quantity');
                  $month_quantity_total += $month_quantity;
            }
            $month_total_converted = $month_quantity_total * 4.1848;
            $project_total = $quantity - $month_total_converted;

            // Actualizar valores del condominio
            echo "Actualizando importes del condominio... ";
            $project->actual_capacity = $project_total;
            $project->total_capacity = $sum_quantity_tanks;
            $project->percentage = $this->calculatePercentage($project);
            $project->save();
            echo "Done <br/>";

        } catch (\Exception $e) {
            abort(403, 'No se pudo completar el proceso.');
        }

        // Alert::success('Finalizado', 'Proceso ejecutado correctamente.');
        return "<br>Proceso terminado: <a href='/'>COMPLETAR</a>";
    }

    public function descargaMasiva()
    {
        return view('configurations.descarga-masiva');
    }

    public function multiPdf(Request $request)
    {
        $datos_validos = $request->validate([
            'startDate' => 'required|date|before:endDate',
            'endDate' => 'required|date|after:startDate',
            'email' => 'required|email',
        ]);

        $getDocuments = Document::query()
            ->whereBetween('date', [$datos_validos['startDate'], $datos_validos['endDate']])
            ->where('status', 2)
            ->get();

        if ($getDocuments->count() == 0) {
            Flasher::addError('No hay documentos autorizados en ese rango de fechas.');
            return redirect()->back();
        }

        // Generar la carpeta para los archivos
        $folderName = NOW()->format('Ymdis');
        $storageRoute = "pdf/" . $folderName;
        Storage::makeDirectory( $storageRoute );

        // Generar el array con los jobs individuales
        $jobs = [];
        foreach ($getDocuments as $singleDocument) {
            $jobs[] = new GeneratePDFFile($singleDocument, $folderName);
        }

        $email = $request['email'];
        Bus::batch($jobs)
        ->then(function (Batch $batch) use ($folderName, $email) {
            CompressMassPdfGeneration::dispatch($folderName, $email);
        })
        ->finally(function (Batch $batch) {
            Log::info('PDFs masivos completados a las: ' . now());
        })
        ->allowFailures()
        ->dispatch();

        Flasher::addSuccess('Se te enviara un correo con el enlace de descarga.');
        return redirect()->route('home');
    }

    public function recalculateClient(Request $request)
    {
        $allDocuments = Document::with('payments')
        ->where('client_id', $request->client)
        ->whereIn('status', [1,2])
        ->get();

        $logData = $allDocuments->map(function ($docto) {
            $total_payed = round($docto->payments->sum('pivot.amount') / 100, 2);
            $total_payment_balance = round($docto->payments()->sum('payments.balance') / 100, 2);
            $total_payment_amount = round($docto->payments()->sum('payments.amount') / 100, 2);

            $docto->update([
                'pending' => round($docto->total - $total_payed, 2),
            ]);
        
            return [
                'id' => $docto->id,
                'total' => $docto->total,
                'pending' => $docto->pending,
                'total_payed' => $total_payed,
                'total_payment_amount' => $total_payment_amount,
                'total_payment_balance' => $total_payment_balance,
                'total_sent_to_client_balance' => round(($total_payment_balance + $total_payment_amount) - $total_payed, 2),
            ];
        }); 

        Flasher::addSuccess('Documentos revisados.');

        $total_documents_amount_payed = $logData->sum('total_payed');
        $total_of_payments = round(Payment::where('client_id', '=', $request->client)->sum('amount') / 100, 2);
        $diff = $total_of_payments - $total_documents_amount_payed;

        $client = Client::find($request->client);
        $client->update([
            'balance' => $diff,
        ]);

        Flasher::addSuccess('Balance del cliente actualizado');

        return redirect()->route('home');
    }

}
