@extends('layouts.backend.admin_dashboard')

@section('title','subscriber')

@push('css')

<!-- JQuery DataTable Css -->
<link href="{{ asset('assets/backend') }}/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
@endpush

@section('adminDashboard')

<section class="content">
	<div class="container-fluid">
		
		<!-- Exportable Table -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							ALL AUTHORS
							<span class="badge bg-blue">{{ $authors->count() }}</span>
						</h2>
					</div>
					<div class="body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover dataTable js-exportable">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Total Post</th>
										<th>Total Comment</th>
										<th>Created At</th>
										<th>Action</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Total Post</th>
										<th>Total Comment</th>
										<th>Created At</th>
										<th>Action</th>
									</tr>
								</tfoot>
								<tbody>
									@forelse ($authors as $author)
									{{-- expr --}}
									<tr>
										<td>{{ $loop->index+1 }}</td>
										<td>{{ $author->name }}</td>
										<td>{{ $author->posts_count }}</td>
										<td>{{ $author->comments_count }}</td>
										<td>
											@if ($author->created_at)
											{{ $author->created_at->diffForHumans() }}
											@else
											----
											@endif
										</td>
										<td>
											
												<button type="button" class="btn btn-sm btn-danger waves-effect" onclick="deleteAuthor({{ $author->id }})">
													<i class="material-icons">delete</i>
												</button>
												<form id="delete-form-{{ $author->id }}" action="{{ route('admin.authors.destroy',$author->id) }}" method="post" style="display: none">
													@method('DELETE')
													@csrf

												</form>
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
	function deleteAuthor(id) {
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