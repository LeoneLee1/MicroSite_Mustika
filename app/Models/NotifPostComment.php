<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifPostComment extends Model
{
    use HasFactory;

    protected $table = 'notif_post_comment';

    protected $fillable = [
        'id_post',
        'nik',
    ];
}
