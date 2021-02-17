<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Image;
use Toastr;
use Auth;
use Hash;

class SettingsController extends Controller
{
    
	public function index(){
		return view('author.settings.index');
	}
	public function updateProfile(Request $request,User $user){
		$request->validate([
			'name' => 'required',
			'image' => 'required|image',
			'about' => 'required'
		]);

		if($user->image != 'default.png'){
			unlink(base_path('public/uploads/user/'.$user->image));
		}

		$image = $request->file('image');
		$imageName = $user->id.'.'.$image->getClientOriginalExtension();
		Image::make($image)->resize(500,600)->save(base_path('public/uploads/user/'.$imageName));

		$user->update([
			'name' => $request->name,
			'image' => $imageName,
			'about' => $request->about
		]);
		Toastr::success('Profile Updated Successfully!','Updated');
		return back();
	}

	public function updatePassword(Request $request,User $user){
		$request->validate([
			'old_password' => 'bail | required',
			'password' => 'required | confirmed'
		]);
		if(Hash::check($request->old_password,$user->password)){
			if(!Hash::check($request->password, $user->password)){
				if(isset($request->check)){
					Auth::logoutOtherDevices($request->old_password);
				}
				$user->password = Hash::make($request->password);
				$user->save();
				Toastr::success('Password updated successfuly!','Updated');
				Auth::logout();
				return back();
			}else{
				Toastr::warning('You cant set current password as new password','Warning!');
				return back();
			}
		}else{
			Toastr::error('Your current password is wrong','Wrong Password');
			return back();
		}

	}
}
