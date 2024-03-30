<?php

namespace App\Exports;

use App\Client;
use App\Document;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class AccountStatusReport implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    public $data; 

    public function __construct($request)
    {
        $this->data = $request;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function view(): View
    {
        $clients = Client::where('project_id', $this->data['project'])->pluck('id');
        
        $documents = Document::whereIn('client_id', $clients)
            ->whereMonth('date', '<=', $this->data['month'])
            ->whereYear('date', '<=', $this->data['year'])
            ->groupBy('client_id')
            ->selectRaw('client_id, SUM(total) as suma, SUM(pending) as pendiente')
            ->get();

        return view('exports.reports.accountStatus', [
            'documents' => $documents,
        ]);
    }
}
