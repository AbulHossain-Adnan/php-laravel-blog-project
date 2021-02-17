<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

// post controller 
Route::get('/post','PostController@index')->name('post.index');
Route::get('/post/{id}','PostController@show')->name('post.show');
// category wise post
Route::get('/category/posts/{category}','PostController@categoryPost')->name('category.posts');
// tag wise post
Route::get('/tag/posts/{tag}','PostController@tagPost')->name('tag.posts');

// comment route
Route::post('comment/{post}','CommentController@store')->name('comment.store');

Route::middleware(['auth'])->group(function(){
	Route::post('favourite/post/{post}','FavouriteController@add')->name('favourite.post');
});

// Search controller route
Route::get('search','SearchController@search')->name('search');

// publicauthor controller
Route::get('profile/{user}','PublicAuthorController@profile')->name('profile.show');



// Admin route

Route::group(['as'=>'admin.','prefix'=>'admin','namespace'=>'Admin','middleware'=>['auth','admin']],function(){
	Route::get('dashboard','DashboardController@index')->name('dashboard');
	// tag controller route
	Route::resource('tag','TagController');
	// category controller route
	Route::resource('category','CategoryController');
	// post controller route
	Route::resource('post','PostController');
	// post approve route
	Route::get('/pending/post','PostController@pending')->name('pending.post');
	Route::put('/approve/post/{post}','PostController@approve')->name('approve.post');

	// settings controller
	Route::get('/settings','SettingsController@index')->name('settings.index');
	Route::put('/profile-update/{user}','SettingsController@updateProfile')->name('settings.update');
	Route::put('/password-update/{user}','SettingsController@updatePassword')->name('settings.update-password');

	// subscriber controller
	Route::get('/subscriber','SubscriberController@index')->name('subscriber.index');
	Route::delete('/subscriber/{subscriber}','SubscriberController@destroy')->name('subscriber.destroy');
	// admin favourite controller
	Route::get('favourite','FavouriteController@index')->name('favourite.index');
	// comment controller for admin
	Route::get('comments','CommentController@index')->name('comment.index');
	Route::delete('comments/{comment}','CommentController@destroy')->name('comment.destroy');
// author controller for admin
	Route::get('authors','AuthorController@index')->name('authors.index');
	Route::delete('authors/{user}','AuthorController@destroy')->name('authors.destroy');

});
Route::group(['as'=>'author.','prefix'=>'author','namespace'=>'Author','middleware'=>['auth','author']],function(){
	Route::get('dashboard','DashboardController@index')->name('dashboard');
	// post controller for author 
	Route::resource('post','PostController');

	// settings controller author
	Route::get('/settings','SettingsController@index')->name('settings.index');
	Route::put('/profile-update/{user}','SettingsController@updateProfile')->name('settings.update');
	Route::put('/password-update/{user}','SettingsController@updatePassword')->name('settings.update-password');
		// authro favourite controller
	Route::get('favourite','FavouriteController@index')->name('favourite.index');
		// comment controller for author
	Route::get('comments','CommentController@index')->name('comment.index');
	Route::delete('comments/{comment}','CommentController@destroy')->name('comment.destroy');

});

// frontendsubscribe controller
Route::post('/subscribe','FrontendSubscriberController@store')->name('frontendsubscriber.store'); 

// composer for footer categories part
View::composer('layouts.frontend.footer',function($view) {
	$categories = App\Category::all();
	$view->with('categories',$categories);
}); 
