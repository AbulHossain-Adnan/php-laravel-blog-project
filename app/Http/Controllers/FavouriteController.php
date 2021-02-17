<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Toastr;
class FavouriteController extends Controller
{
    public function add($post){
    	$user = Auth::user();
    	if($user->favouritePosts()->where('post_id',$post)->count() == 0){
    		$user->favouritePosts()->attach($post);
    		Toastr::success("Post added successfully to your favourite","Success");
    		return back();
    	}else{
    		$user->favouritePosts()->detach($post);
    		Toastr::warning("Successfully removed form favourite list",'Info');
    		return back();
    	}
    }
}
