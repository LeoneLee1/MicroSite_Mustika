<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'id_post',
        'nik',
        'comment',
        'clip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }
}
