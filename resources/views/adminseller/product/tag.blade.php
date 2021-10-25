@if(isset($edit))
<form method="post" id="general-form-tag">
    @csrf
    <input type="hidden" name="is_saved" value="1">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Meta Title:</label>
            <input type="text" class="form-control" placeholder="Enter Meta" name="meta" value="{{$edit->meta}}" required>
        </div>
   		<div class="col-lg-8">
            <label>Meta Description:</label>
            <textarea class="form-control" placeholder="Enter Meta Description" name="meta_description">{{ $edit->meta_description }}</textarea>
        </div>
    </div>

    
    <input type="hidden" name="product_id" value="{{$product_id}}">
    <div class="form-group row">
        <div class="col-lg-4"></div>
        <div class="col-lg-8">
            <button type="submit" class="btn btn-primary update_tag" href="{{ route('admin.product.tag') }}">Update</button>
        </div>
    </div>
</form>
@else
<form method="post" id="general-form-tag">
    @csrf
    <input type="hidden" name="is_saved" value="1">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Meta Title:</label>
            <input type="text" class="form-control" placeholder="Enter meta" name="meta" required>
        </div>
   		<div class="col-lg-8">
            <label>Meta Description:</label>
            <textarea class="form-control" name="meta_description" placeholder="Enter Description"></textarea>
        </div>
    </div>
	<input type="hidden" id="product_id" class="product_id" name="product_id" value="{{ $product_id }}" >
    <div class="form-group row">
        <div class="col-lg-4"></div>
        <div class="col-lg-8">
            <button type="submit" class="btn btn-primary update_tag" href="{{ route('admin.product.tag') }}">Update</button>
        </div>
    </div>
</form>
@endif