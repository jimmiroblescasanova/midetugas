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
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class EdcExportReport implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting, WithEvents
{
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells('B2:E2');
            }
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'B2' => ['font' => ['bold' => true, 'size' => 16]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function view(): View
    {

        if($this->request['all'] == 1) {
            $clients = Client::select('id', 'rfc', 'name')
            ->with(['documents' => function($q){
                $q->where('pending', '>', 0.01)
                ->whereMonth('date', '>=', $this->request->month)
                ->whereYear('date', '>=', $this->request->year);
            }])
            ->get();
        } else {
            $clients = Client::where('id', $this->request->client)
            ->select('id', 'rfc', 'name')
            ->with(['documents' =>
                function($q){
                $q->where('pending', '>', 0.01)
                ->whereMonth('date', '>=', $this->request->month)
                ->whereYear('date', '>=', $this->request->year);
            }])
            ->get();
        }


        return view('exports.reports.edc', [
            'clients' => $clients,
        ]);
    }
}
