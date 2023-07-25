<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Example extends Model
{
    use HasFactory;

    protected  $table = 'data_user';
    protected $fillable = [
        'username',
        'nama'
    ];
}
