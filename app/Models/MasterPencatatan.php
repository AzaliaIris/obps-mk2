<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPencatatan extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi
    protected $table = 'master_pencatatan';

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'pencatatan_id', 'user_id', 'kegiatan_id', 'bobot_id', 'rincian_id', 'volume', 'waktu_mulai', 'waktu_selesai', 'jam', 'total' // dan kolom lain jika diperlukan
    ];

    // Set the primary key
    protected $primaryKey = 'pencatatan_id';

    public $timestamps = false;
}
