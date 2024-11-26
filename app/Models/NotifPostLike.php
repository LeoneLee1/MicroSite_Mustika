<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifPostLike extends Model
{
    use HasFactory;

    protected $table = 'notif_post_like';

    protected $fillable = [
        'id_post',
        'nik'
    ];

}
