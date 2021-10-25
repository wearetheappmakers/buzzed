<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" required>
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