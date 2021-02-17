<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class SearchController extends Controller
{
    public function search(Request $request){
    	$query = $request -> input('query');
    	$posts = Post::where('title', 'like', "%$query%")->approved()->published()
                ->paginate(8);
        return view('search',compact('query','posts'));


    }
}
