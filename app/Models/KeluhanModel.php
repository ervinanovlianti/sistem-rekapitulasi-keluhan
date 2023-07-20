<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluhanModel extends Model
{
    use HasFactory;

    protected  $table = 'data_keluhan';

    protected $fillable = [
        'tgl_keluhan',
        'id_pengguna',
        'via_keluhan',
        'uraian_keluhan',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
