<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class UserModel extends  Authenticatable

{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = ['id', 'nama', 'email', 'password', 'no_telepon','jenis_pengguna', 'hak_akses'];

}
