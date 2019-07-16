<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

	protected $fillable = [
	    'post_id', 'path',
	];

	public function post()
    {
        return $this->belongsTo('App\Post', 'post_id');
    }
}


