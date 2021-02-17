@extends('layouts.backend.admin_dashboard')

@section('title','tag')

@push('css')

<!-- JQuery DataTable Css -->
<link href="{{ asset('assets/backend') }}/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
@endpush

@section('adminDashboard')

<section class="content">
	<div class="container-fluid">


		<!-- Vertical Layout -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							EDIT TAG
						</h2>
						
					</div>
					<div class="body">
						<form action="{{ route('admin.tag.update',$tag->id) }}" method="post">
							@method('PUT')
							@csrf
							<label for="email_address">Tag Name</label>
							<div class="form-group">
								<div class="form-line">
									<input type="text" name="name" id="name" class="form-control" placeholder="Enter your tag name" value="{{ $tag->name }}">
								</div>
							</div>
							<br>
							<button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
							<a href="{{ route('admin.tag.index') }}" class="btn btn-primary m-t-15 waves-effect">BACK</a>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- #END# Vertical Layout -->
	</div>
	@push('js')

	@endpush


	@endsection