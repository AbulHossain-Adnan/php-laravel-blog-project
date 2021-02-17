<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Image;
use Toastr;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.category.index',['categories' => Category::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'name' => 'required | unique:categories',
            'image' => 'mimes:jpg,jpeg,png'
        ]);
        // image get from form
        $image = $request->file('image');
        $slug = Str::slug($request->name);
        if(isset($image)){
            // unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            // // check directory exist or not 
            // if(!Storage::disk('public')->exists('category')){
            //     Storage::disk('public')->makeDirectory('category');
            // }
            $imgUrl1 = base_path('public/uploads/categories/'.$imageName);
            Image::make($image)->resize(1600,479)->save($imgUrl1);
            // // check image slider directory exist or not 
            // if(!Storage::disk('public')->exists('category/slider')){
            //     Storage::disk('public')->makeDirectory('category/slider');
            // }
            $imgUrl2 = base_path('public/uploads/categories/slider/'.$imageName);
            Image::make($image)->resize(500,333)->save($imgUrl2);



        }else{
            $imageName='default.png';
        }
        Category::insert([
            'name'=> $request->name,
            'slug'=> $slug,
            'image'=> $imageName,
            'created_at'=> Carbon::now()
        ]);
        Toastr::success('Category Added Successfully!','Category Added');
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:jpg,jpeg,png'
        ]);
        $image = $request->file('image');
        $slug = Str::slug($request->name);
        if(isset($image)){
            if(Category::find($id)->image != 'default.png'){
            unlink(base_path('public/uploads/categories/'.Category::find($id)->image));
            unlink(base_path('public/uploads/categories/slider/'.Category::find($id)->image));
            }

            $currentDate = Carbon::now()->toDateString();
            $imageName=$slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(1600,479)->save(base_path('public/uploads/categories/'.$imageName));
            Image::make($image)->resize(500,333)->save(base_path('public/uploads/categories/slider/'.$imageName));
            Category::find($id)->update([
                'name' => $request->name,
                'slug' => $slug,
                'image' => $imageName
            ]);
        }else{
            Category::find($id)->update([
                'name' => $request->name,
                'slug' => $slug
            ]);

        }
        Toastr::success('Category Updated Successfully!','Category Updated');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->image != 'default.png'){
        unlink(base_path('public/uploads/categories/'.$category->image));
        unlink(base_path('public/uploads/categories/slider/'.$category->image));
        }
        $category->delete();
        Toastr::success('Category Deleted Successfully','Category Deleted');
        return back();
    }
}
