<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaJasaModel extends Model
{
    use HasFactory;
    protected  $table = 'data_pengguna_jasa';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_telpon',
        'jenis_pengguna',
        'hak_akses',
    ];

}
