<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunRegis extends Model
{
    use HasFactory;

    protected $table = 'akun_regis';

    protected $fillable = [
        'nama',
        'nik',
        'unit',
        'no_hp',
        'sofdel',
    ];
}
