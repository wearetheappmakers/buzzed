@extends('admin.main')

@section('content')

<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<br>
	@if(Auth::guard('admin')->check())
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="kt-portlet kt-portlet--mobile">
			<div class="kt-portlet__head kt-portlet__head--lg">
				<div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon">
						<i class="kt-font-brand flaticon2-line-chart"></i>
					</span>
					<h3 class="kt-portlet__head-title">
						Inventory Product User History
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
								<!-- <th>#</th> -->
								<th>Date</th>
								<th>Time</th>
								<th>Customer Name</th>
								<th>Quntity</th>
							</tr>

						</thead>

						<tbody>
							@foreach($history as $row)
							<tr>
								<!-- <td>{{ $row->orderid }}</td> -->
								<td>{{ date('d-m-Y',strtotime($row->order_create)) }}</td>
								<td>{{ date('H:i a',strtotime($row->order_create)) }}</td>
								<td>{{ $row->fname }}</td>
								<td>{{ $row->total_quantity }}</td>
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
	@endif
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="kt-portlet kt-portlet--mobile">
			<div class="kt-portlet__head kt-portlet__head--lg">
				<div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon">
						<i class="kt-font-brand flaticon2-line-chart"></i>
					</span>
					<h3 class="kt-portlet__head-title">
						Inventory Update History
					</h3>
				</div>
			</div>
			<form id="inventory_form" class="inventory_form" name="inventory_form" method="POST">
			@csrf
			<div class="kt-portlet__body">
				<div id="kt_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4">

					<table class="table table-striped- table-bordered table-hover table-checkable datatable" id="datatable_rows2">
						
						<thead>
							<tr>
								
								<th>Date</th>

								<th>Changed By</th>

								<th>Old inventory</th>

								<th>Action on inventory </th>

							</tr>

						</thead>

						<tbody>
							@foreach($records as $record)
							<tr>
								
								<td>{{ date('d-m-Y',strtotime($record->created_at)) }}</td>
								<td>
									@if($record->user_id == 1)
										admin
									@else
										{{ App\User::where('id',$record->user_id)->value('fname') }} (vendor)
									@endif
								</td>
								<td>{{ $record->old_data }}</td>
								<td>{{ $record->module }} - ({{ $record->new_data }})</td>
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

		$('#datatable_rows2').DataTable({
			columnDefs: [
			{ orderable: false, targets: -1 }
			],
			"processing": true,
			"aaSorting": [[0, 'dsce']],
			"scrollX": true
		});
		

	});
</script>

@endpush