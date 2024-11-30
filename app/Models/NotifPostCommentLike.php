<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifPostCommentLike extends Model
{
    use HasFactory;

    protected $table = 'notif_post_commentLike';

    protected $fillable = [
        'id_post',
        'nik',
    ];
}
