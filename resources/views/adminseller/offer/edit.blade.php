@php
$edit = $data['edit'];
$categories = $data['categories'];
@endphp
<div class="kt-portlet__body">
<input type="hidden" name="id" value="{{$edit->id}}">
    <div class="form-group row">
        <div class="col-lg-4">
            <label class="">Image:</label>&nbsp;&nbsp;
           
            <input type="file" class="form-control" placeholder="Enter image" name="image">
        </div>
        <div class="col-lg-4">
            <label class="">Offer Belongs To Category:</label>
            <select class="form-control" required name="category_slug">
                <option value="">-- Select Category --</option>
                @if(!empty($categories))
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" @if($edit->category_slug == $category->slug) selected @endif>{{ $category->name }}</option>
                    @endforeach
                @else
                    <option value=""></option>
                @endif
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-4">
             @if($edit->image)
                <div class="image_layer">
                    <div class="image_div">
                        <a target="_blank"  href="{{ url('storage/uploads/banner/'.$edit->image) }}" rel="gallery" class="fancybox" title="">
                            <img src="{{ url('storage/uploads/banner/Tiny/'.$edit->image) }}" class="img-thumbnail" alt="{{ $edit->image }}" />
                        </a>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-8">
             @include('admin.layout.status_checkbox',array('data' => $edit->status))
        </div>
        
    </div>    
</div>