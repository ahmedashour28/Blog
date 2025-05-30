<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Photo;
use App\Tag;


class Post extends Model
{
    //

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function photos(){
        return $this->morphMany('App\Photo', 'imageable');
    }

    public function tags(){
        return $this->morphToMany('App\Tag', 'taggable');
    }



}
