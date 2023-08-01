<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class UserModel extends  Authenticatable

{
    use HasFactory;
    protected $table = 'data_pengguna_jasa';
    protected $fillable = ['nama', 'email', 'password', 'no_telepon', 'hak_akses'];

}
