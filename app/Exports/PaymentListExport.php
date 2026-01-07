<?php

namespace App\Exports;

use App\Payment;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PaymentListExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    use Exportable;

    public function __construct(
        protected ?string $search = null,
        protected ?string $startDate = null,
        protected ?string $endDate = null,
        protected string $sortField = 'id',
        protected string $sortDirection = 'desc'
    ) {}

    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        return Payment::withClientName()
            ->search($this->search)
            ->when($this->endDate != null, function ($q) {
                $q->whereBetween('date', [$this->startDate, $this->endDate]);
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Fecha de aplicación',
            'Fecha de captura',
            'Cliente',
            'Condominio',
            'Departamento',
            'Importe',
        ];
    }

    public function map($row): array
    {
        // Nota: $payment trae join con clients y tiene relación client() disponible.
        return [
            $row->id,
            optional($row->date)->format('d/m/Y'),
            optional($row->created_at)->format('d/m/Y'),
            $row->name ?? optional($row->client)->name,
            optional($row->client)->line_2 ?? '',
            optional($row->client)->line_3 ?? '',
            $row->amount == 0 ? '0.00' : number_format($row->amount, 2, '.', ''),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => '#,##0.00', // Formato numérico que siempre muestra el 0
        ];
    }
}
