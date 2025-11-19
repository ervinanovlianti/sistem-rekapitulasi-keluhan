<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    use HasFactory;

    protected  $table = 'data_keluhan';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
