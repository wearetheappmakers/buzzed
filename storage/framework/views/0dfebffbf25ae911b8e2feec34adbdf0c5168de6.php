<?php $__env->startPush('styles'); ?>

<link rel="stylesheet" href="<?php echo e(asset('assets/plugins/custom/jquery-ui/jquery-ui.bundle.css')); ?>" />

<?php $__env->stopPush(); ?>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

<?php echo csrf_field(); ?>

<?php if(count($action)): ?>
<div class="kt-portlet__foot kt-portlet__foot--lg" style="visibility: hidden;">

    <!-- <form action="#" method="POST"> -->

    <div class="row" >

        <div class="col-sm-2">

            <div class="form-group">

                <select name="action" id="action" class="action change_status form-control">

                    <option value="">Select</option>

                    <?php $__currentLoopData = $action; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>

            </div>

        </div>

    </div>

    <div class="col-sm-3">

        <button type="button" class="btn btn-primary mr-2" id="multiple-action">Apply</button>

    </div>

    <!-- </form> -->

</div>
<?php endif; ?>

<input type="hidden" name="status_url" id="status_url" value="<?php echo e(route('admin.home.change-multiple-status')); ?>" />
<input type="hidden" name="delete_url" id="delete_url" value="<?php echo e(route('admin.home.delete-multiple')); ?>" />
<input type="hidden" name="discount_url" id="discount_url" value="<?php echo e(route('admin.home.discount-multiple')); ?>" />
<?php if(isset($folder_name)): ?>
<input type="hidden" name="folder_name" id="folder_name" value="<?php echo e($folder_name); ?>" />
<?php endif; ?>

<input type="hidden" name="orderby_url" id="orderby_url" value="<?php echo e(route('admin.home.change-order')); ?>" />

<?php if(isset($folder_name)): ?>
<input type="hidden" name="table_name" id="table_name" value="<?php echo e($table_name); ?>" />
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>

<?php if(Auth::guard('waiter')->check()): ?>
    <?php 
        $status = route('waiter.change-multiple-status');
    ?>
<?php endif; ?>

<?php if(Auth::guard('manager')->check()): ?>
    <?php 
        $status = route('manager.change-multiple-status');
    ?>
<?php endif; ?>

<?php if(Auth::guard('admin')->check()): ?>
    <?php 
        $status = route('admin.home.change-multiple-status');
    ?>
<?php endif; ?>

<?php if(isset($is_orderby) && $is_orderby == 'yes'): ?>

<?php if(Auth::guard('vendor')->check()): ?>
    <?php
        $user = 'vendor';
        $url = route('vendor.product'); 
        $price_update = route('vendor.product.product_price_update'); 
        $product_priceselling_update = route('vendor.product.product_priceselling_update'); 
        $inventory_update = route('vendor.product.inventory_update'); 
    ?>
<?php else: ?>
    <?php 
        $user = 'admin'; 
        $url = route('admin.product.index'); 
        $price_update = route('admin.product.product_price_update'); 
        $product_priceselling_update = route('admin.product.product_priceselling_update'); 
        $inventory_update = route('admin.product.inventory_update'); 
    ?>
<?php endif; ?>

<!-- <link rel="stylesheet" href="/assets/js/jquery-ui/jquery-ui-1.10.3.custom.min.css" /> -->

<!-- <script type="text/javascript" src="<?php echo e(asset('assets/plugins/custom/jquery-ui/jquery-ui.bundle.css')); ?>"></script> -->

