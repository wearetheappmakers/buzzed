@extends('admin.main')

@section('content')

<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />


<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

	<br>



	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

		<div class="kt-portlet kt-portlet--mobile">

			<div class="kt-portlet__head kt-portlet__head--lg">

				<div class="kt-portlet__head-label">

					<span class="kt-portlet__head-icon">

						<i class="kt-font-brand flaticon2-line-chart"></i>

					</span>

					<h3 class="kt-portlet__head-title">

						Funds details

					</h3>

				</div>

				<div class="kt-portlet__head-toolbar">

					<div class="kt-portlet__head-wrapper">

						<div class="kt-portlet__head-actions">

							<a href="#exampleModalScrollable" data-toggle="modal" class="btn btn-brand btn-elevate btn-icon-sm">

								<i class="la la-plus"></i>

								Add Funds

							</a>

						</div>

					</div>

				</div>

			</div>
			<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
				<div class="modal-dialog modal-dialog-scrollable" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Add Funds</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<i aria-hidden="true" class="ki ki-close"></i>
							</button>
						</div>
						<div class="modal-body" style="height: 200px;">
							<form name="comm" id="comm" >
								@csrf
								<div class="form-group">
									<label class="font-size-h6 font-weight-bolder text-dark">Amount</label>
									<input type="number" class="form-control" name="amount" placeholder="Enter amount" required />
									<input type="hidden" class="form-control" name="user_id" value="{{ $get_user_id }}" />

								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary font-weight-bold" id="savecomm">Save</button>
						</div>
					</div>
				</div>
			</div>

			<div class="kt-portlet__body">

				<div id="kt_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4">

					<table id="myTable" class="table table-striped- table-bordered table-hover table-checkable datatable">

						@csrf

						<thead>
							<tr>
								<td>Date</td>
								<td>Amount</td>
								<td>Action</td>
							</tr>
						</thead>

						<tbody>
							@foreach($data as $key => $value)
							
							<tr>
								<td>{{ $value->created_at }} </td>
								<td>{{ $value->amount }} </td>
								<td>
									<a href="#exampleModalScrollable1{{$key}}" data-toggle="modal" style="background: green;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="edit funds">
										<i style="color: white;" class="fa fa-edit"></i>
									</a>
								</td>
								<div class="modal fade" id="exampleModalScrollable1{{$key}}" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
									<div class="modal-dialog modal-dialog-scrollable" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Add Funds</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<i aria-hidden="true" class="ki ki-close"></i>
												</button>
											</div>
											<div class="modal-body" style="height: 200px;">
												<form id="updatecomm_form{{$key}}">
													@csrf
													<div class="form-group">
														<label class="font-size-h6 font-weight-bolder text-dark">Amount</label>
														<input type="number" class="form-control" name="amount" placeholder="Enter amount" required value="{{ $value->amount }}" />
														<input type="hidden" class="form-control" name="user_id" value="{{ $get_user_id }}" />
														<input type="hidden" class="form-control" name="table_id" value="{{ $value->id }}" />

													</div>
												</form>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
												<button type="button" class="btn btn-primary font-weight-bold" id="updatecomm{{$key}}">Save</button>
											</div>
											<script type="text/javascript">
												$(document).ready(function(){
													$("#updatecomm{{$key}}").click(function(event) {
														event.preventDefault();

														$.ajax({
															type: "post",
															url: "{{ route('admin.updatefunds') }}",
															data: $('#updatecomm_form{{$key}}').serialize(),
															success: function(data){
																location.reload();
																toastr.success(data.message);
															},
															error: function(data){
																toastr.success('Error');
															}
														});
													});
												});
											</script>
										</div>
									</div>
								</div>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>



			</div>
		</div>
	</div>
</div>
@stop

@push('scripts')


<script src="{{ asset('affi/assets/plugins/custom/datatables/datatables.bundle.js?v=7.1.9')}}" type="text/javascript"></script>
<script src="{{ asset('affi/assets/js/pages/crud/datatables/basic/paginations.js?v=7.1.9')}}" type="text/javascript"></script>
<script>
	@if(session()->has("apuser"))
	toastr.success("{{ Session::get('apuser') }}");
	@endif
</script>


<script>
	$(document).ready(function(){
		$('#myTable').dataTable();

		$("#savecomm").click(function(event) {
			event.preventDefault();

			$.ajax({
				type: "post",
				url: "{{ route('admin.savefunds') }}",
				data: $('#comm').serialize(),
				success: function(data){
					location.reload();
					toastr.success(data.message);
				},
				error: function(data){
					toastr.success('Error');
				}
			});
		});
		
	});

</script>

@endpush