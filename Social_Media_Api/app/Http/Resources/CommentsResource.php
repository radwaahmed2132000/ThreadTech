<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Models\Post;
class CommentsResource extends JsonResource
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
            'Post'=> new PostResource(Post::find($this->post_id))
        ];;
    }
}
