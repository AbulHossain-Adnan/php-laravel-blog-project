<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class DashboardController extends Controller
{
    public function index(){
    	$author = Auth::user();
    	$popularPosts = $author->posts()->approved()->published()->withCount('comments')
    	->orderBy('view_count','desc')->orderBy('comments_count','desc')->take(2)->get();
    	$pending_post = $author->posts()->where('is_approved',0)->get();
    	return view('author.dashboard',compact('author','popularPosts','pending_post'));

    }
}
