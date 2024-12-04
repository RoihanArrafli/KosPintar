<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penyewa extends Model
{
    use HasApiTokens, HasFactory, CanResetPassword;

    protected $table = 'penyewa';

    protected $fillable = [
        'name',
        'email',
        'password',
        'no_telp'
    ];

    protected $hidden = [
        'password',
        'google_id'
    ];
}
