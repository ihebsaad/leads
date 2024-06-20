<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClientsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $columns;

    public function __construct($columns)
    {
        $this->columns = $columns;
    }

    public function query()
    {
        return Client::query()->select($this->columns);
    }

    public function headings(): array
    {
        return $this->columns;
    }

    public function map($client): array
    {
        $data = [];
        foreach ($this->columns as $column) {
            $data[] = $client->$column;
        }
        return $data;
    }
}
