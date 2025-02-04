<?php

namespace App\Models;

use App\Models\PostLike;
use App\Models\AnswerVote;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'nik',
        'unit',
        'password',
        'gender',
        'role',
        'foto',
    ];

    public function hasLiked($postId)
    {
        return $this->likes()->where('id_post', $postId)->exists();
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class, 'nik', 'nik');
    }
}
