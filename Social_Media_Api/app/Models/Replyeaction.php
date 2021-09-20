<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Reply;
class Replyeaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'react',
        'user_id',
        'reply_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reply()
    {
        return $this->belongsTo(Reply::class);
    }
}
