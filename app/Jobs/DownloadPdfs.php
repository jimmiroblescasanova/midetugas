<?php

namespace App\Jobs;

use ZipArchive;
use App\Document;
use App\Traits\GraphBarTrait;
use Illuminate\Bus\Queueable;
use App\Mail\DownloadCompleted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DownloadPdfs implements ShouldQueue
{
    use GraphBarTrait;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $folder = NOW()->format('Ymdis');
        $save_to = "pdf/" . $folder;
        Storage::makeDirectory( $save_to );

        $documents = Document::whereBetween('date', [$this->data['startDate'], $this->data['endDate']])->get();

        foreach($documents as $docto){
            // Se obtiene los históricos de meses anteriores
            $historic = Document::select('id', 'period', 'month_quantity', 'total')
            ->where([
                ['client_id', $docto->client_id],
                ['id', '<=', $docto->id],
                ['status', '!=', 3]
            ])->orderByDesc('id')->get();

            // Trait to generate the chart
            $chart = $this->generateChart($historic);

            $html = '';
            $view = view('print.document')->with(compact('docto','chart', 'historic'));
            $html .= $view->render();
            \PDF::loadHTML($html)->save( public_path("storage/".$save_to ."/{$docto->id}.pdf") );
        }

        $zip = new ZipArchive;
        $fileName = "storage/".$save_to .".zip";

        if ($zip->open(public_path($fileName), ZipArchive::CREATE)== TRUE)
        {
            $files = File::files(public_path("storage/".$save_to));

            foreach ($files as $key => $value){
                $relativeName = basename($value);
                $zip->addFile($value, $relativeName);
            }
            $zip->close();
        }

        Mail::to( $this->data['email'] )->send(new DownloadCompleted( $folder ));
    }
}
