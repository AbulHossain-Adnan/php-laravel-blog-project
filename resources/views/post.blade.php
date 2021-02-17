@extends('layouts.frontend.app')

@section('title',)

@push('css')
<link href="{{ asset('assets/frontend/css/post') }}/styles.css" rel="stylesheet">

<link href="{{ asset('assets/frontend/css/post') }}/responsive.css" rel="stylesheet">
<style>
	.favourite{
		color:red;
	}
	.slider{ height: 400px; width: 100%; background-size: cover; margin: 0;
		background-image: url({{ asset('uploads/post') }}/{{ $post->image }}); }  

		.slider .title{ color: #fff; text-shadow: 2px 2px 10px rgba(0,0,0,.3); }
	</style>

	@endpush

	@section('frontendContant')

	<div class="slider">
		<div class="display-table  center-text">
			<h1 class="title display-table-cell"><b></b></h1>
		</div>
	</div><!-- slider -->

	<section class="post-area section">
		<div class="container">

			<div class="row">

				<div class="col-lg-8 col-md-12 no-right-padding">

					<div class="main-post">

						<div class="blog-post-inner">

							<div class="post-info">

								<div class="left-area">
									<a class="avatar" href="{{ route('profile.show',['user'=>$post->user->id,'username'=>$post->user->username]) }}"><img src="{{ asset('uploads/user') }}/{{ $post->user->image }}" alt="Profile Image"></a>
								</div>

								<div class="middle-area">
									<a class="name" href="#"><b>{{ $post->user->name }}</b></a>
									<h6 class="date">{{ $post->created_at->diffForHumans() }}</h6>
								</div>

							</div><!-- post-info -->
							{{-- <div class="post-image"><img src="{{ asset('uploads/post') }}/{{ $post->image }}" alt="Blog Image"></div> --}}

							<h3 class="title"><a href="#"><b>{{ $post->title }}</b></a></h3>

							<div class="para">{!! html_entity_decode($post->body) !!}</div>




							<ul class="tags">
								@foreach ($post->tags as $tag)
								<li><a href="{{ route('tag.posts',['tag'=>$tag->id,'slug'=>$tag->slug]) }}">{{ $tag->name }}</a></li>
								@endforeach
							</ul>
						</div><!-- blog-post-inner -->

						<div class="post-icons-area">
							<ul class="post-icons">
								<li>
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
								<li><a href="#"><i class="ion-chatbubble"></i>{{ $post->comments->count() }}</a></li>
								<li><a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>

							</ul>

							<ul class="icons">
								<li>SHARE : </li>
								<li><a href="#"><i class="ion-social-facebook"></i></a></li>
								<li><a href="#"><i class="ion-social-twitter"></i></a></li>
								<li><a href="#"><i class="ion-social-pinterest"></i></a></li>
							</ul>
						</div>



					</div><!-- main-post -->
				</div><!-- col-lg-8 col-md-12 -->

				<div class="col-lg-4 col-md-12 no-left-padding">

					<div class="single-post info-area">

						<div class="sidebar-area about-area">
							<h4 class="title"><b>ABOUT AUTHOR</b></h4>
							<p>{{ $post->user->about }}</p>
						</div>

						<div class="sidebar-area subscribe-area">

							<h4 class="title"><b>SUBSCRIBE</b></h4>
							<div class="input-area">
								<form action="{{ route('frontendsubscriber.store') }}" method="post">
									@csrf
									<input name="email" class="email-input p-3" type="email" placeholder="Enter your email">
									<button class="submit-btn" type="submit"><i class="icon ion-ios-email-outline"></i></button>
								</form>
							</div>

						</div><!-- subscribe-area -->

						<div class="tag-area">

							<h4 class="title"><b>CATEGORIES</b></h4>
							<ul>
								@foreach ($post->categories as $category)
								<li><a href="{{ route('category.posts',['category' => $category->id,'slug'=>$category->slug]) }}">{{ $category->name }}</a></li>
								@endforeach

							</ul>

						</div><!-- subscribe-area -->

					</div><!-- info-area -->

				</div><!-- col-lg-4 col-md-12 -->

			</div><!-- row -->

		</div><!-- container -->
	</section><!-- post-area -->


	<section class="recomended-area section">
		<div class="container">
			<div class="row">
				@foreach ($randomPosts as $randomPost)



				<div class="col-lg-4 col-md-6">
					<div class="card h-100">
						<div class="single-post post-style-1">

							<div class="blog-image"><img src="{{ asset('uploads/post') }}/{{ $randomPost->image }}" alt="Blog Image"></div>

							<a class="avatar" href="{{ route('profile.show',['user'=>$randomPost->user->id,'username'=>$randomPost->user->username]) }}"><img src="{{ asset('uploads/user') }}/{{ $randomPost->user->image }}" alt="Profile Image"></a>

							<div class="blog-info">

								<h4 class="title"><a href="{{ route('post.show',['id'=>$randomPost->id,'randomPost=>$randomPost->slug']) }}"><b>{{ $randomPost->title }}</b></a></h4>

								<ul class="post-footer">
									<li>
										@guest
										<a href="javascript:void(0);" onclick="toastr['error']('You Need To Login First')
										toastr.options = {
											'closeButton': true,
											'newestOnTop': true,
											'progressBar': true,
											'positionClass': 'toast-top-center'
										}"><i class="ion-heart"></i>{{ $randomPost->favouriteToUsers->count() }}</a>
										@else

										<a class="{{ Auth::user()->favouritePosts->where('pivot.post_id',$randomPost->id)->count() != 0 ? 'favourite' : '' }}" href="javascript:void(0);" onclick="
										document.getElementById('favourite-form-{{ $randomPost->id }}').submit();"><i class="ion-heart"></i>{{ $randomPost->favouriteToUsers->count() }}</a>
										<form id="favourite-form-{{ $randomPost->id }}" action="{{ route('favourite.post',$randomPost->id) }}" method="post">
											@csrf

										</form>
										@endguest
									</li>
									<li><a href="{{ route('post.show',['id'=>$randomPost->id,'randomPost=>$randomPost->slug']) }}"><i class="ion-chatbubble"></i>{{ $randomPost->comments->count() }}</a></li>
									<li><a href="{{ route('post.show',['id'=>$randomPost->id,'randomPost=>$randomPost->slug']) }}"><i class="ion-eye"></i>{{ $randomPost->view_count }}</a></li></ul>
								</ul>

							</div><!-- blog-info -->
						</div><!-- single-post -->
					</div><!-- card -->
				</div><!-- col-md-6 col-sm-12 -->

				@endforeach	

			</div><!-- row -->

		</div><!-- container -->
	</section>

	<section class="comment-section">
		<div class="container">
			<h4><b>POST COMMENT</b></h4>
			<div class="row">

				<div class="col-lg-8 col-md-12">
					<div class="comment-form">
						<form method="post" action="{{ route('comment.store',$post->id) }}">
							<div class="row">
							@csrf
							

								<div class="col-sm-12">
									<textarea name="comment" rows="2" class="text-area-messge form-control"
									placeholder="Enter your comment" aria-required="true" aria-invalid="false"></textarea >
								</div><!-- col-sm-12 -->
								<div class="col-sm-12">
									<button class="submit-btn" type="submit" id="form-submit"><b>POST COMMENT</b></button>
								</div><!-- col-sm-12 -->

							</div><!-- row -->
						</form>
					</div><!-- comment-form -->

					<h4><b>COMMENTS({{ $post->comments->count() }})</b></h4>

					@foreach ($post->comments as $comment)
						{{-- expr --}}
					

					<div class="commnets-area ">

						<div class="comment">

							<div class="post-info">

								<div class="left-area">
									<a class="avatar" href="#"><img src="{{ asset('uploads/user') }}/{{ $comment->user->image }}" alt="Profile Image"></a>
								</div>

								<div class="middle-area">
									<a class="name" href="#"><b>{{ $comment->user->name }}</b></a>
									<h6 class="date">on {{ $comment->created_at->diffForHumans() }}</h6>
								</div>

								<div class="right-area">
									<h5 class="reply-btn" ><a href="#"><b>REPLY</b></a></h5>
								</div>

							</div><!-- post-info -->

							<p>{{ $comment->comment }}</p>

						</div>

					</div><!-- commnets-area -->
@endforeach

					</div><!-- col-lg-8 col-md-12 -->

				</div><!-- row -->

			</div><!-- container -->
		</section>

		@endsection

		