<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'user_id','post_id','comment_id', 'comment',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id');
    }   

    public function likes()
    {
        return $this->hasMany('App\CommentLikeDislike', 'comment_id')->where('like',1);
    }     
    public function dislikes()
    {
        return $this->hasMany('App\CommentLikeDislike', 'comment_id')->where('dislike',1);
    }  

    public function childComments()
    {
        return $this->hasMany('App\Comment','comment_id','id');
    }      

     public function parentComment()
    {
        return $this->belongsTo('App\Comment','comment_id');
    }                                          
}
