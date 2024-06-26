<?php

namespace App\Http\Controllers;

use App\Tank;
use ZipArchive;
use App\Project;
use App\Document;
use App\Inventory;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
use App\Jobs\GeneratePDFFile;
use App\Mail\DownloadCompleted;
use App\Traits\UpdateProjectTrait;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
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
            $zip = new ZipArchive;
            $fileName = "storage/pdf/{$folderName}.zip";

            if ($zip->open(public_path($fileName), ZipArchive::CREATE)== TRUE)
            {
                $files = File::files(public_path("storage/pdf/".$folderName));

                foreach ($files as $key => $value){
                    $relativeName = basename($value);
                    $zip->addFile($value, $relativeName);
                }
                $zip->close();
            }

            Mail::to( $email)->send(new DownloadCompleted( $folderName ));
        })
        ->dispatch();

        Flasher::addSuccess('Se te enviara un correo con el enlace de descarga.');
        return redirect()->route('home');
    }
}
