<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifPost extends Model
{
    use HasFactory;

    protected $table = 'notif_post';

    protected $fillable = [
        'id_post',
        'nik',
    ];
}
