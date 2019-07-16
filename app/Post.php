<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'user_id','post_title', 'post_description',
    ];

 public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id');
    }    

public function images()
    {
        return $this->hasMany('App\Image', 'post_id');
    }     

public function likes()
    {
        return $this->hasMany('App\Post_like_dislike', 'post_id')->where('like',1);
    }     
public function dislikes()
    {
        return $this->hasMany('App\Post_like_dislike', 'post_id')->where('dislike',1);
    } 

public static function boot()
   {
       parent::boot();

       // cause a delete of a product to cascade to children so they are also deleted
       static::deleted(function($post)
       {
           $post->comments()->delete();
           $post->images()->delete();
           $post->likes()->delete();
           $post->dislikes()->delete();
       });
   }              
}
