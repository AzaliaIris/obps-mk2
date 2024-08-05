<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\MasterRincian;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MasterRincianImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new MasterRincian([
            'kode' => $row['kode'],
            'keg' => $row['keg'],
            'rk' => $row['rk'],
            'iki' => $row['iki'],
            'uraian_kegiatan' => $row['uraian_kegiatan'],
            'uraian_rencana_kinerja' => $row['uraian_rencana_kinerja'],
        ]);
    }
}
