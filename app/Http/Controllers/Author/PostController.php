<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Auth;
use App\Tag;
use App\Category;
use Carbon\Carbon;
use Str;
use Image;
use Toastr;
use App\User;
use Notification;
use App\Notifications\NewAuthorPost;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Auth::user()->posts()->latest()->get();
        return view('author.post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     $categories = Category::all();
     $tags = Tag::all();
     return view('author.post.create',compact('categories','tags'));
 }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'categories'=>'required',
            'tags'=>'required',
            'body'=>'required'
        ]);
        $image = $request->file('image');
        $slug = Str::slug($request->title);
        if($image){
            $currentTime = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentTime.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(1600,1066)->save(base_path('public/uploads/post/'.$imageName));
            Image::make($image)->resize(1600,600)->save(base_path('public/uploads/post/slider/'.$imageName));
        }else{
            $imageName='default.png';
        }
        if(isset($request->status)){
            $status = true;
        }else{
            $status = false;
        }
        $postId = Post::insertGetId([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => $slug,
            'image' => $imageName,
            'body' => $request->body,
            'status' => $status,
            'is_approved' => false,
            'created_at' => Carbon::now()
        ]);
        $post = Post::find($postId);
        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        // send notification start
        $users = User::where('role_id',1)->get();
        Notification::send($users,new NewAuthorPost($post));
        // send notification end
        Toastr::success('Post addedd successfully','Success');
        return redirect()->route('author.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if($post->user_id != Auth::id()){
            Toastr::error('Access denaid','Denied');
            return back();
        }
        return view('author.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if($post->user_id != Auth::id()){
            Toastr::error('Access denaid','Denied');
            return back();
        }
        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.edit',compact('post','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'=>'required',
            'categories'=>'required',
            'image'=>'image',
            'tags'=>'required',
            'body'=>'required'
        ]);
        $image = $request->file('image');
        $slug = Str::slug($request->title);
        if($image){
            if($post->image != 'default.png'){
                unlink(base_path('public/uploads/post/'.$post->image));
                unlink(base_path('public/uploads/post/slider/'.$post->image));
            }
            $currentTime = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentTime.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(1600,1066)->save(base_path('public/uploads/post/'.$imageName));
            Image::make($image)->resize(1600,1066)->save(base_path('public/uploads/post/slider/'.$imageName));
        }else{
            $imageName=$post->image;
        }
        if(isset($request->status)){
            $status = true;
        }else{
            $status = false;
        }

        $post->update([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => $slug,
            'image' => $imageName,
            'body' => $request->body,
            'status' => $status,
            'is_approved' => false
        ]);
        Post::find($post->id)->categories()->sync($request->categories);
        Post::find($post->id)->tags()->sync($request->tags);
        Toastr::success('Post updated successfully','Updated');
        return redirect()->route('author.post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if($post->user_id != Auth::id()){
            Toastr::error('Access denaid','Denied');
            return back();
        }
        if($post->image != 'default.png'){
            if(base_path('public/uploads/post/'.$post->image)){
                unlink(base_path('public/uploads/post/'.$post->image));
                unlink(base_path('public/uploads/post/slider/'.$post->image));
            }
        }
        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();
        Toastr::success('Deleted Successfully!','Deleted');
        return back();
    }
}
