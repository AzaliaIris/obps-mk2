<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRincian extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi
    protected $table = 'master_rincian';

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'rincian_id', 'kode', 'keg', 'rk', 'iki', 'uraian_kegiatan', 'uraian_rencana_kinerja' // dan kolom lain jika diperlukan
    ];

    // Set the primary key
    protected $primaryKey = 'rincian_id';

    public $timestamps = false;
}
