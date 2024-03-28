<?php

namespace App\Jobs;

use ZipArchive;
use App\Document;
use App\Traits\getPDFTrait;
use App\Traits\GraphBarTrait;
use Illuminate\Bus\Queueable;
use App\Mail\DownloadCompleted;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DownloadPdfs implements ShouldQueue
{
    use getPDFTrait, GraphBarTrait;
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
        $folderName = NOW()->format('Ymdis');
        $storageRoute = "pdf/" . $folderName;
        Storage::makeDirectory("public/" . $storageRoute );

        $documents = Document::whereBetween('date', [$this->data['startDate'], $this->data['endDate']])->get();

        foreach($documents as $docto){
            $pdf = $this->generarPDF($docto);
            Storage::put("public/{$storageRoute}/{$docto->reference}.pdf", $pdf->output());
        }

        $zip = new ZipArchive;
        $fileName = "storage/{$storageRoute}.zip";

        if ($zip->open(public_path($fileName), ZipArchive::CREATE)== TRUE)
        {
            $files = File::files(public_path("storage/".$storageRoute));

            foreach ($files as $key => $value){
                $relativeName = basename($value);
                $zip->addFile($value, $relativeName);
            }
            $zip->close();
        }

        Mail::to( $this->data['email'] )->send(new DownloadCompleted( $folderName ));
    }
}
