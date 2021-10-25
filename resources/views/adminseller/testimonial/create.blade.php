<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" required>
        </div>
        <div class="col-lg-8">
            <label>Description:</label>
            <textarea class="form-control" placeholder="Enter Description" name="description"></textarea>
        </div>
    </div>
    <div class=" form-group row">
        <div class="col-lg-4">
            <label>Select</label><br>
            <label class="kt-radio kt-radio--bold kt-radio--brand">
                <input type="radio" id="is_image" name="is_check" value="0"> Image
                <span></span>
            </label> &nbsp;&nbsp;&nbsp;&nbsp;
            <label class="kt-radio kt-radio--bold kt-radio--brand">
                <input type="radio" id="is_videolink" name="is_check" value="1"> Video Link
                <span></span>
            </label>
        </div>
        <div class="col-lg-4" id="videolink_tab" style="display: none">
            <label>Video Link:</label>
            <input type="url" class="form-control" name="videolink">
        </div>
        <div class="col-lg-4" id="image_tab" style="display: none">
            <label>Media:</label>
            <input type="file" class="form-control" name="media">
        </div>
    </div>
    @include('admin.layout.status_checkbox',array('data' => ""))
</div>
<script>		
    $(document).ready(function()
    {
        $('#is_image').click(function() 
        {
            $('#image_tab').css('display','block');
            $('#videolink_tab').css('display','none');
        });
        $('#is_videolink').click(function() 
        {
            $('#image_tab').css('display','none');
            $('#videolink_tab').css('display','block');
        });
    });
</script>