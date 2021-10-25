<?php if(isset($edit)): ?>
<div class="form-group row">
    <div class="col-lg-4">
        <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
            <input type="checkbox" <?php if($data==1): ?> checked <?php endif; ?> name="status" value="1"> Status
            <span></span>
        </label>
    </div> 
</div>
<?php else: ?>
<div class="form-group row">
    <div class="col-lg-4">
        <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
            <input type="checkbox" checked name="status" value="1"> Status
            <span></span>
        </label>
    </div> 
</div>
<?php endif; ?>
<?php /**PATH D:\rohit\buzzed\buzzed\resources\views/admin/layout/status_checkbox.blade.php ENDPATH**/ ?>