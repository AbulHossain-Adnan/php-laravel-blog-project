@extends('layouts.backend.admin_dashboard')

@section('title','Settings')

@push('css')


@endpush

@section('adminDashboard')

<section class="content">
	<div class="container-fluid">

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						TABS WITH ICON TITLE
					</h2>

				</div>
				<div class="body">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#profile_with_icon_title" data-toggle="tab">
								<i class="material-icons">face</i> PROFILE
							</a>
						</li>
						<li role="presentation">
							<a href="#password_with_icon_title" data-toggle="tab">
								<i class="material-icons">change_history</i> CHANGE PASSWORD
							</a>
						</li>

					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="profile_with_icon_title">
							<form method="post" action="{{ route('admin.settings.update',Auth::id()) }}" enctype="multipart/form-data">
								@method('PUT')
								@csrf
								
								<div class="form-group form-float">
									<label class="form-label">Name</label>
									<div class="form-line">
										<input name="name" type="text" id="name" class="form-control" value="{{ Auth::user()->name }}">
									</div>
								</div>

								<label class="form-label">Profile Photo</label>
								<div class="form-group form-float">
									<div class="form-line">
										<input name="image" type="file">
									</div>
								</div>



								<label class="form-label">About</label>
								<div class="form-group form-float">
									<div class="form-line">
										<textarea name="about" id="" class="form-control" rows="5"> {{ Auth::user()->about ?? '' }} </textarea>
									</div>
								</div>

								<br>
								<button type="submit" class="btn btn-primary m-t-15 waves-effect">Update</button>
							</form>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="password_with_icon_title">
							<form method="post" action="{{ route('admin.settings.update-password',Auth::id()) }}">
								@method('PUT')
								@csrf
								
								<div class="form-group form-float">
									<label class="form-label">Password</label>
									<div class="form-line">
										<input name="old_password" type="password" class="form-control">
									</div>
								</div>

								<label class="form-label">New Password</label>
								<div class="form-group form-float">
									<div class="form-line">
										<input name="password" type="password" class="form-control">
									</div>
								</div>
								<label class="form-label">Confirm Password</label>
								<div class="form-group form-float">
									<div class="form-line">
										<input name="password_confirmation" type="password" class="form-control">
									</div>
								</div>
								<br>
								<input type="checkbox" id="md_checkbox_22" class="filled-in chk-col-pink" checked value="1" name='check' />
								<label for="md_checkbox_22">logout from other device also</label>


								<br>
								<button type="submit" class="btn btn-primary m-t-15 waves-effect">Change Password</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	@push('js')
	

	@endpush


	@endsection