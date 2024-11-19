<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemilik extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'pemilik';

    protected $fillable = [
        'nama_pemilik',
        'email',
        'password',
        'no_telp'
    ];

    protected $hidden = [
        'password',
        'google_id'
    ];
}
