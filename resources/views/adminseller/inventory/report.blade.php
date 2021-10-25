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
						Inventory Report
					</h3>
				</div>
			</div>
			<form id="inventory_form" class="inventory_form" name="inventory_form" method="POST">
			@csrf
			<div class="kt-portlet__body">
				<div id="kt_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4">

					<table class="table table-striped- table-bordered table-hover table-checkable datatable" id="datatable_rows">
						
						<thead>
							<tr>
								<th>#</th>
								<th>Product Name</th>
								<th>Color</th>
								<th>Size</th>
								<!-- <th>Online</th> -->
								<!-- <th>Offline</th> -->
								<th>Total</th>
								<th>Used</th>
								<th>Pending qty</th>
								<th>Update qty</th>
								<th>Action</th>
							</tr>

						</thead>

						<tbody>
							@foreach($get_data as $row)

							<tr>
								<td>{{$row->id}}</td>
								<td>{{$row->product_name}}</td>
								<td>{{$row->color_name}}</td>
								<td>{{$row->size_name}}</td>
								<!-- <td>{{$row->inventory}}</td> -->
								<!-- <td>{{ $row->inventory_offline }}</td> -->
								<?php
									$total = $row->inventory;
									$pendding = $row->inventory - $row->used;
								?>
								<td>
									{{ $total }}
								</td>
								<td>
									{{ $row->used }}
								</td>
								<td>
									{{ $pendding }}
								</td>
								<td>
									
									<div class="form-group">
										<div class="input-group inventoryclass">
										<input type="text" class="form-control inventoryvalue" placeholder="Add/Remove Qty" >
										<div class="input-group-append" style="background: green;">
											<button class="btn btn-secondary" type="button" title="Add Qty" onclick="addinventory(this,'{{ $row->id }}','{{ $row->product_id }}')"><i class="fa fa-plus" style="color: #ffffff;"></i></button>
										</div>
										<div class="input-group-append" style="background: red;">
											<button class="btn btn-secondary" type="button" title="Minus Qty" onclick="removeinventory(this,'{{ $row->id }}','{{ $row->product_id }}')"><i class="fa fa-minus" style="color: #ffffff;"></i></button>
										</div>
										<br>
										</div>
									</div>
	
								</td>
								<td>
									@if(Auth::guard('vendor')->check())
										<a style="background: green;" href="{{ route('vendor.inventory.history',$row->product_id) }}" title="history" class="btn btn-sm btn-clean btn-icon btn-icon-md">
								    	<i style="color: white;" class="la la-history"></i>
									</a>
									@else
										<a style="background: green;" href="{{ route('admin.inventory.history',$row->product_id) }}" title="history" class="btn btn-sm btn-clean btn-icon btn-icon-md">
								    	<i style="color: white;" class="la la-history"></i>
									</a>
									@endif
									
								</td>
								<!-- <td><input type="number" id="update_inventory" class="update_inventory form-control" name="update_inventory[{{$row->id}}]"></td> -->
							</tr>
							@endforeach
						</tbody>
						</form>
					</table>
				</div>
			</div>
		</form>
		</div>

	</div>

</div>

@stop

@if(Auth::guard('vendor')->check())
    @php
        $user = 'vendor';
        $inventory_update = route('vendor.product.product_inventory_update'); 
    @endphp
@else
    @php 
        $user = 'admin'; 
        $inventory_update = route('admin.product.product_inventory_update'); 
    @endphp
@endif

@push('scripts')



<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>



<script>

	$(document).ready(function() {

		$('#datatable_rows').DataTable({
			columnDefs: [
			{ orderable: false, targets: -1 }
			],
			"processing": true,
			"aaSorting": [[0, 'dsce']],
			"scrollX": true
		});
		

	});

	function addinventory($this,inventoryid,pid){
        $.ajax({
                type: "POST",
                url: "{{ $inventory_update }}",
                 
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id':inventoryid,
                    'value':$($this).closest('.inventoryclass').find('.inventoryvalue').val(),
                    'product_id' : pid,
                    'type':'add'
                },
                success: function(data) {
                    if (data.status === 'success') {
                        toastr["success"]("Inventory Update Successfully", "Success");
                        window.location.reload();
                    } else if (data.status === 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                }
            });
    }

    function removeinventory($this,inventoryid,pid){
        $.ajax({
                type: "POST",
                url: "{{ $inventory_update }}",
                 
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id':inventoryid,
                    'value':$($this).closest('.inventoryclass').find('.inventoryvalue').val(),
                    'product_id' : pid,
                    'type':'remove'
                },
                success: function(data) {
                    if (data.status === 'success') {
                        toastr["success"]("Inventory Update Successfully", "Success");
                        window.location.reload();
                    } else if (data.status === 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                }
            });
    }
</script>

@endpush