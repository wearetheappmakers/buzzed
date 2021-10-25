<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" required>
        </div>
    </div>
    <?php echo $__env->make('admin.layout.status_checkbox',array('data' => ""), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div><?php /**PATH D:\rohit\buzzed\buzzed\resources\views/adminseller/outlet/create.blade.php ENDPATH**/ ?>