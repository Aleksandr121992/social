<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'user_id','post_title', 'post_image','post_image_2','post_image_3','post_description',
    ];

 public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id');
    }    
}
