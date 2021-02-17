@extends('layouts.backend.admin_dashboard')

@section('adminDashboard')
@section('title','Dashboard')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>AUTHOR DASHBOARD</h2>
        </div>
        <!-- Widgets -->
        <div class="row clearfix">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">PENDING POST</div>
                        <div class="number count-to" data-from="0" data-to="{{ $pending_post->count() }}" data-speed="10" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- #END# Widgets -->

        <div class="row clearfix">
            <div class="col-xs-12 col-sm-3">
                <div class="card profile-card">
                    <div class="profile-header">&nbsp;</div>
                    <div class="profile-body">
                        <div class="image-area">
                            <img width="130" src="{{ asset('uploads/user') }}/{{ $author->image }}" alt="AdminBSB - Profile Image" />
                        </div>
                        <div class="content-area">
                            <h3>{{ $author->name }}</h3>
                            <p>{{ Str::title($author->role->name) }}</p>
                            
                        </div>
                    </div>
                    <div class="profile-footer">
                        <ul>
                            <li>
                                <span>Post</span>
                                <span>{{ $author->posts->count() }}</span>
                            </li>
                            <li>
                                <span>Favourite</span>
                                <span>{{ $author->favouritePosts->count() }}</span>
                            </li>
                            
                        </ul>

                    </div>
                </div>

                <div class="card card-about-me">
                    <div class="header">
                        <h2>ABOUT ME</h2>
                    </div>
                    <div class="body">
                        <p>{{ $author->about }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-9">
                <div class="card">
                    <div class="body">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>

                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="home">
                                    @foreach ($popularPosts as $popularPost)
                                    {{-- expr --}}
                                    
                                    <div class="panel panel-default panel-post">
                                        <div class="panel-heading">
                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="#">
                                                        <img src="{{ asset('uploads/user') }}/{{ $author->image }}" />
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="media-heading">
                                                        <a href="{{ route('author.post.show',$popularPost->id) }}">{{ Str::title($author->name) }}</a>
                                                    </h4>
                                                    Shared publicly - {{ $popularPost->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="post">
                                                <div class="post-heading">
                                                    <p>{{ $popularPost->title }}</p>
                                                </div>
                                                <div class="post-content">
                                                    <img src="{{ asset('uploads/post') }}/{{ $popularPost->image }}" class="img-responsive" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <ul>
                                                <li>
                                                    <a href="{{ route('author.post.show',$popularPost->id) }}">
                                                        <i class="material-icons">panorama_fish_eye</i>
                                                        <span>{{ $popularPost->view_count }} views</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('author.post.show',$popularPost->id) }}">
                                                        <i class="material-icons">comment</i>
                                                        <span>{{ $popularPost->comments->count() }} Comments</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <i class="material-icons">share</i>
                                                        <span>Share</span>
                                                    </a>
                                                </li>
                                            </ul>

                                            
                                        </div>
                                    </div>
                                    @endforeach

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
</section>    
@endsection

@push('js')
    {{-- expr --}}
    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('assets/backend') }}/plugins/jquery-countto/jquery.countTo.js"></script>
    <script src="{{ asset('assets/backend') }}/js/pages/index.js"></script>

@endpush
