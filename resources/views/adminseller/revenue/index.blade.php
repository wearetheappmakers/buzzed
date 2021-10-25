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

						Commision Report

					</h3>

				</div>

				<div class="kt-portlet__head-toolbar">

					<div class="kt-portlet__head-wrapper">

						<div class="kt-portlet__head-actions">

							<div class="row">
							<div class="col-lg-6">
								<select class="form-control" id="vendor_id" onchange="getReport()">
								<option>-- Select Vendor --</option>
								@if(!empty($vendors))
									@foreach($vendors as $vendor)
										<option value="{{ $vendor->id }}">{{ $vendor->fname }}</option>
									@endforeach
								@endif
							</select>
							</div>
							<div class="col-lg-6">
								<input type="text" class="form-control" id="kt_daterangepicker_1" onchange="getReport()" readonly="" placeholder="Select time">
							</div>
							</div>
							

							<!-- <div class="form-group row"> -->
								<!-- <label class="col-form-label col-lg-3 col-sm-12">Minimum Setup</label> -->
								<!-- <div class="col-lg-4 col-md-9 col-sm-12"> -->
									
								<!-- </div> -->
							<!-- </div> -->

						</div>

					</div>

				</div>

			</div>

			<div class="kt-portlet__body">

				<div class="row">
					<div class="col-lg-6">
						
					</div>
					<div class="col-lg-2">
						<b><label>Total : <span id="total">0</span></label></b>
					</div>
					<div class="col-lg-2">
						<b><label>Commision : <span id="commision">0</span></label></b>
					</div>
					<div class="col-lg-2">
						<b><label>Amount : <span id="amount">0</span></label></b>
					</div>
					
				</div>
				<div id="kt_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4">

					<table class="table table-striped- table-bordered table-hover table-checkable datatable" id="datatable_rows">

						@csrf

						<thead>

							<tr>

								<th>Sr. No</th>

								<th>Date</th>

								<th>Product</th>

								<th>Qty sold</th>

								<th>Price Incl GST</th>

							</tr>

						</thead>

						<tbody>

						</tbody>

					</table>

				</div>

			</div>



			@include('admin.layout.multiple_action', array(

			'table_name' => 'banners',

			'is_orderby'=>'yes',

			'folder_name'=>'banner',

			'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))

			))



		</div>

	</div>

</div>

@stop

@push('scripts')

@if(Auth::guard('vendor')->check())
  @php 
  	$url = route('vendor.revenue.report'); 
  	$id = Auth::guard('vendor')->user()->id;
  	$user = 'vendor';
  @endphp
@else
  @php  
  	$url = route('admin.revenue.report'); 
  	$id = Auth::guard('admin')->user()->id;
  	$user = 'admin';
  @endphp
@endif

<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>



<script>

	if ('{{ $user }}' == 'vendor') {
		$('#vendor_id').val('{{ $id }}');
		$('#vendor_id').prop('disabled',true);
	}

	function getReport(){
		$('#vendor_id').val();
		$('#kt_daterangepicker_1').val();
		$('#kt_table_1_wrapper').empty();
		$.ajax({
                type: "POST",
                url: "{{ $url }}",
                 
                data: {
                    "_token": "{{ csrf_token() }}",
                    'vendor_id':$('#vendor_id').val(),
                    'date':$('#kt_daterangepicker_1').val(),
                },
                success: function(data) {
                	
                	$('#kt_table_1_wrapper').html(data.data);
                	$('#datatable_rows').DataTable();
                	$('#total').text(data.total);
                	$('#commision').text(data.commision);
                	$('#amount').text(data.to_be_taken);
                }
            });
	}

	$(document).ready(function() {
		$('#kt_daterangepicker_1').daterangepicker({
            buttonClasses: ' btn',
        });


	});


</script>



@endpush