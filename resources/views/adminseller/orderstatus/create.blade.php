<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" required>
        </div>
        <div class="col-lg-4">
            <label>Label:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="label" required>
        </div>
        <div class="col-lg-4">
            <label>Description:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="description" required>
        </div>
    </div>
    @include('admin.layout.status_checkbox',array('data' => ""))
    <!-- <div class="form-group row">
        <div class="col-lg-4">
            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                <input type="checkbox" checked name="show_on_timeline" value="1"> show_on_timeline
                <span></span>
            </label>
        </div>
    </div> -->
</div>