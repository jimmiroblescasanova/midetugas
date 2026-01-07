<?php

namespace App\Http\Livewire\Tables;

use App\Payment;
use Illuminate\View\View;
use Livewire\Component;
use App\Traits\WithSorting;
use App\Traits\WithSearching;
use App\Exports\PaymentListExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;

class Payments extends Component
{
    use WithSorting;
    use WithSearching;

    public $startDate = null;
    public $endDate = null;

    public function mount(): void
    {
        $this->sortField = 'id';
        $this->sortDirection = 'desc';
    }

    public function clear(): void
    {
        $this->reset([
            'search',
            'perPage',
            'startDate',
            'endDate',
        ]);
        $this->resetPage();
        $this->emit('ClearDates');
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportSearch(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $filename = 'pagos_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(
            new PaymentListExport(
                search: $this->search,
                startDate: $this->startDate,
                endDate: $this->endDate,
                sortField: $this->sortField,
                sortDirection: $this->sortDirection,
            ),
            $filename
        );
    }

    public function render(): View
    {
        $payments = Payment::withClientName()
            ->search($this->search)
            ->when($this->endDate != null, function ($q) {
                $q->whereBetween('date', [$this->startDate, $this->endDate]);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.tables.payments', compact('payments'));
    }
}
