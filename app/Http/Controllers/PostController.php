<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;
use Session;

class PostController extends Controller
{

	public function index(){
		$posts = Post::approved()->published()->latest()->paginate(6);
		return view('all_post',compact('posts'));
	}

	public function show($id){
		$post = Post::where('id',$id)->approved()->published()->first();

		$blogKey = 'blog-'.$id;
		if(!Session::has($blogKey)){
			$post->increment('view_count');
			Session::put($blogKey, 1);
		}
		
		
		if(Post::approved()->published()->get()->count()){
			$randomPosts = Post::approved()->published()->take(3)->inRandomOrder()->get();
		}else{
			$randomPosts = Post::approved()->published()->get();
		}
		return view('post',compact('post','randomPosts'));
	}

	public function categoryPost(Category $category){
		$posts = $category->posts()->approved()->published()->paginate(2);
		return view('category_post',compact('category','posts'));
	}
	public function tagPost(Tag $tag){
		$posts = $tag->posts()->approved()->published()->paginate(2);
		return view('tag_post',compact('tag','posts'));
	}

}

