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
								<td>Name</td>
								<td>Image</td>
								<td>Actions</td>
							</tr>
						</thead>

						<tbody>
							@foreach($product as $key => $value)
							<tr>
								<td>{{ $value->name }} </td>
								<td>@foreach($value->product_images as $value1)<img src="{{ $value1->image}}" class="img-thumbnail" alt="#" style="height:100px" />@endforeach</td>
								<td>
									<button type="button" class="btn btn-primary" data-toggle="modal" value="{{ $value->id }}" data-target="#exampleModalScrollable" id="addcomm" title="Add Product Commission">
										<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-01-27-044720/theme/html/demo1/dist/../src/media/svg/icons/Layout/Layout-polygon.svg--><svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 70 70" fill="none">
											<g stroke="none" stroke-width="1" fill-rule="evenodd">
											 <path d="M28 4.04145C32.3316 1.54059 37.6684 1.54059 42 4.04145L58.3109 13.4585C62.6425 15.9594 65.3109 20.5812 65.3109 25.5829V44.4171C65.3109 49.4188 62.6425 54.0406 58.3109 56.5415L42 65.9585C37.6684 68.4594 32.3316 68.4594 28 65.9585L11.6891 56.5415C7.3575 54.0406 4.68911  49.4188 4.68911 44.4171V25.5829C4.68911 20.5812 7.3575 15.9594 11.6891 13.4585L28 4.04145Z" fill="#000000"/>
											</g>
										   </svg><!--end::Svg Icon-->
										</span>
									</button>
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

	});
</script>

@endpush