<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifPostVote extends Model
{
    use HasFactory;

    protected $table = 'notif_post_vote';

    protected $fillable = [
        'id_post',
        'id_vote',
        'nik',
    ];
}
