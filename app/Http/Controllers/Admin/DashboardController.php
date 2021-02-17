<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Auth;

class DashboardController extends Controller
{
    public function index(){
    	$popularPosts = Post::approved()->published()
    					->withCount('comments')
    					->withCount('favouriteToUsers')
    					->orderBy('view_count','desc')
    					->orderBy('comments_count','desc')
    					->take(5)
    					->get();
    	$pending_post = Post::where('is_approved',0)->count();
    	$totalAuthor = Auth::user()->author()->count();
    	$todaysRegister = Auth::user()->where('created_at',today())->count();
    	return view('admin.dashboard',compact('popularPosts','pending_post','totalAuthor','todaysRegister'));
    }
}
