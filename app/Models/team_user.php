<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class team_user extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi
    protected $table = 'team_user';

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'team_user_id', 'user_id', 'team_id', 'position'
    ];

    // Set the primary key
    protected $primaryKey = 'team_user_id';

    public $timestamps = false;
}
