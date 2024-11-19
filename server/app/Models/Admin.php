<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'admin';

    protected $fillable = [
        'nama_admin',
        'email',
        'no_telp',
        'password'
    ];

    protected $hidden = [
        'password'
    ];
}
