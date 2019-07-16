<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentLikeDislike extends Model
{
    protected $table = 'comment_like_dislikes';

    protected $fillable = [
        'user_id','post_id','comment_id', 'like','dislike',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

	public function post()
    {
        return $this->belongsTo('App\Post', 'post_id');
    }  

    public function comment()
    {
        return $this->belongsTo('App\Comment', 'comment_id');
    }   
}
