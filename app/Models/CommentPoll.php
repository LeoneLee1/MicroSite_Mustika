<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentPoll extends Model
{
    use HasFactory;

    protected $table = 'comment_polls';

    protected $fillable = [
        'nik',
        'poll_id',
        'comment',
    ];
}
