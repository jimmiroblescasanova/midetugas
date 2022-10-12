<?php

namespace App\Exports;

use App\Client;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ClientsExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return Client::query();
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'shortName',
            'rfc',
            'email',
            'reference',
            'country_code',
            'phone',
            'line_1',
            'line_2',
            'line_3',
            'locality',
            'city',
            'state_province',
            'country',
            'zipcode',
            'ref1_name',
            'ref1_phone',
            'ref2_name',
            'ref2_phone',
        ];
    }

    public function map($client): array
    {
        return [
            $client->id,
            $client->name,
            $client->shortName,
            $client->rfc,
            $client->email,
            $client->reference,
            $client->country_code,
            $client->phone,
            $client->line_1,
            $client->line_2,
            $client->line_3,
            $client->locality,
            $client->city,
            $client->state_province,
            $client->country,
            $client->zipcode,
            $client->ref1_name,
            $client->ref1_phone,
            $client->ref2_name,
            $client->ref2_phone,
        ];
    }
}
