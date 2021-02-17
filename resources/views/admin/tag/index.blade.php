@extends('layouts.backend.admin_dashboard')

@section('title','tag')

@push('css')

<!-- JQuery DataTable Css -->
<link href="{{ asset('assets/backend') }}/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
@endpush

@section('adminDashboard')

<section class="content">
	<div class="container-fluid">
		<div class="block-header">

			<a class="btn btn-primary waves-effect mb-3" href="{{ route('admin.tag.create') }}">
				<i class="material-icons">add</i>
				<span>Add New Tag</span>
			</a>
		</div>

		<!-- Exportable Table -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							ALL TAGS
							<span class="badge bg-blue">{{ $tags->count() }}</span>
						</h2>
					</div>
					<div class="body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover dataTable js-exportable">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Post Count</th>
										<th>Created At</th>
										<th>Updated At</th>
										<th>Action</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Post Count</th>
										<th>Created At</th>
										<th>Updated At</th>
										<th>Action</th>
									</tr>
								</tfoot>
								<tbody>
									@forelse ($tags as $tag)
									{{-- expr --}}
									<tr>
										<td>{{ $loop->index+1 }}</td>
										<td>{{ $tag->name }}</td>
										<td>{{ $tag->posts->count() }}</td>
										<td>
											@if ($tag->created_at)
											{{ $tag->created_at->diffForHumans() }}
											@else
											----
											@endif
										</td>
										<td>
											@if ($tag->updated_at)
											{{ $tag->updated_at->diffForHumans() }}
											@else
											----
											@endif
										</td>
										<td>
											<div class="btn-group">
												<a class="btn btn-sm btn-warning waves-effect" href="{{ route('admin.tag.edit',$tag->id) }}">
													<i class="material-icons">edit</i>
												</a>
												<button type="button" class="btn btn-sm btn-danger waves-effect" onclick="deleteTag({{ $tag->id }})">
													<i class="material-icons">delete</i>
												</button>
												<form id="delete-form-{{ $tag->id }}" action="{{ route('admin.tag.destroy',$tag->id) }}" method="post" style="display: none">
													@method('DELETE')
													@csrf

												</form>

											</div>
										</td>

									</tr>
									@empty
									<td colspan="50">No Data To Show</td>
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
		function deleteTag(id) {
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