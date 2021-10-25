<div class="kt-portlet__body">
<input type="hidden" name="type" value="NULL">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" required>
        </div>
        <div class="col-lg-4">
            <label class="">Image:</label>
            <input type="file" class="form-control" placeholder="Enter image" name="image">
        </div>
        <div class="col-lg-4">
            <label class="">Banner Image:</label>
            <input type="file" class="form-control" placeholder="Enter image" name="banner_image">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-6">
            <label>Description:</label>
            <textarea class="form-control" placeholder="Enter description" name="description"></textarea>
        </div>
        <div class="col-lg-6">
            <label>Short Description:</label>
            <textarea class="form-control" placeholder="Enter short description" name="short_description"></textarea>
        </div>
    </div>
    <?php echo $__env->make('admin.layout.status_checkbox',array('data' => ""), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div><?php /**PATH D:\rohit\buzzed\buzzed\resources\views/adminseller/static-page/create.blade.php ENDPATH**/ ?>