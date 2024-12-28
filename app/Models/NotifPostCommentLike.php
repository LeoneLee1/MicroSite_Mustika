<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifPostCommentLike extends Model
{
    use HasFactory;

    protected $table = 'notif_post_commentlike';

    protected $fillable = [
        'id_post',
        'nik',
    ];
}
