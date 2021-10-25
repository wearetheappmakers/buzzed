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
						Online Inventory
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
								<th>Inventory</th>
								<th>Used</th>
								<th>Add More Inventory</th>
							</tr>

						</thead>

						<tbody>
							@foreach($get_data as $row)
							<tr>
								<td>{{$row->id}}</td>
								<td>{{$row->product_name}}</td>
								<td>{{$row->color_name}}</td>
								<td>{{$row->size_name}}</td>
								<td>{{$row->inventory}}</td>
								<td>{{$row->used}}</td>
								<td><input type="number" id="update_inventory" class="update_inventory form-control" name="update_inventory[{{$row->id}}]"></td>
							</tr>
							@endforeach
						</tbody>
						</form>
					</table>

				</div>

			</div>

			<div class="kt-portlet__foot">
				<div class="kt-form__actions">
					<button type="button" class="btn btn-primary submit">Update Inventory</button>
				</div>
			</div>
		</form>
		</div>

	</div>

</div>

@stop

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
		$(".submit").on("click", function (e)
		{
			e.preventDefault();
			if ($(".inventory_form").valid())
			{
				$.ajax({
					type: "POST",
					url: "{{route('admin.inventory.update')}}",
					data: new FormData($('.inventory_form')[0]),
					processData: false,
					contentType: false,
					success: function (data)
					{
						if (data.status === 'success') {
							toastr["success"]("Inventory Updates Successfully", "Success");
							location.reload();
						} else if (data.status === 'error') {
							location.reload();
							toastr["error"]("Something went wrong", "Error");
						}
					}
				});
			}
			else
			{
				e.preventDefault();
			}
		});

	});
</script>

@endpush