<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>State Name:</label>
            <input type="text" class="form-control" placeholder="Enter country name" name="name" required>
        </div>
        <div class="col-lg-4">
            <label>Phone Code:</label>
            <input type="text" class="form-control" placeholder="Enter phone code" onkeypress="return isNumber(event)" name="phonecode">
        </div>

    </div>
    @include('admin.layout.status_checkbox',array('data' => ""))
</div>