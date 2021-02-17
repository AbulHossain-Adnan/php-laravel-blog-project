<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Str;
use Auth;
use Carbon\Carbon;
use Image;
use App\Category;
use Illuminate\Http\Request;
use Toastr;
use App\Notifications\AuthorPostAproved;
use App\Notifications\NewPostNotification;
use App\Subscriber;
use Notification;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin.post.index',compact('posts'));
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
        return view('admin.post.create',compact('categories','tags'));
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
            'image' => 'image',
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
            'is_approved' => true,
            'created_at' => Carbon::now()
        ]);
        $post = Post::find($postId); 
        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        // notification to subscriber
        $subscribers = Subscriber::all();
        foreach ($subscribers as $subscriber) {
            Notification::route('mail',$subscriber->email)->notify(new NewPostNotification($post));
            
        }


        Toastr::success('Post addedd successfully','Success');
        return redirect()->route('admin.post.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.edit',compact('post','categories','tags'));       
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
            Image::make($image)->resize(1600,600)->save(base_path('public/uploads/post/slider/'.$imageName));
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
            'is_approved' => true
        ]);
        Post::find($post->id)->categories()->sync($request->categories);
        Post::find($post->id)->tags()->sync($request->tags);
        Toastr::success('Post updated successfully','Updated');
        return redirect()->route('admin.post.index');

    }

    public function pending(){
        $posts = Post::where('is_approved',false)->latest()->get();
        return view('admin.post.pending',compact('posts'));
    }

    public function approve(Post $post){
        if($post->is_approved == false){
            $post->is_approved = true;
            $post->save();
        }
        $post->user->notify(new AuthorPostAproved($post));

        // / notification to subscriber
        $subscribers = Subscriber::all();
        foreach ($subscribers as $subscriber) {
            Notification::route('mail',$subscriber->email)->notify(new NewPostNotification($post));
            
        }
        
        Toastr::success('Post Approved Successfully!','Approved');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
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
