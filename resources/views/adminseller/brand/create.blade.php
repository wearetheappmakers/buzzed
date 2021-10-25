<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Brand Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" required>
        </div>
        <div class="col-lg-4">
            <label class="">Description:</label>
            <textarea class="form-control" rows="3" placeholder="Enter description" name="description"></textarea>
        </div>
        <div class="col-lg-4">
            <label class="">Image:</label>
            <input type="file" class="form-control" placeholder="Enter image" name="image">
        </div>
    </div>
    @include('admin.layout.status_checkbox',array('data' => ""))
</div>