<form method="post" id="product-image-form" action="">
    @csrf

    <input type="hidden" value="{{$edit->id}}" name="product_id" id="product_id">
    <input type="hidden" value="image" name="image_type">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Image</label>
            <input type="file" class="form-control" name="image">
        </div>
        <div class="col-lg-4"></div>
    </div>
    <div class="form-group row">
        <div class="col-lg-8">
            <button type="submit" class="btn btn-primary image_update">Update</button>
        </div>
        
    </div>
    <div class="form-group row">
        <div class="col-lg-6">
            <div class="alert alert-custom alert-white alert-shadow fade show gutter-b" role="alert" style="background-color: #00d0ff3d;">
                <div class="alert-icon">
                    <span class="svg-icon svg-icon-primary svg-icon-xl">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Tools/Compass.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <path d="M17,12 L18.5,12 C19.3284271,12 20,12.6715729 20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 C4,12.6715729 4.67157288,12 5.5,12 L7,12 L7.5582739,6.97553494 C7.80974924,4.71225688 9.72279394,3 12,3 C14.2772061,3 16.1902508,4.71225688 16.4417261,6.97553494 L17,12 Z" fill="#000000"/>
                                <rect fill="#000000" opacity="0.3" x="10" y="16" width="4" height="4" rx="2"/>
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                </div>
                <div class="alert-text">Your first Image is primary image you can manage images order using drag-&-drop functionality</div>
            </div>
        </div>
    </div>
    <!-- @include('admin.layout.status_checkbox',array('data' => "")) -->
    <div id="image-rows" class="image_view row">
        @foreach($edit->product_images as $image)
        @include('adminseller.product.image_display',array('image'=>$image))
        @endforeach
    </div>

</form>

  
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    </div>
  </div>
</div>                          
@include('admin.layout.multiple_action', array(
'table_name' => 'product_images',
'is_orderby'=>'yes',
'folder_name'=>'product',
'action' => array()
))
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on("submit", "#product-image-form", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product.image_update') }}",
                data: new FormData($('#product-image-form')[0]),
                processData: false,
                dataType: 'html',
                contentType: false,
                success: function(data) {

                    // $('#datatable_rows').append(data);
                    $('#image-rows').append(data);
                    toastr["success"]('Image save successfully.', "Success");
                    // if (data.status == 'success') {
                    //     toastr["success"](data.message, "Success");
                    // } else if (data.status == 'error') {
                    //     toastr["error"]("Something went wrong", "Error");
                    // }
                }
            });
            return false;
        });
        $(document).on("click", ".color_popup", function(e) {
            // alert('yooo');
            // return false;
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: $(this).data('href'),
                data:{
                    'color_id':$(this).data('color_id'),
                    'product_id':$('#product_id').val(),
                },
                dataType: 'html',
                success: function(data) {
                  $('#exampleModal').modal("show");
                  $('#exampleModal .modal-content').html(data);
                }
            });
            return false;
        });
    });
</script>
@endpush