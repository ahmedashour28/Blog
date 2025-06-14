<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['title'];


    public function posts(){
        $this->morphByMany('App\Post', 'taggable');
    }

    public function videos(){
        $this->morphByMany('App\Video', 'taggable');
    }
}
