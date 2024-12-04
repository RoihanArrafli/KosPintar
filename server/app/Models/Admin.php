<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasApiTokens, HasFactory, CanResetPassword;

    protected $table = 'admin';

    protected $fillable = [
        'name',
        'email',
        'no_telp',
        'password'
    ];

    protected $hidden = [
        'password'
    ];
}
