<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Subscriber;
use Toastr;

class SubscriberController extends Controller
{
    public function index(){
    	$subscribers = Subscriber::latest()->get();
    	return view('admin.subscriber.index',compact('subscribers'));
    }
    public function destroy(Subscriber $subscriber){
    	$subscriber->delete();
    	Toastr::success('Delete successfully!','Deleted');
    	return back();

    }
}
