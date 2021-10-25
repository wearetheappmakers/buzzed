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

						Image Optimize

					</h3>

				</div>

				<div class="kt-portlet__head-toolbar">

					<div class="kt-portlet__head-wrapper">

						<div class="kt-portlet__head-actions">

							<a href="{{ route('admin.image_optimize.create') }}" class="btn btn-brand btn-elevate btn-icon-sm">

								<i class="la la-plus"></i>

								Add Image Optimize

							</a>

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

								<th>No</th>

								<th>Name</th>

								<th class="text-center"> Thumb</th>
	    						<th class="text-center">Width x Height</th>
								<!-- <th>Action</th> -->

							</tr>

						</thead>

						<tbody>
							@php
							$k = 0;
							@endphp
							@foreach($i_o_array as $key=>$i_o)
								@foreach($i_o as $key2=>$opti)
								<tr>
									@if($key2 == 0)
										<td rowspan="{{ count($i_o) }}">
											{{ $k+1 }}
										</td>
										<td rowspan="{{ count($i_o) }}">
											{{ $key }}
										</td>
									@endif
									<td>
										{{ $opti['thumb_folder'] }}
									</td>
									<td>
										{{ $opti['width'] . 'x' . $opti['height']}}
									</td>
									<!-- @if($key2 == 0)
										<td rowspan="{{ count($i_o) }}">
											
										</td>
									@endif -->
								</tr>
								@endforeach
								@php $k++;@endphp
							@endforeach
						</tbody>

					</table>

				</div>

			</div>


		</div>

	</div>

</div>

@stop
