<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifPostCommentReplies extends Model
{
    use HasFactory;

    protected $table = 'notif_post_commentbalas';

    protected $fillable = [
        'id_post',
        'nik',
    ];
}
