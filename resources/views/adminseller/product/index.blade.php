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

						Product

					</h3>

				</div>

				<div class="kt-portlet__head-toolbar">

					<div class="kt-portlet__head-wrapper">

						<div class="kt-portlet__head-actions">

							<!-- <a href="{{ route('admin.product.import') }}" class="btn btn-brand btn-elevate btn-icon-sm">
								<i class="la la-upload"></i>
								Import Product

							</a> -->
							@if(Auth::guard('admin')->check())
							<a href="{{ route('admin.product.create') }}" class="btn btn-brand btn-elevate btn-icon-sm">

								<i class="la la-plus"></i>

								Add Product

							</a>
							@endif
						</div>

					</div>

				</div>

			</div>

			<div class="kt-portlet__body">

				<div id="kt_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4">

					<table class="table table-striped- table-bordered table-hover table-checkable datatable" id="datatable_rows">

						@csrf

						<thead>

							<tr>

								<th><input type="checkbox" id="selectall" /></th>

								<th>SKU</th>

								<th>Name</th>
								<th>Vendor</th>
								<th>Type</th>
								<th>Product Price</th>
								<th>Selling Product Price</th>
								<th>Status</th>
								<th>Include In Top Deal</th>
								<th>Action</th>



							</tr>

						</thead>

						<tbody>

						</tbody>

					</table>

				</div>

			</div>



			@include('admin.layout.multiple_action', array(

			'table_name' => 'products',

			'is_orderby'=>'yes',

			'folder_name'=>'',

			'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'), 'discount' => __('Discount'))

			))



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


@if(Auth::guard('vendor')->check())
  @php 
  	$url = route('vendor.product'); 
  	$user = 'vendor';
  @endphp
@else
  @php  
  	$url = route('admin.product.index'); 
  	$user = 'admin';
  @endphp
@endif

@push('scripts')



<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>



<script>

	// setTimeout(function(){ 
	$(document).ready(function() {
		if ('{{ $user }}' == 'vendor') {
			table(0);
		}else{
			table(1);
		}

		
	});
	// }, 3000);
	
	function table(visibility){
		$('#datatable_rows').DataTable({

			processing: true,

			serverSide: true,

			// searchable: false,

			columnDefs: [{

				orderable: false,

				targets: -1,

			}],

			ajax: '{{ $url }}',

			columns: [{

					orderable: false,

					searchable: false,

					data: 'checkbox',

				},

				{

					data: "sku"

				},
				{

					"data": "name"

				},
				{

					"data": "vendor",

					visible:visibility

				},
				{

					"data": "type",

					visible:visibility

				},
				{

					orderable: false,

					searchable: false,

					data: 'product_price',

				},{

					orderable: false,

					searchable: false,

					data: 'selling_product_price',

				},

				{

					orderable: false,

					searchable: false,

					data: 'singlecheckbox',

				},
				{

					orderable: false,

					searchable: false,

					visible:visibility,

					data: 'deals',

				},

				{

					orderable: false,

					searchable: false,

					data: 'action',

				},



			]

		});
	}
</script>

@endpush