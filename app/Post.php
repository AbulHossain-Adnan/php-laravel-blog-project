<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $fillable = ['user_id','title','slug','image','body','view_count','status','is_approved'];
    public function user(){
    	return $this->belongsTo('App\User');
    }
    public function categories(){
    	return $this->belongsToMany('App\Category')->withTimestamps();
    }
    public function tags(){
    	return $this->belongsToMany('App\Tag')->withTimestamps();
    }
    public function favouriteToUsers(){
        return $this->belongsToMany('App\User')->withTimestamps();
    }
    public function comments(){
        return $this->hasMany('App\Comment');
    }
     public function scopeApproved($query)
    {
        return $query->where('is_approved', 1);
    }
     public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
}
