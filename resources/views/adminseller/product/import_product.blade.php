@extends('admin.main')
@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<br>
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="kt-portlet">
					<div class="kt-portlet__head">
						<div class="kt-portlet__head-label">
							<h3 class="kt-portlet__head-title">
								Import Product
							</h3>
						</div>
					</div>   
					<div class="kt-portlet__body">
                        <form method="post" id="product-import" action="" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Excel</label>
                                    <input type="file" class="form-control" name="product_excel" >
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <button type="submit" class="btn btn-primary product_upload">
                                    Upload
                                    <i class="la la-spinner la-spin d-none"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on("submit", "#product-import", function(e) {
            $('.product_upload').prop('disabled', true);
            $('.product_upload').find('.la-spin').removeClass('d-none');
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product.import') }}",
                data: new FormData($('#product-import')[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status === 'success') {
                        toastr["success"]("Import Product Successfully", "Success");
                    } else if (data.status === 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                    $('.product_upload').prop('disabled', false);
                    $('.product_upload').find('.la-spin').addClass('d-none');
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
                    $('.product_upload').prop('disabled', false);
                    $('.product_upload').find('.la-spin').addClass('d-none');
                }
            });
            return false;
        });
    });
</script>
@endpush