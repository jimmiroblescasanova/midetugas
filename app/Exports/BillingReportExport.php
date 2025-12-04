<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BillingReportExport implements FromView, ShouldAutoSize
{
    public function __construct(
        public Collection $documents,
        public array $columns
    )
    {}

    public function view(): View
    {
        return view('exports.reports.billing', [
            'documents' => $this->documents,
            'columns' => $this->columns,
        ]);
    }
}
