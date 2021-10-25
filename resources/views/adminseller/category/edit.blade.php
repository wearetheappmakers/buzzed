@php
$edit = $data['edit'];
$readonly ='';
$categories_select = $data['categories_select'];
@endphp
<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" id="name" value="{{$edit->name}}" required {{ $readonly }}>
        </div>
        <div class="col-lg-4">
            <label>Parent Id(If want to add sub-category):</label>
            <select  class="form-control"  name="parent_id"  id="parent_id"  {{ $readonly }}>
                <option value="">Select Parent Category</option>
            @foreach($categories_select as $k=>$c) 
            <option value="{{$k}}" @if($k == $edit->parent_id) selected="selected" @endif>{{html_entity_decode($c)}}</option>
            @endforeach
            </select>
        </div>
       
    </div>
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Description:</label>
            <textarea class="form-control"  {{ $readonly }} placeholder="Enter description" name="description">{{$edit->description}}</textarea>
        </div>
        <div class="col-lg-4">
            <label>Image:</label>
            <input type="file" name="banner_image">
        </div>
        <div class="col-lg-4">
            @if($edit->banner_image)
                <div class="image_layer">
                    <div class="image_div">
                        <a target="_blank" href="{{ url('storage/uploads/category/'.$edit->banner_image) }}" rel="gallery" class="fancybox" title="">
                            <img src="{{ url('storage/uploads/category/Tiny/'.$edit->banner_image) }}" class="img-thumbnail" alt="{{ $edit->banner_image }}" />
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- <div class="form-group row">
        <div class="col-lg-4">
            <label>Image:</label>
            <input type="file" class="form-control" placeholder="Enter image" name="image">
        </div>
        <div class="col-lg-4">
            <label>Banner Image:</label>
            <input type="file" class="form-control" placeholder="Enter image" name="banner_image">
        </div>
    </div> -->
    <!-- <div class="form-group row">
        <div class="col-lg-4">
            @if($edit->backend_image)
                <div class="image_layer">
                    <div class="image_div">
                        <a target="_blank"  href="{{ url('storage/uploads/category/'.$edit->backend_image) }}" rel="gallery" class="fancybox" title="">
                            <img src="{{ url('storage/uploads/category/Tiny/'.$edit->backend_image) }}" class="img-thumbnail" alt="{{ $edit->name }}" />
                        </a>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-4">
            @if($edit->backend_banner_image)
                <div class="image_layer">
                    <div class="image_div">
                        <a target="_blank" href="{{ url('storage/uploads/category/'.$edit->backend_banner_image) }}" rel="gallery" class="fancybox" title="">
                            <img src="{{ url('storage/uploads/category/Tiny/'.$edit->backend_banner_image) }}" class="img-thumbnail" alt="{{ $edit->name }}" />
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div> -->
    @include('admin.layout.status_checkbox',array('data' => $edit->status))
</div>

@push('scripts')
<script>
	// $(document).ready(function() {
    //     $('.delete-record').add
    //     $(document).on('click', '.delete-record',function() {
    //         $(this).find('.la-trash').
    //     });
    // });
</script>
@endpush

