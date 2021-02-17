<?php

namespace App\Http\Controllers;

// use Toastr;
use Carbon\Carbon;
use App\Subscriber;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class FrontendSubscriberController extends Controller
{
    public function store(Request $request){
    	$request->validate([
    		'email' => 'required | email | unique:subscribers'
    	]);
    	Subscriber::insert([
    		'email' => $request->email,
    		'created_at' => Carbon::now()
    	]);
		Toastr::success('Subscribe blog successfully!','Subscribed');
    	return back();
    }
}
