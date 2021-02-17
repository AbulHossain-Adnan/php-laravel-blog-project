@extends('layouts.backend.admin_dashboard')

@section('title','post')

@push('css')

<!-- JQuery DataTable Css -->
<link href="{{ asset('assets/backend') }}/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
@endpush

@section('adminDashboard')

<section class="content">
	<div class="container-fluid">
		<div class="block-header">

			<a class="btn btn-primary waves-effect mb-3" href="{{ route('home') }}">
				<i class="material-icons">add</i>
				<span>Add New post</span>
			</a>
		</div>

		<!-- Exportable Table -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							ALL FAVOURITE POSTS 
							<span class="badge bg-blue">{{ $posts->count() }}</span>
						</h2>
					</div>
					<div class="body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover dataTable js-exportable">
								<thead>
									<tr>
										<th>ID</th>
										<th>Title</th>
										<th>Author</th>
										<th><i class="material-icons">visibility</i></th>
										<th><i class="material-icons">favorite</i></th>
										<th>Action</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>ID</th>
										<th>Title</th>
										<th>Author</th>
										<th><i class="material-icons">visibility</i></th>
										<th><i class="material-icons">favorite</i></th>
										<th>Action</th>
									</tr>
								</tfoot>
								<tbody>
									@forelse ($posts as $post)
									{{-- expr --}}
									<tr>
										<td>{{ $loop->index+1 }}</td>
										<td>{{ Str::limit($post->title,15) }}</td>
										<td>{{ $post->user->name }}</td>
										<td>{{ $post->view_count }}</td>
										<td>{{ $post->favouriteToUsers->count() }}</td>

										<td>												
											<button type="button" class="btn btn-sm btn-danger waves-effect" onclick="document.getElementById('remove-form-{{ $post->id }}').submit();">
												<i class="material-icons">delete</i>
											</button>
											<form id="remove-form-{{ $post->id }}" action="{{ route('favourite.post',$post->id) }}" method="post" style="display: none">

												@csrf

											</form>
										</td>

									</tr>
									@empty
									<td colspan="50" class="text-center text-danger">No Data To Show</td>
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- #END# Exportable Table -->
	</div>
	@push('js')
	<!-- Jquery DataTable Plugin Js -->
	<script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/jquery.dataTables.js"></script>
	<script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
	<script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
	<script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
	<script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
	<script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
	<script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
	<script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
	<script src="{{ asset('assets/backend') }}/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

	<!-- Custom Js -->
	<script src="{{ asset('assets/backend') }}/js/pages/tables/jquery-datatable.js"></script>
	{{-- sweat alert --}}
	{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> --}}
	{{-- sweat alert --}}
	<script src="{{ asset('assets/backend') }}/plugins/sweetalert/sweetalert.min.js"></script>

	<script>
		function removePost(id){
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
				confirmButtonText: 'Yes, delete it!',
				cancelButtonText: 'No, cancel!',
				reverseButtons: true
			}).then((result) => {
				if (result.value) {
					event.preventDefault();
					document.getElementById('remove-form-'+id).submit();
				} else if (
				           /* Read more about handling dismissals below */
				           result.dismiss === Swal.DismissReason.cancel
				           ) {
					swalWithBootstrapButtons.fire(
					                              'Cancelled',
					                              'Your data not deleted! :)',
					                              'error'
					                              )
				}
			})
		}



	</script>

	@endpush


	@endsection