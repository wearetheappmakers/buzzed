<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" required>
        </div>
        <div class="col-lg-4">
            <label>Number:</label>
            <input type="text" class="form-control" placeholder="Enter number" onkeypress="return isNumber(event)" maxlength="10" name="number" id="number" required autocomplete="off">
        </div>
        <div class="col-lg-4">
            <label>Outlet:</label>
            <select class="form-control" name="outlet" required="">
                <option value="">-- Select Outlet --</option>
                <?php if(!empty($outlet)): ?>
                    <?php $__currentLoopData = $outlet; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($ol->id); ?>"><?php echo e($ol->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
        </div>

    </div>
    <?php echo $__env->make('admin.layout.status_checkbox',array('data' => ""), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div><?php /**PATH D:\rohit\buzzed\buzzed\resources\views/adminseller/captain/create.blade.php ENDPATH**/ ?>