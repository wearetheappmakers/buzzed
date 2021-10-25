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

						{{ $module }}

					</h3>

				</div>

				<div class="kt-portlet__head-toolbar">

					<div class="kt-portlet__head-wrapper">

						<div class="kt-portlet__head-actions">

						@if(!Auth::guard('seller')->check())
							<a href="{{ route('admin.'.$resourcePath.'.create') }}" class="btn btn-brand btn-elevate btn-icon-sm">

								<i class="la la-plus"></i>

								Add {{ $module}}

							</a>
						@endif
						<button class="btn btn-brand btn-elevate btn-icon-sm category-import-btn">
								<i class="la la-upload"></i>
								Import Category
								<i class="la la-spinner la-spin d-none"></i>
						</button>
						<form action="{{ route('admin.category.import') }}" id="category_import_form" enctype="multipart/form-data">
						@csrf	
						<input type="file" style="display:none;" name="category_excel" id="category_input_file">
						</form>
							<!-- <a href="{{ route('admin.'.$resourcePath.'.tree-view') }}" class="btn btn-brand btn-elevate btn-icon-sm">

								<i class="la la-plus"></i>

								 {{ $module}} Tree View

							</a> -->


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

								<th>Name</th>

								<!-- <th>Seller ID</th> -->

								<th>Status</th>

								<th>Action</th>

							</tr>

						</thead>

						<tbody>

						</tbody>

					</table>

				</div>

			</div>


			@if(!Auth::guard('seller')->check())
					@include('admin.layout.multiple_action', array(

					'table_name' => 'categories',

					'is_orderby'=>'yes',

					'folder_name'=>'category',

					'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))

					))
			@endif
		</div>

	</div>

</div>

@stop

@push('scripts')



<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>



<script>

	$(document).ready(function() {

		$('.category-import-btn').on('click', function() {
			console.log('Asd');
            $('#category_input_file').trigger('click');
		});

		$('#category_input_file').change(function(e) {
			$('.category-import-btn').prop('disabled', true);
            $('.category-import-btn').find('.la-spin').removeClass('d-none');
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.category.import') }}",
                data: new FormData($('#category_import_form')[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status === 'success') {
                        toastr["success"]("Import Category Successfully", "Success");
                    } else if (data.status === 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                    $('.category-import-btn').prop('disabled', false);
                    $('.category-import-btn').find('.la-spin').addClass('d-none');
					window.location.reload();
                },
                error :function( data ) {
                    console.log(data.status)
                    if(data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        var errorText = '';
                        $.each(errors.errors, function (key, value) {
                            errorText +=  value +'<br/>';
                        });
                        toastr["error"](errorText, "Error");
                    }
                    $('.category-import-btn').prop('disabled', false);
                    $('.category-import-btn').find('.la-spin').addClass('d-none');
                }
            });
            return false;
		});

		$('#datatable_rows').DataTable({

			processing: true,

			serverSide: true,

			// searchable: false,

			columnDefs: [{

				orderable: false,

				targets: -1,

			}],

			ajax: "{{ route('admin.'.$resourcePath.'.index') }}",

			columns: [{

					orderable: false,

					searchable: false,

					data: 'checkbox',

				},

				{

					"data": "name"

				},

				// {

				// 	"data": "seller_id"

				// },
				{

					orderable: false,

					searchable: false,

					data: 'singlecheckbox',

				},

				{

					orderable: false,

					searchable: false,

					data: 'action',

				},



			]

		});





	});

</script>



@endpush