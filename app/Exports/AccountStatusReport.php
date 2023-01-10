<?php

namespace App\Exports;

use App\Document;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

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
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function view(): View
    {
        $documents =  Document::where('status', 2)
            ->whereIn('client_id', $this->data['clients'])
            ->whereMonth('date', '<=', $this->data['month'])
            ->whereYear('date', '<=', $this->data['year'])
            ->with('client')
            ->get();

        return view('exports.reports.accountStatus', [
            'documents' => $documents,
        ]);
    }
}
