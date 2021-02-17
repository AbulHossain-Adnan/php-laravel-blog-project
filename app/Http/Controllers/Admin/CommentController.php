<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comment;
use Toastr;
class CommentController extends Controller
{
    public function index(){
    	$comments = Comment::latest()->get();
    	return view('admin.comment.index',compact('comments'));
    }
    public function destroy(Comment $comment){
    	$comment->delete();
    	Toastr::success('Delete Successfully');
    	return back();

    }
}
