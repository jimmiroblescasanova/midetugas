<?php

namespace App\Jobs;

use App\Document;
use App\Traits\getPDFTrait;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class GeneratePDFFile implements ShouldQueue
{
    use getPDFTrait;
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Document $document, public string $folderName)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pdf = $this->generarPDF($this->document);

        Storage::put("pdf/{$this->folderName}/{$this->document->reference}.pdf", $pdf->output());

    }
}
