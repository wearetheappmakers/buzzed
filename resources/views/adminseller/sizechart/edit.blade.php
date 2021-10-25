@php
$edit = $data['edit'];
@endphp
<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Image:</label>
            <input type="file" class="form-control" value="{{$edit->name}}" placeholder="Enter name" name="name">
        </div>
        
    </div>
     @include('admin.layout.status_checkbox',array('data' => $edit->status))
     <div class="row">
         <div class="image_layer">
            <div class="image_div">
                <a target="_blank"  href="{{ url('storage/uploads/sizechart/'.$edit->name) }}" rel="gallery" class="fancybox" title="">
                    <img src="{{ url('storage/uploads/sizechart/Tiny/'.$edit->name) }}" class="img-thumbnail" alt="{{ $edit->name }}" />
                </a>
            </div>
        </div>
     </div>
</div>