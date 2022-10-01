<?php

namespace App\Imports;

use App\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ClientsImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Client([
            'name' => $row[0],
            'shortName' => $row[1],
            'rfc' => $row[2],
            'email' => $row[3],
            'reference' => $row[4],
            'country_code' => $row[5],
            'phone' => $row[6],
            'line_1' => $row[7],
            'line_2' => $row[8],
            'line_3' => $row[9],
            'locality' => $row[10],
            'city' => $row[11],
            'state_province' => $row[12],
            'country' => $row[13],
            'zipcode' => $row[14],
            'ref1_name' => $row[15],
            'ref1_phone' => $row[16],
            'ref2_name' => $row[17],
            'ref2_phone' => $row[18],
        ]);
    }
}
