<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKegiatan extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi
    protected $table = 'master_kegiatan';

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'kegiatan_id', 'kode', 'klp', 'fung', 'sub', 'no', 'keterangan' // dan kolom lain jika diperlukan
    ];

    // Set the primary key
    protected $primaryKey = 'kegiatan_id';

    public $timestamps = false;
}