<script type="text/javascript" src="<?php echo e(asset('assets/plugins/custom/jquery-ui/jquery-ui.bundle.js')); ?>"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $("#datatable_rows").sortable({

            items: ".row-move",

            cursor: 'move',

            handle: ".handle",

            opacity: 0.5,

            update: function(event, ui) {

                jQuery.ajax({

                    type: 'GET',

                    dataType: 'json',

                    success: function(data) {
                        if (data.status == 'Success') {
                            toastr["success"](data.message, "Success");
                        }
                    },

                    data: $(this).sortable('serialize'),

                    url: $('#orderby_url').val() + '?table_name=' + $('#table_name').val()

                });

            }

        });

        // $("#sortable").disableSelection();
        $("#image-rows").sortable({

            items: ".row-move",

            cursor: 'move',

            handle: ".handle",

            opacity: 0.5,

            update: function(event, ui) {

                jQuery.ajax({

                    type: 'GET',

                    dataType: 'json',

                    success: function(data) {
                        if (data.status == 'Success') {
                            toastr["success"](data.message, "Success");
                        }
                    },

                    data: $(this).sortable('serialize'),

                    url: $('#orderby_url').val() + '?table_name=' + $('#table_name').val()

                });

            }

        });

    });



    $(document).on("click", "#multiple-action", function() {

        if ($('#action').val() == "") {

            alert("Please select an action");

            return false;

        } else {

            if ($('.allcheckbox:checked').length > 0) {

                var ids = [];

                $('.allcheckbox').each(function() {

                    if ($(this).is(':checked')) {

                        ids.push($(this).val());

                    }

                });

                var rowparam = $('#action').val().split('-');

                if ($('#action').val() == "delete") {
                    if (confirm("Are you sure ?")) {
                        $("#multiple-action").addClass('disabled');
                        DeleteMultiple(ids);
                    }

                } else if($('#action').val() == "discount"){
                    if (confirm("Are you sure ?")) {
                        $("#multiple-action").addClass('disabled');
                        DiscountMultiple(ids);
                    }
                    
                } else if (rowparam[0] == "change") {

                    var params = '';

                    params = rowparam[2];

                    var field = rowparam[1];

                    $("#multiple-action").addClass('disabled');

                    ChangeMultiple(ids, field, params);

                }

            } else {

                alert("Select any checkbox");

            }

        }

    });



    $("#selectall").on('click', function() { // bulk checked

        var status = this.checked;

        $(".allcheckbox").each(function() {

            $(this).prop("checked", status);

        });

    });



    $(document).on("click", ".delete-record", function() {

        if (confirm("Are you sure ?")) {

            var parent = $(this);

            parent.addClass('disabled');

            parent.html('<i class="fa fa-spinner fa-spin"></i>');

            var ids = [];

            ids.push($(this).data('id'));

            DeleteMultiple(ids);

        }

        return false;

    });

    function DiscountMultiple(ids) {
        newurl = '&id=' + ids;
        $.ajax({
            type: 'GET',
            url: "<?php echo e(route('admin.product.get_discount_popup')); ?>",
            data: newurl,
            dataType: 'json',

            
        });
    }

    function DeleteMultiple(ids) {

        var table = $('#table_name').val();

        var newurl = '';

        var folder_name = $('#folder_name').val();

        if (folder_name == '') {

            newurl = 'table_name=' + table + '&id=' + ids;

        } else {

            newurl = 'table_name=' + table + '&id=' + ids + '&folder_name=' + folder_name;

        }



        $.ajax({

            type: 'GET',

            url: $('#delete_url').val(),

            data: newurl,

            dataType: 'json',

            success: function(data) {

                if (data.status == 'Success') {

                    $(ids).each(function() {

                        $('#row-' + this).remove();

                    });
                    toastr["success"](data.message, "Success");
                    alert(data.message);

                } else {
                    toastr["error"](data.message, "Error");
                    $('.delete-record').removeClass('disabled');

                    $('.delete-record').html('<i style="color: white;" class="la la-trash"></i >');

                }

                $("#multiple-action").removeClass('disabled');

            }

        });

    }

    $(document).on("change", ".change_status", function() {
        var parent = $(this);
        var ids = [];
        var idrow = this.id.split('-');
        ids.push(idrow[1]);
        // console.log(idrow);
        var params = '';
        var rowparam = parent.attr('href').split('-');
        if (rowparam[1] == '1') {
            params = '0';
        } else {
            params = '1';
        }

        var field = rowparam[0];
        ChangeMultiple(ids, field, params);
        return false;
    });


    function ChangeMultiple(ids, field, params) {

        var table = $('#table_name').val();

        $(ids).each(function() {

            $('#' + field + '-' + this).addClass('disabled');

            $('#' + field + '-' + this).html('<i class="fa fa-spinner fa-spin"></i>');

        });

        $.ajax({

            type: 'GET',

            url: "<?php echo e($status); ?>",

            data: 'id=' + ids + '&table_name=' + table + '&field=' + field + '&param=' + params,

            dataType: 'json',


            success: function(data) {
                if (data.status == 'Success') {
                    toastr["success"](data.message, "Success");
                    $(ids).each(function() {
                        if (params == '1') {
                            $('#' + field + '-' + this).attr('href', field + '-1');
                        } else {
                            $('#' + field + '-' + this).attr('href', field + '-0');
                        }
                        $('#' + field + '-' + this).removeClass('disabled');
                        $("#multiple-action").removeClass('disabled');
                    });
                } else {
                    toastr["error"](data.message, "Error");
                }
            }

        });

    }

    function editprice($this,priceid){
        $($this).closest('.priceclass').find('.priceclasssavebtn').prop('disabled',false);
        $($this).closest('.priceclass').find('.priceclasseditbtn').prop('disabled',true);
        $($this).closest('.priceclass').find('.priceclassvalue').prop('disabled',false);
    }

    function saveprice($this,priceid,pid){
        $.ajax({
                type: "POST",
                url: "<?php echo e($price_update); ?>",
                 
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    'id':priceid,
                    'price':$($this).closest('.priceclass').find('.priceclassvalue').val(),
                    'product_id' : pid
                },
                success: function(data) {
                    if (data.status === 'success') {
                        toastr["success"]("Price Update Successfully", "Success");
                    } else if (data.status === 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                }
            });
        $($this).closest('.priceclass').find('.priceclasssavebtn').prop('disabled',true);
        $($this).closest('.priceclass').find('.priceclasseditbtn').prop('disabled',false);
        $($this).closest('.priceclass').find('.priceclassvalue').prop('disabled',true);
    }

    function editsellingprice($this,priceid){
        $($this).closest('.spriceclass').find('.spriceclasssavebtn').prop('disabled',false);
        $($this).closest('.spriceclass').find('.spriceclasseditbtn').prop('disabled',true);
        $($this).closest('.spriceclass').find('.spriceclassvalue').prop('disabled',false);
    }

    function savesellingprice($this,priceid,pid){
        $.ajax({
                type: "POST",
                url: "<?php echo e($product_priceselling_update); ?>",
                 
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    'id':priceid,
                    'wholesale_price':$($this).closest('.spriceclass').find('.spriceclassvalue').val(),
                    'product_id' : pid
                },
                success: function(data) {
                    if (data.status === 'success') {
                        toastr["success"]("Price Update Successfully", "Success");
                    } else if (data.status === 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                }
            });
        $($this).closest('.spriceclass').find('.spriceclasssavebtn').prop('disabled',true);
        $($this).closest('.spriceclass').find('.spriceclasseditbtn').prop('disabled',false);
        $($this).closest('.spriceclass').find('.spriceclassvalue').prop('disabled',true);

    }
</script>

<?php endif; ?>

<?php $__env->stopPush(); ?><?php /**PATH D:\rohit\buzzed\buzzed\resources\views/admin/layout/multiple_action.blade.php ENDPATH**/ ?>