<?php

namespace App\Traits;

use Livewire\WithPagination;

/**
 * Trait to control the searching livewire
 */
trait WithSearching
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;

    public function clear()
    {
        $this->reset([
            'search',
            'perPage',
        ]);
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}

