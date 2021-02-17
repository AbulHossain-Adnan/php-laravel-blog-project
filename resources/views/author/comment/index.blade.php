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
							ALL COMMENTS
						</h2>
					</div>
					<div class="body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover dataTable js-exportable">
								<thead>
									<tr>
										<th class="text-center">Comment Information</th>
										<th class="text-center">Post Information</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th class="text-center">Comment Information</th>
										<th class="text-center">Post Information</th>
										<th class="text-center">Action</th>
									</tr>
								</tfoot>
								<tbody>

									@foreach ($posts as $post)
									
									@forelse ($post->comments as $comment)
									{{-- expr --}}
									<tr>
										<td>
											<div class="media">
												<div class="media-left">
													<a href="">
														<img src="{{ asset('uploads/user') }}/{{ $comment->user->image }}" alt="" width="60">
													</a>
												</div>
												<div class="media-body">
													<h4 class="media-heading">
														{{ $comment->user->name }}
													</h4>
													<small>
														{{ $comment->created_at->diffForHumans() }}
													</small>
													<p>
														{{ $comment->comment }}
													</p>
													<a href="{{ route('post.show',['slug' => $comment->post->slug,'id' => $comment->post->id]) }}" target="_blank">Reply</a>
												</div>
											</div>
										</td>
										<td>
											<div class="media">
												<div class="media-left">
													<a href="{{ route('post.show',['slug' => $comment->post->slug,'id' => $comment->post->id]) }}" target="_blank">
														<img src="{{ asset('uploads/post') }}/{{ $comment->post->image }}" alt="" width="80">
													</a>

												</div>
												<div class="media-body">
													<a href="{{ route('post.show',['slug' => $comment->post->slug,'id' => $comment->post->id]) }}" target="_blank">
														<strong>
															{{ Str::limit(Str::title($comment->post->title),30) }}
														</strong>
													</a>
													<p><strong>{{ $comment->user->name }}</strong></p>
												</div>
											</div>
										</td>
										<td>
											
												<button type="button" class="btn btn-sm btn-danger waves-effect" onclick="
												document.getElementById('delete-form-{{ $comment->id }}').submit();
												">
													<i class="material-icons">delete</i>
												</button>
												<form id="delete-form-{{ $comment->id }}" action="{{ route('author.comment.destroy',$comment->id) }}" method="post" style="display: none">
													@method('DELETE')
													@csrf

												</form>
										</td>

									</tr>
									@empty
									<td colspan="50">No Data To Show</td>
									@endforelse
									@endforeach
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
		function deleteSubscriber(id){
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
					document.getElementById('delete-form-'+id).submit();
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