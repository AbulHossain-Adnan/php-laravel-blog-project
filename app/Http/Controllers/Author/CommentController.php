<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comment;
use Toastr;
use Auth;
class CommentController extends Controller
{
    public function index(){
    	$posts = Auth::user()->posts()->approved()->published()->get();
    	return view('author.comment.index',compact('posts'));
    }
    public function destroy(Comment $comment){
    	if($comment->post->user->id != Auth::id()){
    		Toastr::error('Access denaid!');
    		return back();
    	}
    	$comment->delete();
    	Toastr::success('Delete Successfully');
    	return back();

    }
}
