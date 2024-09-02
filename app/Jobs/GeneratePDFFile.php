<?php

namespace App\Jobs;

use App\Document;
use App\Traits\GetPDFTrait;
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
    use GetPDFTrait;
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Indicate if the job should be marked as failed on timeout.
     *
     * @var bool
     */
    public $failOnTimeout = false;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Document $document,
        public string $folderName
    ) {}

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
