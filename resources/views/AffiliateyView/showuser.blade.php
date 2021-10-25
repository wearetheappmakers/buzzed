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

						Show Affiliate User

					</h3>

				</div>

				<div class="kt-portlet__head-toolbar">

					<div class="kt-portlet__head-wrapper">

					</div>

				</div>

			</div>

			<div class="kt-portlet__body">

				<div id="kt_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4">

					<table id="myTable" class="table table-striped- table-bordered table-hover table-checkable datatable">

						@csrf

						<thead>
							<tr>
								<td>Name</td>
								<td>Phone</td>
                                <td>Email</td>
								<td>Address</td>
								<td>Status</td>
								<td>Pending comm</td>
								<td>Approved comm</td>
								<td>Action</td>
							</tr>
						</thead>

						<tbody>
							@foreach($user as $value)
							@php
								
								$pencom = DB::table('user_comms')->where('user_id',$value->id)->where('status',0)->sum('amount');
								$appcom = DB::table('user_comms')->where('user_id',$value->id)->where('status',1)->sum('amount');

								$deduct_amount = DB::table('funds')->where('user_id',$value->id)->sum('amount');

								$appcom = $appcom - $deduct_amount;
							@endphp
							<tr>
								{{-- @dd($appcom) --}}
								<td>{{ $value->name }} </td>
								<td>{{ $value->phone }} </td>
								<td>{{ $value->email }} </td>
								<td>{{ $value->address }} </td>
								<td>
									@if($value->status == 1)
									Approved
									@else
									Disapproved
									@endif
								</td>
								<td>{{ $pencom }} </td>
								<td>{{ $appcom }} </td>
								<td>
									<a href="{{ url('admin/userapproved',$value->id) }}" title="Approved Affiliate user">
                                        <span class="svg-icon svg-icon-md svg-icon-primary">
                                            <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/Settings-1.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z" fill="#000000"></path>
                                                    <path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z" fill="#000000" opacity="0.3"></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </a>
									<a style="background: skyblue;" href="{{ url('admin/showreforder',$value->id) }}" title="View details" class="btn btn-sm btn-clean btn-icon btn-icon-md">
										<i style="color: white;" class="la la-eye"></i>
									</a>
									<a style="background: #6DC216;" href="{{ url('admin/viewAffiliateyDetail',$value->id) }}" title="User details" class="btn btn-sm btn-clean btn-icon btn-icon-md">
										<i style="color: white;" class="fa fa-edit"></i>
									</a>
									<a style="background: #9aaba8;" href="{{ url('admin/commission-history',$value->id) }}" title="commission history" class="btn btn-sm btn-clean btn-icon btn-icon-md">
										<i style="color: white;" class="fa fa-history"></i>
									</a>
									<a href="{{ route('admin.viewfunds',$value->id) }}" style="background: #5654ff;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="add commission">
										<i style="color: white;" class="fa fa-plus"></i>
									</a>
								</td>
							</tr>
							@endforeach
						</tbody>

					</table>

				</div>

			</div>

			<!-- Button trigger modal-->
			

			<!-- Modal-->
			<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
				<div class="modal-dialog modal-dialog-scrollable" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Add product referral commission</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<i aria-hidden="true" class="ki ki-close"></i>
							</button>
						</div>
						<div class="modal-body" style="height: 200px;">
							<form name="comm" id="comm" >
								@csrf
								<!--begin::Form Group-->
                                <div class="form-group">
                                    <label class="font-size-h6 font-weight-bolder text-dark">Commission</label>
                                    <input type="text" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" name="comm" placeholder="Enter product referral commission (like 20%)" value="" />
                                    <input type="hidden" class="form-control" name="product_id" value="" />
                                    @error('comm')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
								<!--end::Form Group-->
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary font-weight-bold" id="savecomm">Save</button>
						</div>
					</div>
				</div>
			</div>
			<!--End Modal-->

		</div>

	</div>

</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
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
    });
	$(document).ready(function() {

		$(document).on('click','#commission-button', function(){
			// var val = $(this).attr("value");
			// alert($(this).prop("value"));

			// alert('asd');
			// $('input[name="product_id"]').val(val);
		});
		//save data
		$("#savecomm").click(function(event) {
			event.preventDefault();
		
			$.ajax({
				type: "post",
				url: "saveprocomm",
				data: $('#comm').serialize(),
				success: function(data){
					toastr.success(data.success);
				},
				error: function(data){
					 alert("Error")
				}
			});
		});

	});
</script>

@endpush