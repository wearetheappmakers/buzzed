<?php
$edit = $data['edit'];
?>
<?php $__env->startPush('styles'); ?>

<?php $__env->stopPush(); ?>
<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Source Name:</label>
            <input type="text" class="form-control" placeholder="Enter Source Name" value="<?php echo e($edit->source_name); ?>" name="source_name" required>
        </div>
        <div class="col-lg-4">
            <label>Discount Percentage:</label>
            <input type="text" class="form-control" value="<?php echo e($edit->discount_per); ?>" placeholder="Enter Discount Percentage" name="discount_per" required>
        </div>
        <!-- <div class="col-lg-4">
            <label>Discount Code:</label>
            <input type="text" class="form-control" value="<?php echo e($edit->discount_code); ?>" placeholder="Enter Discount Code" name="discount_code">
        </div> -->
          <!-- <div class="col-lg-4">
            <label>Start Date:</label>
            <input type="text" class="form-control"  value="<?php echo e(\Carbon\Carbon::parse($edit->discount_start_date)->format('d-m-Y H:i')); ?>" id="start_date" placeholder="Enter Discount Start Date" name="discount_start_date">
        </div>
        <div class="col-lg-4">
            <label>End Date:</label>
            <input type="text" class="form-control" value="<?php echo e(\Carbon\Carbon::parse($edit->discount_end_date)->format('d-m-Y H:i')); ?>" id="end_date" placeholder="Enter Discount End Date" name="discount_end_date">
        </div> -->
         </div>
         <?php echo $__env->make('admin.layout.status_checkbox',array('data' => $edit->status), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('assets/js/pages/crud/forms/widgets/bootstrap-datetimepicker.js')); ?>" type="text/javascript"></script>
<script>
//  $('#start_date, #end_date').datetimepicker({
//      format:'dd-mm-yyyy hh:mm A ',
//  });


       // $('#start_date,#end_date').datetimepicker({
       //      format: "dd-mm-yyyy hh:ii",
       //      startDate: '-1d',
       //      // defaultDate: moment().subtract(1, 'days')
       //  });
       //  $('#start_date').datetimepicker().on('change.dp', function(e) {
       //      var date = $(this).val();
       //      date = date.split("-");
       //      date = date[1] + '-' + date[0] + '-' + date[2];
       //      var minDate = new Date(date);
       //      minDate.setMinutes(minDate.getMinutes() + 5);
       //      $('#end_date').data('datetimepicker').setStartDate(minDate);
       //  });

       //  $('#end_date').datetimepicker().on('change.dp', function(e) {
       //      var date = $(this).val();
       //      date = date.split("-");
       //      date = date[1] + '-' + date[0] + '-' + date[2];
       //      var maxDate = new Date(date);
       //      maxDate.setMinutes(maxDate.getMinutes() - 5);
       //      $('#start_date').data('datetimepicker').setEndDate(maxDate);
       //  });
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\rohit\buzzed\buzzed\resources\views/adminseller/discount/edit.blade.php ENDPATH**/ ?>