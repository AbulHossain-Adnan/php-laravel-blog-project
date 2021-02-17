<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Toastr;

class AuthorController extends Controller
{
    public function index(){
    	$authors = User::author()
    	->withCount('posts')
    	->withCount('comments')
    	->get();
    	return view('admin.authors.index',compact('authors'));
    }
    public function destroy(User $user){
    	$user->delete();
    	Toastr::success('Author delete successfully!');
    	return back();
    }
}
