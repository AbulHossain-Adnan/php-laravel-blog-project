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
		</div>

		<form action="{{ route('admin.post.store') }}" method="post" enctype="multipart/form-data">
			@csrf


			<!-- first row start -->

			<div class="row clearfix">
				<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>
								ADD POST
							</h2>

						</div>
						<div class="body">

							<label for="email_address">Post Title</label>
							<div class="form-group ">
								<div class="form-line">
									<input type="text" name="title" id="title" class="form-control" placeholder="Enter your post title">
								</div>

							</div>
							<br>
							<label for="image">Post Image</label>
							<div class="form-group">
								<div class="form-line">
									<input type="file" name="image" id="image" class="form-control">
								</div>
							</div>
							<br>
							<div class="fomr-group">
								<input type="checkbox" id="publish" class="filled-in" name="status" value="1">
								<label for="publish">publish</label>
							</div>
						</div>
					</div>

				</div>
				<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>
								SELECT CATEGORY ADN TAG (you can choose multiple)
							</h2>

						</div>
						<div class="body">

							<label >Category</label>
							<div class="form-group">
								<div class="form-line">
									<select class="selectpicker" multiple name="categories[]">
										@foreach ($categories as $category)
										<option value="{{ $category->id }}">{{ $category->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<br>
							<label >Tag</label>
							<div class="form-group">
								<div class="form-line">
									<select class="selectpicker" multiple name="tags[]">
										@foreach ($tags as $tag)
										<option value="{{ $tag->id }}">{{ $tag->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<!-- first row end -->


			<!-- second row start -->

			<!-- TinyMCE -->
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>
								Post Body
							</h2>

						</div>
						<div class="body">
							<textarea id="tinymce" name="body">

							</textarea>
							<br>
							<br>
							<div class="my-5">
								
								<button type="submit" class="btn btn-success my-5 btn-block waves-effect">Post</button>

							</div>
						</div>
					</div>
				</div>

			</div>
			<!-- #END# TinyMCE -->
			<!-- second row end <-->

			</-->
		</form>
	</div>
	@push('js')
	<!-- Multi Select Plugin Js -->
	<script src="{{ asset('assets/backend') }}/plugins/multi-select/js/jquery.multi-select.js"></script>
	<!-- Select Plugin Js -->
	<script src="{{ asset('assets/backend') }}/plugins/bootstrap-select/js/bootstrap-select.js"></script>

	<!-- TinyMCE -->
	<script src="{{ asset('assets/backend') }}/plugins/tinymce/tinymce.js"></script>
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
</script>

@endpush


@endsection