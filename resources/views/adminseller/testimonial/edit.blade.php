@php
$edit = $data['edit'];
@endphp
<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" value="{{$edit->name}}" placeholder="Enter name" name="name" required>
        </div>
        <div class="col-lg-8">
             <label>Description:</label>
            <textarea class="form-control" placeholder="Enter Description" name="description">{{$edit->code}}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Select</label><br>
            <label class="kt-radio kt-radio--bold kt-radio--brand">
                <input type="radio" id="is_image" @if($edit->is_check == 0) checked @endif name="is_check" value="0"> Image
                <span></span>
            </label> &nbsp;&nbsp;&nbsp;&nbsp;
            <label class="kt-radio kt-radio--bold kt-radio--brand">
                <input type="radio" id="is_videolink" @if($edit->is_check == 1) checked @endif name="is_check" value="1"> Video Link
                <span></span>
            </label>
        </div>
        
        <div class="col-lg-4" id="videolink_tab" style="display: none">
            <label>Video Link:</label>
        <input type="url" class="form-control" name="videolink" value="{{$edit->videolink}}">
        </div>
        
        <div class="col-lg-4" id="image_tab" style="display: none">
            <label>Media:</label>
            <input type="file" class="form-control" name="media">
        </div>
        @if($edit->is_check == 0)
        <div class="col-lg-4" id="img_dispaly" style="display: none;">
            <div class="image_layer">
                <div class="image_div">
                    <a target="_blank"  href="{{ url('storage/uploads/testimonial/'.$edit->media) }}" rel="gallery" class="fancybox" title="">
                        <img src="{{ url('storage/uploads/testimonial/Tiny/'.$edit->media) }}" class="img-thumbnail" alt="{{ $edit->media }}" />
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
    @include('admin.layout.status_checkbox',array('data' => $edit->status))
    <input type="hidden" id="hidden_data" value="{{$edit->is_check}}">
</div>
<script>		
    $(document).ready(function()
    {
        var v1 = $('#hidden_data').val();
        if(v1 ==1)
        {
            $('#image_tab').css('display','none');
            $('#videolink_tab').css('display','block');
            $('#img_dispaly').css('display','none');
        } else if(v1 == 0)
        {
            $('#image_tab').css('display','block');
            $('#videolink_tab').css('display','none');
            $('#img_dispaly').css('display','block');
        }
        $('#is_image').click(function() 
        {
            $('#image_tab').css('display','block');
            $('#videolink_tab').css('display','none');
            $('#img_dispaly').css('display','block');
        });
        $('#is_videolink').click(function() 
        {
            $('#image_tab').css('display','none');
            $('#videolink_tab').css('display','block');
            $('#img_dispaly').css('display','none');
        });
    });
</script>