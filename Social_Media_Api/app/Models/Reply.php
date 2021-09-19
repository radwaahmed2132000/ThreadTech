<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\User;
class Reply extends Model
{
    use HasFactory;
    protected $fillable = [
        'Description',
        'image',
        'user_id',
        'comment_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
