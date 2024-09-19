<?php

namespace App\Models;

use App\Models\PollAnswer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poll extends Model
{
    use HasFactory;

    protected $table = 'polls';

    protected $fillable = [
        'id_post',
        'soal',
        'nik',
    ];

    public function answers()
    {
        return $this->hasMany(PollAnswer::class);
    }
}
