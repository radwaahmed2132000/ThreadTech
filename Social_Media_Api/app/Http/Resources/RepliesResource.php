<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Comment;
use App\Models\User;
class RepliesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [

            'Description'=>$this->Description,
            'image'=>$this->image,
            'User'=> new UserResource(User::find($this->user_id)),
            'Post'=> new CommentsResource(Comment::find($this->post_id))
        ];;;
    }
}
