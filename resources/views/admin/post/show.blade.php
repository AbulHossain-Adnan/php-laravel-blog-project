@extends('layouts.backend.admin_dashboard')

@section('title','post')

@push('css')

<!-- JQuery DataTable Css -->
<link href="{{ asset('assets/backend') }}/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<!-- Multi Select Css -->
<link href="{{ asset('assets/backend') }}/plugins/multi-select/css/multi-select.css" rel="stylesheet">
<!-- Bootstrap Select Css -->
<link href="{{ asset('assets/backend') }}/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

@endpush

@section('adminDashboard')

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<a class="btn btn-success waves-effect" href="{{ route('admin.post.index') }}">Back</a>
			@if ($post->is_approved == false)
			
			<button type="button" class="btn btn-primary waves-effect pull-right" onclick="approvePost({{ $post->id }})">
				<i class="material-icons">done</i><span>approve</span>
			</button>
			<form id="approve_post" action="{{ route('admin.approve.post',$post->id) }}" method="post" style="display: none;">
				@method('PUT');
				@csrf
			</form>
			@else
			<button type="button" class="btn btn-primary pull-right" disabled="">
				<i class="material-icons">done</i><span>approve</span>
			</button>
			
			@endif
		</div>




		<!-- first row start -->

		<div class="row clearfix">
			<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							{{ $post->title }}
						</h2>
						<small>Posted by <strong><a href="">{{ $post->user->name }}</a></strong>
							<strong>on {{ $post->created_at->diffForHumans() }}</strong>
						</small>
					</div>
					<div class="body">
						{!! $post->body !!}
					</div>
				</div>

			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header bg-cyan">
						<h2>
							Category
						</h2>

					</div>
					<div class="body">
						@foreach ($post->categories as $category)
						<span class="label bg-cyan">{{ $category->name }}</span>
						@endforeach
					</div>
				</div>
				<div class="card">
					<div class="header bg-blue">
						<h2>
							Tags
						</h2>

					</div>
					<div class="body">
						@foreach ($post->tags as $tag)
						<span class="label bg-blue">{{ $tag->name }}</span>
						@endforeach
					</div>
				</div>
				<div class="card">
					<div class="header bg-blue">
						<h2>
							Post Thumnail
						</h2>

					</div>
					<div class="body">
						<img class="img-responsive thumbnail" src="{{ asset('uploads/post') }}/{{ $post->image }}" alt="">

					</div>
				</div>
			</div>



			<!-- first row end -->


			<!-- second row start -->

			<!-- TinyMCE -->
			
		</div>
		@push('js')
		<!-- Multi Select Plugin Js -->
		<script src="{{ asset('assets/backend') }}/plugins/multi-select/js/jquery.multi-select.js"></script>
		<!-- Select Plugin Js -->
		<script src="{{ asset('assets/backend') }}/plugins/bootstrap-select/js/bootstrap-select.js"></script>

		<!-- TinyMCE -->
		<script src="{{ asset('assets/backend') }}/plugins/tinymce/tinymce.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
		{{-- sweat alert --}}

		
		<script>
			$(function () {


    //TinyMCE
    tinymce.init({
    	selector: "textarea#tinymce",
    	theme: "modern",
    	height: 300,
    	plugins: [
    	'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    	'searchreplace wordcount visualblocks visualchars code fullscreen',
    	'insertdatetime media nonbreaking save table contextmenu directionality',
    	'emoticons template paste textcolor colorpicker textpattern imagetools'
    	],
    	toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    	toolbar2: 'print preview media | forecolor backcolor emoticons',
    	image_advtab: true
    });
    tinymce.suffix = ".min";
    tinyMCE.baseURL = '{{ asset('assets/backend') }}/plugins/tinymce';
});

			function approvePost(id){
				const swalWithBootstrapButtons = Swal.mixin({
					customClass: {
						confirmButton: 'btn btn-success',
						cancelButton: 'btn btn-danger'
					},
					buttonsStyling: false
				})

				swalWithBootstrapButtons.fire({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Yes, approve it!',
					cancelButtonText: 'No, cancel!',
					reverseButtons: true
				}).then((result) => {
					if (result.value) {
						event.preventDefault();
						document.getElementById('approve_post').submit();
					} else if (
					           /* Read more about handling dismissals below */
					           result.dismiss === Swal.DismissReason.cancel
					           ) {
						swalWithBootstrapButtons.fire(
						                              'Cancelled',
						                              'Post not approved! :)',
						                              'info'
						                              )
					}
				})
			}
		</script>

		@endpush


		@endsection