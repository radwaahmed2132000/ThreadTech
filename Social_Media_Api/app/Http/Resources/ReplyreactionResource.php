<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Models\Reply;
class ReplyreactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  ['react'=>$this->react,
        'User'=> new UserResource(User::find($this->user_id)),
        'Reply'=> new CommentResource(Reply::find($this->post_id))
      ];
    }
}
