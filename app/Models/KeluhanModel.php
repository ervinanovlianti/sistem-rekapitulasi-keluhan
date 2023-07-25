<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluhanModel extends Model
{
    use HasFactory;

    protected  $table = 'data_keluhan';

    protected $fillable = [
        'id_keluhan',
        'tgl_keluhan',
        'id_pengguna',
        'via_keluhan',
        'uraian_keluhan',
        'kategori_id',
        'penanggungjawab',
        'waktu_penyelesaian',
        'aksi',
        'status_keluhan'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
