@extends('admin.main')

@section('content')

<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
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
						Export Data
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<div class="kt-portlet__head-wrapper">
						<div class="kt-portlet__head-actions">
							<div class="row">
								<div class="col-lg-4">
									<input type="date" name="start_date" class="form-control" id="start_date">
								</div>
								<div class="col-lg-4">
									<input type="date" name="end_date" class="form-control" id="end_date">
								</div>
								<div class="col-lg-4">
									<button type="submit" class="btn btn-primary form-control" id="get_report">Get Report</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="kt-portlet__body">
				<div id="kt_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4">
					
				</div>
			</div>
		</div>
	</div>
</div>

@stop

@push('scripts')

<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script>

	$(document).ready(function() {
		
		$("#get_report").on("click", function (e)
		{
			var start_date = $('#start_date').val();
			var end_date = $('#end_date').val();
			$.ajax({
				type: "GET",
				url: "{{route('admin.order.export.update')}}",
				data: {
					'start_date': start_date,
					'end_date': end_date
				},
				success: function (data)
				{
					if(data.status === 'Error')
					{
						toastr["error"](data.message, "Error");
					}else{
						$("#kt_table_1_wrapper").html(data.message);
						$('#datatable_rows_export').DataTable({
							scrollX:true,
							dom: 'Bfrtip',
							buttons: [
							// 'pdf',
							// 'print',
							'excel',
							// 'csv'
							]
						});
					}
				}
			});
		});

	});
</script>
@endpush