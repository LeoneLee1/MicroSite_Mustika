<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentLike extends Model
{
    use HasFactory;

    protected $table = 'comments_likes';

    protected $fillable = [
        'id_comment',
        'id_post',
        'nik',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }

    public function comment(){
        return $this->belongsTo(Comment::class);
    }
}
