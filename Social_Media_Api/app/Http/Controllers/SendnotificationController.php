<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Postreaction;
use App\Models\Reaction;
use App\Models\Reply;
use App\Models\Replyreaction;
use App\Notifications\CommentNotification;
use App\Notifications\PostNotification;
use App\Notifications\ReactionNotification;
use App\Notifications\ReplyNotification;
use App\Notifications\ReplyreactionNotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class SendnotificationController extends Controller
{
    //
  // post reaction
    public static function postnotification(Request $request ,Postreaction $postreaction)
    {
        $user=$request->user();
        $arr=[];
        $arr['user_name']=$user->name;
        $arr['post_id']=$postreaction->post->post_id;
        $arr['react']=$postreaction->react;
        $user->notify(new PostNotification($arr));

    }
  // comment
  public static function commentnotification(Request $request,Comment $comment)
  {
    $user=$request->user();
    $arr=[];
    $arr['user_name']=$user->name;
    $arr['post_id']=$comment->post->post_id;
    $arr['comment']=$comment->id;
    $user->notify(new CommentNotification($arr));

  }
  //reply
  public static function replynotification(Request $request,Reply $reply,$user)
  {

    $arr=[];
    $arr['user_name']=$user->name;
    $arr['post_id']=$reply->comment->comment_id;
    $arr['reply']=$reply->id;
    $user->notify(new ReplyNotification($arr));

  }

  //comment reaction
  public static function commentreactnotification(Request $request ,Reaction $reaction,$user)
  {

      $arr=[];
      $arr['user_name']=$user->name;
      $arr['comment_id']=$reaction->comment->comment_id;
      $arr['react']=$reaction->react;
      $user->notify(new ReactionNotification($arr));

  }
  // reply reaction
  public static function replyreactnotification(Request $request ,Replyreaction $reaction,$user)
  {
      $user=$request->user();
      $arr=[];
      $arr['user_name']=$user->name;
      $arr['reply_id']=$reaction->reply->reply_id;
      $arr['react']=$reaction->react;
      $user->notify(new ReplyreactionNotification($arr));

  }
}
