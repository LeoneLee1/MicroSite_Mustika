<?php

namespace App\Models;

use App\Models\Poll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PollAnswer extends Model
{
    use HasFactory;

    protected $table = 'poll_answers';

    protected $fillable = [
        'poll_id',
        'jawaban',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
