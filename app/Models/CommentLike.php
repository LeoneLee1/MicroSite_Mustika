<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    protected $table = 'comments_likes';

    protected $fillable = [
        'id_comment',
        'nik',
        'comment',
    ];
}
