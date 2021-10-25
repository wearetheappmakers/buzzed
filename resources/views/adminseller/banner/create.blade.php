<div class="kt-portlet__body">
{{-- <input type="hidden" name="type" value="NULL"> --}}
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" required>
        </div>
        <div class="col-lg-4">
            <label class="">Link:</label>
            <input type="url" class="form-control" placeholder="Enter link" name="link">
        </div>
        <div class="col-lg-4">
            <label class="">Image:</label>
            <input type="file" class="form-control" placeholder="Enter image" name="image">
        </div>
    </div>
    @include('admin.layout.status_checkbox',array('data' => ""))
</div>