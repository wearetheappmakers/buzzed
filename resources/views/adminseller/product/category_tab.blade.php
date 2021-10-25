@php
$selected_category = $edit->categories->toArray();
$selected_category = array_column($selected_category, 'id');

@endphp
<form method="post" id="product-catgegory-form" action="">
    @csrf
    <input type="hidden" value="{{$edit->id}}" name="product_id">
    <div class="form-group row">
        @foreach($categories as $category)
        <div class="col-lg-12">
            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                <input type="checkbox" class="" name="product[category][]" value="{{ $category->id }}" @if(in_array($category->id, $selected_category)) checked="checked" @endif >
                <b>{{ $category->name }}</b>
                <span></span>
            </label>
        </div>
        @if(count($category->items))
        @include('adminseller.product.manageCategoryCheckbox',['items' => $category->items, 'selected_category'=>$selected_category, 'count'=>2])
        @endif


        @endforeach
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-8">
                <button type="submit" class="btn btn-primary category_update" href="{{ route('admin.product.catgeory_update') }}">Update</button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on("submit", "#product-catgegory-form", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product.catgeory_update') }}",
                data: new FormData($('#product-catgegory-form')[0]),
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