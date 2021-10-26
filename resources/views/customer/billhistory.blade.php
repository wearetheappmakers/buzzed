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
						All Order List
					</h3>
				</div>
			</div>

			<div class="kt-portlet__body">
				<div id="kt_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4">
					<table class="table table-striped- table-bordered table-hover table-checkable datatable responsive" id="datatable_rows">
						@csrf
						<thead>
							<tr>
								<th>Date</th>
								<th>Order Number</th>
								<th>Outlet</th>
								<th>Captain</th>								
								<th>Payment Type</th>
								<th>Amount</th>
								<th>Discount Amount</th>
								<th>Payable Amount</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>

			@include('admin.layout.multiple_action', array(
			'table_name' => 'option_values',
			'is_orderby'=>'yes',
			'folder_name'=>'',
			'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))
			))
		</div>
	</div>
</div>


@stop

@push('scripts')

<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script>
	$(document).ready(function() {
		$('#datatable_rows').DataTable({
			processing: true,
			serverSide: true,
			searchable: true,
			columnDefs: [{
				orderable: false,
				targets: -1,
			}],
			ajax: "{{ route('customer.order.index') }}",
			columns: [
				{
					"data": "order_date"
				},
				{
					orderable: false,
                    searchable: true,
					data: 'order_uniqueid',
				},
				{

					"data": "outlet"
				},
				{

					"data": "captain"
				},{

					"data": "payment_type"
				},{

					"data": "price"
				},{

					"data": "discount_price"
				},
				{
					"data": "total_price"
				},

				
    //             {
    //                 orderable: false,
    //                 searchable: false,
				// 	"data": "order_status"
				// },
    //             {
    //                 orderable: false,
    //                 searchable: false,
				// 	"data": "action"
				// },
			]
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