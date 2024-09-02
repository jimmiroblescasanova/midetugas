<?php

namespace App\Jobs;

use ZipArchive;
use Illuminate\Bus\Queueable;
use App\Mail\DownloadCompleted;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CompressMassPdfGeneration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 500;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public string $folderName,
        public string $email
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $zip = new ZipArchive;
        $fileName = "storage/pdf/{$this->folderName}.zip";

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) == TRUE) {
            $files = File::files(public_path("storage/pdf/" . $this->folderName));

            foreach ($files as $key => $value) {
                $relativeName = basename($value);
                $zip->addFile($value, $relativeName);
            }
            $zip->close();
        }

        Mail::to($this->email)->send(new DownloadCompleted($this->folderName));
    }
}
