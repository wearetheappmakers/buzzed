@php
$selected_color = $edit->colors->toArray();
$selected_color = array_column($selected_color, 'id');
// dd($edit->colors);

@endphp
<form method="post" id="product-color-form" action="">
    @csrf
    <input type="hidden" value="{{$edit->id}}" name="product_id">
    <div class="form-group row">
        @foreach($colors as $color)
        <div class="col-lg-12">
            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                <input type="checkbox" class="" name="product[color_id][]" value="{{ $color->id }}" @if(in_array($color->id, $selected_color)) checked="checked" @endif >
                <b>{{ $color->name }}</b>
                <span></span>
            </label>
        </div>

        @endforeach
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-8">
                <button type="submit" class="btn btn-primary color_update" >Update</button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on("submit", "#product-color-form", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product.color_update') }}",
                data: new FormData($('#product-color-form')[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'success') {
                        toastr["success"](data.message, "Success");
                    } else if (data.status == 'error') {
                        if(data.message){
                             toastr["error"](data.message, "Error");
                        }else{
                             toastr["error"]("Something went wrong", "Error");
                        }
                       
                    }
                }
            });
            return false;
        });
    });
</script>
@endpush