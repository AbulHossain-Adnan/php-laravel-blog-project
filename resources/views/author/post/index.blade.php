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

			<a class="btn btn-primary waves-effect mb-3" href="{{ route('author.post.create') }}">
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
							ALL POSTS 
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
										<th>Is Approved</th>
										<th>Status</th>
										<th>Created At</th>
										<th>Updated At</th>
										<th>Action</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>ID</th>
										<th>Title</th>
										<th>Author</th>
										<th><i class="material-icons">visibility</i></th>
										<th>Is Approved</th>
										<th>Status</th>
										<th>Created At</th>
										<th>Updated At</th>
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
										<td>
											@if ($post->is_approved)
											<span class="badge bg-blue">approved</span>
											@else
											<span class="badge bg-red">pending</span>
											@endif
										</td>
										<td>
											@if ($post->status)
											<span class="badge bg-blue">published</span>
											@else
											<span class="badge bg-red">pending</span>
											@endif
										</td>

										<td>
											@if ($post->created_at)
											{{ $post->created_at->diffForHumans() }}
											@else
											----
											@endif
										</td>
										<td>
											@if ($post->updated_at)
											{{ $post->updated_at->diffForHumans() }}
											@else
											----
											@endif
										</td>
										<td>
											<div class="btn-group">
												<a class="btn btn-sm btn-primary waves-effect" href="{{ route('author.post.show',$post->id) }}">
													<i class="material-icons">visibility</i>
												</a>
												<a class="btn btn-sm waves-effect" href="{{ route('author.post.edit',$post->id) }}">
													<i class="material-icons">edit</i>
												</a>
												<button type="button" class="btn btn-sm btn-danger waves-effect" onclick="deletePost({{ $post->id }})">
													<i class="material-icons">delete</i>
												</button>
												<form id="delete-form-{{ $post->id }}" action="{{ route('author.post.destroy',$post->id) }}" method="post" style="display: none">
													@method('DELETE')
													@csrf

												</form>

											</div>
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
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
	<script>

		function deletePost(id) {
			swal({
				title: "Are you sure?",
				text: "You will not be able to recover this imaginary file!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plx!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function (isConfirm) {
				if (isConfirm) {
					event.preventDefault();
					document.getElementById('delete-form-'+id).submit();
				} else {
					swal("Cancelled", "Your imaginary file is safe :)", "error");
				}
			});
		}
	</script>

	@endpush


	@endsection