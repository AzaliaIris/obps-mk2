<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bobot extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi
    protected $table = 'bobot';

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'bobot_id', 'satuan', 'nilai' // dan kolom lain jika diperlukan
    ];

    // Set the primary key
    protected $primaryKey = 'bobot_id';

    public $timestamps = false;
}
