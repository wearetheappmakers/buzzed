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

						Commission history

					</h3>

				</div>
				<div class="kt-portlet__head-toolbar">

					<div class="kt-portlet__head-wrapper">

						<div class="kt-portlet__head-actions">

							<a href="{{ route('admin.showuser') }}" class="btn btn-brand btn-elevate btn-icon-sm">

								<!-- <i class="la la-plus"></i> -->

								Back

							</a>

						</div>

					</div>

				</div>

			</div>

			<div class="kt-portlet__body">

				<div id="kt_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4">

					<table id="myTable" class="table table-striped">

						@csrf

						<thead>
							<tr>
								<td>Name</td>
								<td>Product</td>
                                <td>Order Number</td>
								<td>Amount</td>
								<td>Status</td>
								<td>Approved date</td>
							</tr>
						</thead>

						<tbody>
							@foreach($data as $value)
							
							<tr>
								<td>{{ DB::table('affiliate_users')->where('id',$value->user_id)->value('name') }} </td>
								<td>{{ DB::table('products')->where('id',$value->product_id)->value('name') }} </td>
								<td>{{ DB::table('order_headers')->where('id',$value->order_id)->value('order_number') }} </td>
								<td>{{ $value->amount }} </td>
								<td>
									@if($value->status == 1)
									Approved
									@else
									Pending
									@endif
								</td>
								<td>{{ $value->approvedDate }} </td>
							</tr>
							@endforeach
						</tbody>

					</table>

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
</script>

@endpush