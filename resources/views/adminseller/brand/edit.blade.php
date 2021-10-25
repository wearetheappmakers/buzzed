@php
$edit = $data['edit'];
$type= 'Product';
@endphp
<div class="kt-portlet__body">
    <div class="form-group row">
        <input type="hidden" name="id" value="{{ $edit->id }}">
        <div class="col-lg-4">
            <label>Brand Name:</label>
            <input type="text" class="form-control" value="{{ $edit->name }}" placeholder="Enter name" name="name" required>
        </div>
         <div class="col-lg-4">
            <label class="">Description:</label>
            <textarea class="form-control" rows="3" placeholder="Enter description" name="description">{{$edit->description}}</textarea>
        </div>
        <div class="col-lg-4">
            <label class="">Image:</label>&nbsp;&nbsp;
           
            <input type="file" class="form-control" placeholder="Enter image" name="image">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-8">
             @include('admin.layout.status_checkbox',array('data' => $edit->status))
        </div>
        <div class="col-lg-4">
             @if($edit->image)
                <div class="image_layer">
                    <div class="image_div">
                        <a target="_blank"  href="{{ url('storage/uploads/brand/'.$edit->image) }}" rel="gallery" class="fancybox" title="">
                            <img src="{{ url('storage/uploads/brand/Tiny/'.$edit->image) }}" class="img-thumbnail" alt="{{ $edit->image }}" />
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
        
</div>