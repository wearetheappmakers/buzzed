@php
$edit = $data['edit'];
@endphp
<div class="kt-portlet__body">
    <input type="hidden" name="id" value="{{ $edit->id }}">
    <div class="form-group row">
        <div class="col-lg-4">
                <div class="image_layer">
                    <div class="image_div">
                        @if($edit->image)
                            <a target="_blank"  href="{{ url('storage/uploads/brand/'.$edit->image) }}" rel="gallery" class="fancybox" title="">
                                <img src="{{ url('storage/uploads/testimonial/Tiny/'.$edit->image) }}" class="img-thumbnail" alt="{{ $edit->image }}" />
                            </a>
                        @else
                            <a target="_blank"  href="{{ url('storage/uploads/testimonial/20210330083417654300HpRob.png') }}" rel="gallery" class="fancybox" title="">
                                <img src="{{ url('storage/uploads/testimonial/Tiny/20210330083417654300HpRob.png') }}" class="img-thumbnail" alt="image" />
                            </a>
                        @endif
                    </div>
                </div>
        </div>
        <div class="col-lg-4">
            <label>Vendor Name</label>
            <input type="text" class="form-control" placeholder="Enter name" title="You can't edit vendor name" disabled value="{{ App\User::where('id',$edit->vendor_id)->value('fname')}}" readonly>
        </div>
        <div class="col-lg-4">
            <label>Buyer:</label>
            <input type="text" class="form-control" disabled="" placeholder="Enter "  title="You can't edit buyer name" value="{{ App\User::where('id',$edit->customer_id)->value('fname')}}" readonly>
        </div>
    </div> 
    <div class="form-group row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <label>Date:</label>
             <input type="text" class="form-control" placeholder="Enter name" disabled  title="You can't edit date" value="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $edit->created_at)->format('Y-m-d') }}" readonly>
        </div>
        <div class="col-lg-4">
            <label>Time:</label>
             <input type="text" class="form-control" placeholder="Enter name" disabled  title="You can't edit time" value="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $edit->created_at)->format('H:i a') }}" readonly>
        </div>
     </div>
     <div class="form-group row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <label>Product</label>
            <input type="text" class="form-control" placeholder="Enter Number"  title="You can't edit product name" value="{{DB::table('products')->where('id',$edit->product_id)->value('name')}}" readonly>
        </div>
        <div class="col-lg-4">
            <label>Rating</label>
            <input type="text" class="form-control" placeholder="Enter Number" name="rating" value="{{$edit->rating}}">
        </div>
     </div> 

     <div class="form-group row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <label>Review:</label>
            <textarea class="form-control" placeholder="Enter Description" name="review">{{$edit->review}}</textarea>
        </div>
        <div class="col-lg-4">
            <label>Status:</label>
            <select class="form-control" name="status">
                <option @if($edit->status == 1) selected @endif>Active</option>
                <option @if($edit->status == 0) selected @endif>Inactive</option>
            </select>
        </div>
     </div>   
</div>
