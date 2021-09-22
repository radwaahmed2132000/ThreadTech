<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Replyreaction;
use App\Models\Reaction;
use App\Models\Postreaction;
use App\Models\Follower;
use App\Models\Following;
use App\Models\Followrequest;
class User extends Authenticatable  implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'mobilephone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
     public function  post()
    {
        # code...
        return $this->hasMany(Post::class);
    }
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
    public function reply()
    {
        return $this->hasMany(Reply::class);
    }
     public function reaction()
    {
        return $this->hasMany(Reaction::class);

    }
    public function postreaction()
    {
        return $this->hasMany(Postreaction::class);

    }
    public function replyreaction()
    {
        return $this->hasMany(Replyreaction::class);
    }
    public function follower()
    {
        return $this->hasMany(Follower::class);
    }
    public function following()
    {
     return $this->hasMany(Following::class);
    }
    public function followrequest()
    {
        return $this->hasMany(Followrequest::class);
    }
}
