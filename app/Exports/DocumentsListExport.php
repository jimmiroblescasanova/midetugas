<?php

declare(strict_types=1);

namespace App\Exports;

use App\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DocumentsListExport implements FromView, ShouldAutoSize
{
    public function __construct(
        public Collection $documents,
        public Project $project,
        public array $columns
    )
    {}

    public function view(): View
    {
        return view('exports.reports.documents-list', [
            'documents' => $this->documents,
            'project' => $this->project,
            'columns' => $this->columns,
        ]);
    }
}
