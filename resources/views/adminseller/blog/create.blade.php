<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-3">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" required>
        </div>
        <div class="col-lg-3">
            <label>Blog Category</label>
            <select class="form-control" name="blog_category_id">
                <option value="">Select</option>
                @foreach($blogcategories as $key)
                    <option value="{{$key->id}}">{{$key->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-6">
            <label>Description:</label>
            <textarea class="form-control description" name="description" id="description1"></textarea>
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
            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                <input type="checkbox" name="is_home" value="1"> Home
                <span></span>
            </label>
        </div>
    </div>
    @include('admin.layout.status_checkbox',array('data' => ""))
</div>

@push('scripts')
<script type="text/javascript">

ClassicEditor
    .create( document.querySelector( '#description1' ) )
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );

</script>
@endpush