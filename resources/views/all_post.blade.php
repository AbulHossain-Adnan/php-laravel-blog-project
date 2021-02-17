@extends('layouts.frontend.app')

@section('title',)

@push('css')
<link href="{{ asset('assets/frontend/css/category') }}/styles.css" rel="stylesheet">

<link href="{{ asset('assets/frontend/css/category') }}/responsive.css" rel="stylesheet">
<style>
	.favourite{
		color:red;
	}
	.slider{ height: 400px; width: 100%; background-size: cover; margin: 0;
		background-image: url({{ asset('assets/frontend/images/category.jpg') }}); }  

		.slider .title{ color: #fff; text-shadow: 2px 2px 10px rgba(0,0,0,.3); }
	</style>

	@endpush

	@section('frontendContant')

	<div class="slider display-table center-text">
		<h1 class="title display-table-cell"><b>ALL POSTS</b></h1>
	</div><!-- slider -->

	<section class="blog-area section">
		<div class="container">

			<div class="row">

				@foreach ($posts as $post)
					{{-- expr --}}
				

				<div class="col-lg-4 col-md-6">
					<div class="card h-100">
						<div class="single-post post-style-1">

							<div class="blog-image"><img src="{{ asset('uploads/post') }}/{{ $post->image }}" alt="Blog Image"></div>

							<a class="avatar" href="{{ route('profile.show',['user'=>$post->user->id,'username'=>$post->user->username]) }}"><img src="{{ asset('uploads/user') }}/{{ $post->user->image }}" alt="Profile Image"></a>

							<div class="blog-info">

								<h4 class="title"><a href="{{ route('post.show',['slug' => $post->slug,'id' => $post->id]) }}"><b>{{ $post->title }}</b></a></h4>

								<ul class="post-footer"><li>
									@guest
									<a href="javascript:void(0);" onclick="toastr['error']('You Need To Login First')
									toastr.options = {
										'closeButton': true,
										'newestOnTop': true,
										'progressBar': true,
										'positionClass': 'toast-top-center'
									}"><i class="ion-heart"></i>{{ $post->favouriteToUsers->count() }}</a>
									@else

									<a class="{{ Auth::user()->favouritePosts->where('pivot.post_id',$post->id)->count() != 0 ? 'favourite' : '' }}" href="javascript:void(0);" onclick="
									document.getElementById('favourite-form-{{ $post->id }}').submit();"><i class="ion-heart"></i>{{ $post->favouriteToUsers->count() }}</a>
									<form id="favourite-form-{{ $post->id }}" action="{{ route('favourite.post',$post->id) }}" method="post">
										@csrf

									</form>
									@endguest
								</li>
								<li><a href="{{ route('post.show',['id'=>$post->id,'post=>$post->slug']) }}"><i class="ion-chatbubble"></i>{{ $post->comments->count() }}</a></li>
								<li><a href="{{ route('post.show',['id'=>$post->id,'post=>$post->slug']) }}"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>
								</ul>

							</div><!-- blog-info -->
						</div><!-- single-post -->
					</div><!-- card -->
				</div><!-- col-lg-4 col-md-6 -->
				@endforeach

			</div><!-- row -->
			{{ $posts->links() }}

		

		</div><!-- container -->
	</section><!-- section -->

	

	@endsection