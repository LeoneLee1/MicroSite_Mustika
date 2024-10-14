<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReplies extends Model
{
    use HasFactory;

    protected $table = 'comments_replies';

    protected $fillable = [
        'id_comment',
        'id_post',
        'nik',
        'comment',
        'likes',
    ];
}
