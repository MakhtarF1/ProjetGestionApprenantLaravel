<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FailedApprenantsExport implements FromArray, WithHeadings
{
    protected $failures;

    public function __construct(array $failures)
    {
        $this->failures = $failures;
    }

    public function array(): array
    {
        return collect($this->failures)->map(function ($failure) {
            $row = $failure['row'];
            $row['errors'] = implode(', ', $failure['errors']);
            return $row;
        })->toArray();
    }

    public function headings(): array
    {
        return array_merge(
            array_keys($this->failures[0]['row']),
            ['errors']
        );
    }
}
