<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\MasterKegiatan;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MasterKegiatanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new MasterKegiatan([
            'kode' => $row['kode'],
            'klp' => $row['klp'],
            'fung' => $row['fung'],
            'sub' => $row['sub'],
            'no' => $row['no'],
            'keterangan' => $row['keterangan'],
        ]);
    }
}
