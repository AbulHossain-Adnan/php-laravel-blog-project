@extends('layouts.frontend.app')

@section('title','Home')

@push('css')
<link href="{{ asset('assets/frontend/css/home/styles.css') }}" rel="stylesheet">

<link href="{{ asset('assets/frontend/css/home/responsive.css') }}" rel="stylesheet">
<style>
    .favourite{
        color:red;
    }
</style>
@endpush

@section('frontendContant')

<div class="main-slider">
    <div class="swiper-container position-static" data-slide-effect="slide" data-autoheight="false"
    data-swiper-speed="500" data-swiper-autoplay="10000" data-swiper-margin="0" data-swiper-slides-per-view="4"
    data-swiper-breakpoints="true" data-swiper-loop="true" >
    <div class="swiper-wrapper">

        @foreach ($categories as $category)

        <div class="swiper-slide">
            <a class="slider-category" href="{{ route('category.posts',['category' => $category->id,'slug' => $category->slug]) }}">
                <div class="blog-image"><img src="{{ asset('uploads/categories/slider') }}/{{ $category->image }}" alt="Blog Image"></div>

                <div class="category">
                    <div class="display-table center-text">
                        <div class="display-table-cell">
                            <h3><b>{{ $category->name }}</b></h3>
                        </div>
                    </div>
                </div>

            </a>
        </div><!-- swiper-slide -->
        @endforeach

    </div><!-- swiper-wrapper -->

</div><!-- swiper-container -->

</div><!-- slider -->

<section class="blog-area section">
    <div class="container">

        <div class="row">

            @foreach ($posts as $post)

            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <div class="single-post post-style-1">

                        <div class="blog-image"><img src="{{ asset('uploads/post') }}/{{ $post->image }}" alt="{{ $post->slug }}"></div>

                        <a class="avatar" href="{{ route('profile.show',['user'=>$post->user->id,'username'=>$post->user->username]) }}"><img src="{{ asset('uploads/user') }}/{{ $post->user->image }}" alt="Profile Image"></a>

                        <div class="blog-info">

                            <h4 class="title"><a href="{{ route('post.show',['id'=>$post->id,'slug'=>$post->slug]) }}"><b>{{ $post->title }}</b></a></h4>

                            <ul class="post-footer">
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
                             <li><a href="{{ route('post.show',['slug'=>$post->slug,'id'=>$post->id]) }}"><i class="ion-chatbubble"></i>{{ $post->comments->count() }}</a></li>
                             <li><a href="{{ route('post.show',['slug'=>$post->slug,'id'=>$post->id]) }}"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>
                         </ul>

                     </div><!-- blog-info -->
                 </div><!-- single-post -->
             </div><!-- card -->
         </div><!-- col-lg-4 col-md-6 -->

         @endforeach

     </div><!-- row -->

     <a class="load-more-btn" href="{{ route('post.index') }}"><b>LOAD MORE</b></a>

 </div><!-- container -->
</section><!-- section -->


@endsection