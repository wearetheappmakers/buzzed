@php
$selected_size = $edit->sizes->toArray();
$selected_size = array_column($selected_size, 'id');
// dd($edit->sizes);

@endphp
<form method="post" id="product-size-form" action="">
    @csrf
    <input type="hidden" value="{{$edit->id}}" name="product_id">
    <div class="form-group row">
        @foreach($sizes as $size)
        <div class="col-lg-12">
            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                <input type="checkbox" class="" name="product[size_id][]" value="{{ $size->id }}" @if(in_array($size->id, $selected_size)) checked="checked" @endif >
                <b>{{ $size->name }}</b>
                <span></span>
            </label>
        </div>

        @endforeach
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-8">
                <button type="submit" class="btn btn-primary size_update" >Update</button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on("submit", "#product-size-form", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product.size_update') }}",
                data: new FormData($('#product-size-form')[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'success') {
                        toastr["success"](data.message, "Success");
                    } else if (data.status == 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                }
            });
            return false;
        });
    });
</script>
@endpush