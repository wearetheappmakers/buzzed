<form method="post" id="general-form">
    @csrf
    <input type="hidden" name="id" value="{{ $edit->id }}">
    <div class="form-group row">
        <div class="col-lg-3">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{$edit->name}}" required>
        </div>
        <!-- <div class="col-lg-3">
            <label>Product Code:</label>
            <input type="text" class="form-control" placeholder="Enter SKU" name="product_code" value="{{$edit->product_code}}" required>
        </div> -->
        <div class="col-lg-3">
            <label>SKU:</label>
            <input type="text" class="form-control" placeholder="Enter SKU" name="sku" value="{{$edit->sku}}" required>
        </div>
        <div class="col-lg-3">
            <label>MOQ:</label>
            <input type="number" class="form-control" placeholder="Enter MOq" name="moq" value="{{$edit->moq}}">
        </div>
        <div class="col-lg-3">
                    <label>Vendor:</label>
                    <select class="form-control" name="vendor_id">
                        <option>-- Select Vendor --</option>
                        @if(!empty($vendors))
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" @if($edit->vendor_id == $vendor->id) selected @endif>{{ $vendor->fname }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-6">
            <label>Description:</label>
            <textarea name="description" id="description" class="form-control">{{ $edit->description }}</textarea>
        </div>
       <div class="col-lg-3">
            <label>Select Brand:</label>
             @php
                $selected_color = $edit->brand->toArray();
                $selected_color = array_column($selected_color, 'id');
            @endphp
            <select class="form-control" required name="product_brand">
                <option value="">-- Select Brand --</option>
                @if(!empty($brands))
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" @if(in_array($brand->id, $selected_color)) selected @endif>{{ $brand->name }}</option>
                    @endforeach
                @else
                    <option value="">No data Available</option>
                @endif
            </select>
        </div>
        <div class="col-lg-3">
            <label>Tax (in %):</label>
            <input type="text" class="form-control" name="product_tax" value="{{ $edit->product_tax }}" maxlength="2" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Product Type:</label>
            <select class="form-control" name="product_type" required>
                <option value="">Select</option>
                <option @if($edit->product_type == 1) selected @endif value="1">No Color/No Size</option>
                <option @if($edit->product_type == 2) selected @endif value="2">No Color</option>
                <option @if($edit->product_type == 3) selected @endif value="3">No Size</option>
                <option @if($edit->product_type == 4) selected @endif value="4">Both</option>
            </select>
        </div>
        <!-- <div class="col-lg-4">
            <label>IGST:</label>
            <input type="number" name="igst" class="form-control" value="{{ $edit->igst }}">
        </div> -->
        <div class="col-lg-4">
            <label>Type:</label>
            <div class="kt-radio-inline">
                <label class="kt-radio kt-radio--brand">
                    <input type="radio" name="type" value="0" @if($edit->type == 0) checked @endif> Both
                    <span></span>
                </label>
                <label class="kt-radio kt-radio--brand">
                    <input type="radio" name="type" value="1" @if($edit->type == 1) checked @endif> Online
                    <span></span>
                </label>
                <label class="kt-radio kt-radio--brand">
                    <input type="radio" name="type" value="2" @if($edit->type == 2) checked @endif> Offline
                    <span></span>
                </label>
            </div>
        </div>
    </div>
<!--     
    <div class="form-group row">
        <div class="col-lg-4">
            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                <input type="checkbox" name="is_home" value="1" @if($edit->is_home == 1) checked @endif> Home
                <span></span>
            </label>
        </div>
        <div class="col-lg-4">
            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                <input type="checkbox" name="is_new" value="1" @if($edit->is_new == 1) checked @endif> New
                <span></span>
            </label>
        </div>
    </div> -->
    @include('admin.layout.status_checkbox',array('data' => $edit->status))
    <div class="form-group row">
        <div class="col-lg-4"></div>
        <div class="col-lg-8">
            <button type="submit" class="btn btn-primary general_update" href="{{ route('admin.product.general_update') }}">Update</button>
        </div>
    </div>
</form>

@push('scripts')
<script type="text/javascript">

    ClassicEditor
    .create( document.querySelector( '#description' ) )
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );
   

    $(document).ready(function() {
        $(document).on("submit", "#general-form", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product.general_update') }}",
                data: new FormData($('#general-form')[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status === 'success') {
                        toastr["success"]("{{ $module }} Update Successfully", "Success");
                        location.reload();
                    } else if (data.status === 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                }
            });
            return false;
        });
    });
</script>
@endpush