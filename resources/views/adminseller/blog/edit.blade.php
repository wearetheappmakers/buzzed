

    <!-- <script src="https://shrayati.com/shrayati/assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js" type="text/javascript"></script> -->
@php
$edit = $data['edit'];
$blogcategories = $data['blogcategories'];
// dd($blogcategories[0]);
@endphp
<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-3">
            <label>Name:</label>
            <input type="text" class="form-control" value="{{$edit->name}}" placeholder="Enter name" name="name" required>
        </div>
        <div class="col-lg-3">
            <label>Blog Category</label>
            <select class="form-control" name="blog_category_id">
                <option value="">Select</option>
                @foreach($blogcategories as $key)
                    <option @if($edit->blog_category_id == $key->id) selected @endif value="{{ $key->id }}">{{ $key->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-6">
             <label>Description:</label>
            <textarea name="description" id="description" class="form-control">{{ $edit->description }}</textarea>
        </div>

    </div>

    <div class="form-group row">
        <div class="col-lg-4">
            <label>Image:</label>
            <input type="file" class="form-control" placeholder="Enter image" name="image">
        </div>
        <div class="col-lg-4">
            <label>Banner Image:</label>
            <input type="file" class="form-control" placeholder="Enter banner image" name="banner_image">
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-lg-4">
             <div class="image_layer">
                <div class="image_div">
                    <a target="_blank"  href="{{ url('storage/uploads/blog/'.$edit->image) }}" rel="gallery" class="fancybox" title="">
                        <img src="{{ url('storage/uploads/blog/Tiny/'.$edit->image) }}" class="img-thumbnail" alt="{{ $edit->image }}" />
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
             <div class="image_layer">
                <div class="image_div">
                    <a target="_blank"  href="{{ url('storage/uploads/blogbanner/'.$edit->banner_image) }}" rel="gallery" class="fancybox" title="">
                        <img src="{{ url('storage/uploads/blogbanner/Tiny/'.$edit->banner_image) }}" class="img-thumbnail" alt="{{ $edit->banner_image }}" />
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
         <div class="col-lg-4">
            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                <input type="checkbox" name="is_home" @if($edit->is_home == 1) checked @endif value="1"> Home
                <span></span>
            </label>
        </div>
    </div>
     @include('admin.layout.status_checkbox',array('data' => $edit->status))
</div>

@push('scripts')
<script type="text/javascript">
ClassicEditor
    .create( document.querySelector('#description') )
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );
 
</script>
@endpush