<?php
$edit = $data['edit'];
?>
<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" value="<?php echo e($edit->name); ?>" required>
        </div>
        <div class="col-lg-4">
            <label>Contact No:</label>
            <input type="text" class="form-control" placeholder="Enter contact no" value="<?php echo e($edit->number); ?>" onkeypress="return isNumber(event)" maxlength="10" name="number" id="number" required autocomplete="off">
        </div>
        <div class="col-lg-4">
            <label>Email:</label>
            <input type="text" class="form-control" placeholder="Enter email" value="<?php echo e($edit->email); ?>" name="email" id="email" required autocomplete="off" required="">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Gender:</label>
             <select class="form-control" name="gender">
                <option value="1" <?php if($edit->gender == 1): ?> selected <?php endif; ?>>Male</option>
                <option value="2" <?php if($edit->gender == 2): ?> selected <?php endif; ?>>Female</option>
                <option value="3" <?php if($edit->gender == 3): ?> selected <?php endif; ?>>Other</option>
            </select>
        </div>
        <div class="col-lg-4">
            <label>Role:</label>
             <select class="form-control" name="role">
                <option value="1" <?php if($edit->role == 1): ?> selected <?php endif; ?>>Operations Manager</option>
                <option value="2" <?php if($edit->role == 2): ?> selected <?php endif; ?>>Waiters</option>
            </select>
        </div>
        <div class="col-lg-4">
            <label>Password:</label>
            <input type="password" class="form-control" value="<?php echo e($edit->spassword); ?>" placeholder="Enter password" name="spassword" id="spassword" required autocomplete="off">
        </div>
</div>
     <?php echo $__env->make('admin.layout.status_checkbox',array('data' => $edit->status), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\rohit\buzzed\buzzed\resources\views/adminseller/staff/edit.blade.php ENDPATH**/ ?>