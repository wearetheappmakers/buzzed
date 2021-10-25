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

						Show referral orders

					</h3>

				</div>

				<div class="kt-portlet__head-toolbar">

					<div class="kt-portlet__head-wrapper">

						{{-- <div class="kt-portlet__head-actions">

							<a href="{{ route('admin.product.import') }}" class="btn btn-brand btn-elevate btn-icon-sm">
								<i class="la la-upload"></i>
								Import Product

							</a>

							<a href="{{ route('admin.product.create') }}" class="btn btn-brand btn-elevate btn-icon-sm">

								<i class="la la-plus"></i>

								Add Product

							</a>

						</div> --}}

					</div>

				</div>

			</div>

			<div class="kt-portlet__body">

				<div id="kt_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4">

					<table id="myTable" class="table table-striped">

						@csrf

						<thead>
							<tr>
								<td>id</td>
								<td>Customer Name</td>
								<td>Referral user</td>
								<td>Price</td>
								<td>Commission</td>
								<td>Date</td>
								<td>Order Status</td>
								<td>Action</td>
							</tr>
						</thead>

						<tbody>
							@foreach($refforder as $value)
							{{--  @dd($value)  --}}
							<?php $refname = \App\AffiliateUser::where('id',$value->user_id)->first('name') ?>
							<tr>
								<td>{{ $value->order_id }} </td>
								<td>{{ $value->shipping_fullname }} </td>
								<td>{{ $refname->name }} </td>
								<td>{{ $value->total_price }} </td>
								<td>{{ $value->total }} </td>
								<td>{{ $value->created_at }} </td>
								<td>
									<select class="order_status_change form-control" data-header_id="{{ $value->order_id }}">
										@foreach($order_status as $os)
										@if($value->order_status_id == $os['id'])
											<option value='{{ $os['id'] }}' selected='selected' >{{ $os['name'] }}</option>
										@else
											<option value='{{ $os['id'] }}' >{{ $os['name'] }}</option>
										@endif
										@endforeach
									</select>
								</td>
								<td>
									<a style="background: green;" href="{{ url('admin/order-detail/'.$value->order_id) }}" title="View details" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                    <i style="color: white;" class="la la-eye"></i>
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

	$(document).ready(function() {
		$(document).ready(function(){
			$('#myTable').dataTable();
		});
		$(document).on('click','#addcomm', function(){
			var val = $(this).attr("value");
			$('input[name="product_id"]').val(val);
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
		$(document).on('change', '.order_status_change', function(e){
            e.preventDefault();
            var order_header_id = $(this).data('header_id');
            var status_id = $(this).val();            
            $.ajax({
                type: "GET",
                url: "{{ route('admin.order.changeOrderStatus') }}",
                data: {
					'order_header_id' : order_header_id,
                    'status_id': status_id, 
				},
				dataType: 'json',
                success: function(data) {
                    toastr["success"](data.message, "Success");
                },
                error :function( data ) {
                    var errors = $.parseJSON(data.responseText);
                    toastr["error"](errors.message, "Error");
                }
            });
            return false;
        });
	});
</script>

@endpush