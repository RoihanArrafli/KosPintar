<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penyewa extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'penyewa';

    protected $fillable = [
        'nama_penyewa',
        'email',
        'password',
        'no_telp'
    ];

    protected $hidden = [
        'password',
        'google_id'
    ];
}
