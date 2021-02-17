<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class PublicAuthorController extends Controller
{
    public function profile(User $user){
    	$posts = $user->posts()->approved()->published()->paginate(6);

    	return view('profile',compact('user','posts'));
    }
}
