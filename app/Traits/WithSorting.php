<?php

namespace App\Traits;

trait WithSorting
{
    public $sortField = '';
    public $sortDirection = 'asc';

    public function sortBy($column)
    {
        if ($this->sortField === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $column;
    }
}
