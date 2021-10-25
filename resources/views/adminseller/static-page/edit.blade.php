@php
$edit = $data['edit'];
$type= $edit->type;
@endphp
<div class="kt-portlet__body">
<input type="hidden" name="type" value="{{$type}}">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" value="{{$edit->name}}" placeholder="Enter name" name="name" required>
        </div>
        <div class="col-lg-4">
            <label class="">Image:</label>&nbsp;&nbsp;
          
            <input type="file" class="form-control" value="{{$edit->image}}" placeholder="Enter image" name="image">
        </div>
        <div class="col-lg-4">
            <label class="">Banner Image:</label>&nbsp;&nbsp;
        
            <input type="file" class="form-control" value="{{$edit->banner_image}}" placeholder="Enter image" name="banner_image">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-4">
        </div>
        <div class="col-lg-4">
            @if($edit->image)
                <div class="image_layer">
                    <div class="image_div">
                        <a target="_blank"  href="{{ url('storage/uploads/page/'.$edit->image) }}" rel="gallery" class="fancybox" title="">
                            <img src="{{ url('storage/uploads/page/Tiny/'.$edit->image) }}" class="img-thumbnail" alt="{{ $edit->image }}" />
                        </a>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-4">
            @if($edit->banner_image)
                <div class="image_layer">
                    <div class="image_div">
                        <a target="_blank"  href="{{ url('storage/uploads/page/'.$edit->banner_image) }}" rel="gallery" class="fancybox" title="">
                            <img src="{{ url('storage/uploads/page/Tiny/'.$edit->banner_image) }}" class="img-thumbnail" alt="{{ $edit->banner_image }}" />
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-6">
            <label>Description:</label>
            <textarea class="form-control" placeholder="Enter description" name="description">{{$edit->description}}</textarea>
        </div>
        <div class="col-lg-6">
            <label>Short Description:</label>
            <textarea class="form-control" placeholder="Enter short description" name="short_description">{{$edit->short_description}}</textarea>
        </div>
    </div>
     @include('admin.layout.status_checkbox',array('data' => $edit->status))
</div>