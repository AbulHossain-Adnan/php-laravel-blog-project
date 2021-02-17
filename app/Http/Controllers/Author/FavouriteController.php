<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class FavouriteController extends Controller
{
    public function index(){
    	$posts = Auth::user()->favouritePosts;
    	return view('admin.post.favourite',compact('posts'));
    }
}
