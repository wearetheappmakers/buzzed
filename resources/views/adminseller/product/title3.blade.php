@if(isset($edit))
<form method="post" id="general-form-title3">
    @csrf
    <input type="hidden" name="is_saved" value="1">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Title:</label>
            <input type="text" class="form-control" placeholder="Enter title" name="title" value="{{$edit->title}}" required>
        </div>
   		
    </div>
    <div class="form-group row">
        <div class="col-lg-3">
            <label class="">Image:</label>
            <input type="file" class="form-control" placeholder="Enter image" name="image">
        </div>
        <div class="col-lg-">
            <div class="image_layer">
                <div class="image_div">
                    <a target="_blank"  href="{{ url('storage/uploads/product/'.$edit->image) }}" rel="gallery" class="fancybox" title="">
                        <img src="{{ url('storage/uploads/product/Tiny/'.$edit->image) }}" class="img-thumbnail" alt="{{ $edit->image }}" />
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <label>Description:</label>
            <textarea name="description" class="form-control" required>{{$edit->description}}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-3">
            <label class="">Image:</label>
            <input type="file" class="form-control" placeholder="Enter image" name="image1">
        </div>
        <div class="col-lg-">
            <div class="image_layer">
                <div class="image_div">
                    <a target="_blank"  href="{{ url('storage/uploads/product/'.$edit->image1) }}" rel="gallery" class="fancybox" title="">
                        <img src="{{ url('storage/uploads/product/Tiny/'.$edit->image1) }}" class="img-thumbnail" alt="{{ $edit->image1 }}" />
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <label>Description:</label>
            <textarea name="description1" class="form-control" required>{{$edit->description1}}</textarea>
        </div>
    </div>
    <input type="hidden" name="product_id" value="{{$product_id}}">
    <div class="form-group row">
        <div class="col-lg-4"></div>
        <div class="col-lg-8">
            <button type="submit" class="btn btn-primary update_title3" href="{{ route('admin.product.title3') }}">Update</button>
        </div>
    </div>
</form>
@else
<form method="post" id="general-form-title3">
    @csrf
    <input type="hidden" name="is_saved" value="1">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Title:</label>
            <input type="text" class="form-control" placeholder="Enter title" name="title" required>
        </div>
   		
    </div>
    <div class="form-group row">
        <div class="col-lg-3">
            <label class="">Image:</label>
            <input type="file" class="form-control" placeholder="Enter image" name="image" required>
        </div>
        <div class="col-lg-6">
            <label>Description:</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
    </div>
     <div class="form-group row">
        <div class="col-lg-3">
            <label class="">Image:</label>
            <input type="file" class="form-control" placeholder="Enter image" name="image1" required>
        </div>
        <div class="col-lg-6">
            <label>Description:</label>
            <textarea name="description1" class="form-control" required></textarea>
        </div>
    </div>
	<input type="hidden" id="product_id" class="product_id" name="product_id" value="{{ $product_id }}" >
    <div class="form-group row">
        <div class="col-lg-4"></div>
        <div class="col-lg-8">
            <button type="submit" class="btn btn-primary update_title3" href="{{ route('admin.product.title3') }}">Update</button>
        </div>
    </div>
</form>
@endif