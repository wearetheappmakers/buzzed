@if(isset($edit))
<form method="post" id="general-form-title2">
    @csrf
    <input type="hidden" name="is_saved" value="1">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Title:</label>
            <input type="text" class="form-control" placeholder="Enter title" name="title" value="{{$edit->title}}" required>
        </div>
   		<div class="col-lg-4">
            <label class="">Image:</label>
            <input type="text" class="form-control" placeholder="Enter url" name="link" value="{{ $edit->link }}">
        </div>
        
    </div>
    <div class="form-group row">
        <div class="col-lg-6">
            <label>Description:</label>
            <textarea name="description" class="form-control" required>{{$edit->description}}</textarea>
        </div>
    </div>
    <input type="hidden" name="product_id" value="{{$product_id}}">
    <div class="form-group row">
        <div class="col-lg-4"></div>
        <div class="col-lg-8">
            <button type="submit" class="btn btn-primary update_title2" href="{{ route('admin.product.title2') }}">Update</button>
        </div>
    </div>
</form>
@else
<form method="post" id="general-form-title2">
    @csrf
    <input type="hidden" name="is_saved" value="1">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Title:</label>
            <input type="text" class="form-control" placeholder="Enter title" name="title" required>
        </div>
   		<div class="col-lg-4">
            <label class="">Link:</label>
            <input type="url" class="form-control" placeholder="Enter url" name="link" required>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-6">
            <label>Description:</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
    </div>
	<input type="hidden" id="product_id" class="product_id" name="product_id" value="{{ $product_id }}" >
    <div class="form-group row">
        <div class="col-lg-4"></div>
        <div class="col-lg-8">
            <button type="submit" class="btn btn-primary update_title2" href="{{ route('admin.product.title2') }}">Update</button>
        </div>
    </div>
</form>
@endif