<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifBadge extends Model
{
    use HasFactory;

    protected $table = 'notif_badge';

    protected $fillable = [
        'nik',
        'value',
    ];
}
