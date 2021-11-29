<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" required>
        </div>
        <div class="col-lg-4">
            <label>Contact No:</label>
            <input type="text" class="form-control" placeholder="Enter contact no" value="" onkeypress="return isNumber(event)" maxlength="10" name="number" id="number" required autocomplete="off">
        </div>
        <div class="col-lg-4">
            <label>Email:</label>
            <input type="text" class="form-control" placeholder="Enter email" value="" name="email" id="email" required autocomplete="off" required="">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Gender:</label>
             <select class="form-control" name="gender">
                <option value="1">Male</option>
                <option value="2">Female</option>
                <option value="3">Other</option>
            </select>
        </div>
        <!-- <div class="col-lg-4">
            <label>Role:</label>
             <select class="form-control" name="role">
                <option value="1">Operations Manager</option>
                <option value="2">Waiters</option>
            </select>
        </div> -->
        <div class="col-lg-4">
            <label>Password:</label>
            <input type="password" class="form-control" value="12345678" placeholder="Enter password" name="spassword" id="spassword" required autocomplete="off">
        </div>
        <div class="col-lg-4">
            <label>Upload ID/Proof Image:</label>
            <input type="file" class="form-control" name="image">
        </div>
</div>
<?php echo $__env->make('admin.layout.status_checkbox',array('data' => ""), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\rohit\buzzed\buzzed\resources\views/adminseller/staff/create.blade.php ENDPATH**/ ?>