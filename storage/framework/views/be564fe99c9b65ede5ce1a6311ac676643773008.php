<?php $__env->startSection('content'); ?>


<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

    <br>

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <div class="row">

            <div class="col-lg-12">

                <div class="kt-portlet">

                    <div class="kt-portlet__head">

                        <div class="kt-portlet__head-label">

                            <h3 class="kt-portlet__head-title">

                                 <?php echo e($title); ?>


                            </h3>

                        </div>

                    </div>

                    <form class="kt-form kt-form--label-right add_form" method="post" action="<?php echo e($url); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo e($edit->id); ?>">
                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>First Name:</label>
                                    <input type="text" class="form-control" placeholder="Enter first name" name="fname" value="<?php echo e($edit->fname); ?>" id="fname" required autocomplete="off">
                                </div>
                                <div class="col-lg-4">
                                    <label>Last Name:</label>
                                    <input type="text" class="form-control" placeholder="Enter last name" value="<?php echo e($edit->lname); ?>" name="lname" id="lname" required autocomplete="off">
                                </div>
                                <div class="col-lg-4">
                                    <label>Contact No:</label>
                                    <input type="text" class="form-control" placeholder="Enter contact no" onkeypress="return isNumber(event)" maxlength="10" name="number" id="number" value="<?php echo e($edit->number); ?>" required autocomplete="off">
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
                                    <label>Birth Date:</label>
                                    <input type="date" class="form-control" placeholder="Enter Birth Date" name="b_date" value="<?php echo e($edit->b_date); ?>"  id="b_date" required autocomplete="off">
                                </div>

                                <div class="col-lg-4">
                                    <label>Validity Date:</label>
                                    <input type="date" class="form-control" placeholder="Enter Validity Date" name="validity_date" id="validity_date" value="<?php echo e($edit->validity_date); ?>" autocomplete="off">
                                </div>
                                
                            </div>
                            <div class="form-group row">

                                <div class="col-lg-4">
                                    <label>Favourite:</label>
                                    <select class="form-control" name="favourite" id="favourite">
                                        <option value="beer" <?php if($edit->gender == 'beer'): ?> selected <?php endif; ?> >Beer</option>
                                        <option value="whisky" <?php if($edit->gender == 'whisky'): ?> selected <?php endif; ?> >Whisky</option>
                                        <option value="wine" <?php if($edit->gender == 'wine'): ?> selected <?php endif; ?> >Wine</option>
                                        <option value="vodka" <?php if($edit->gender == 'vodka'): ?> selected <?php endif; ?> >Vodka</option>
                                        <option value="rum" <?php if($edit->gender == 'rum'): ?> selected <?php endif; ?> >Rum</option>
                                        <option value="cocktail" <?php if($edit->gender == 'cocktail'): ?> selected <?php endif; ?> >Cocktail</option>
                                    </select>
                                </div>
                                
                                <div class="col-lg-4">
                                    <label>Membership Amount</label>
                                     <input type="text" class="form-control" placeholder="Enter Membership Amount" onkeypress="return isNumber(event)" name="amount" id="amount" value="<?php echo e($edit->amount); ?>" required autocomplete="off">
                                </div>

                                <div class="col-lg-4">
                                    <label>Payment Type</label>
                                    <select class="form-control" data-live-search="true" name="payment_type" required="">
                                        <option value="">--select payment type--</option>
                                        <option value="Cash" <?php if($edit->payment_type == 'Cash'): ?> selected <?php endif; ?> >Cash</option>
                                        <option value="Card" <?php if($edit->payment_type == 'Card'): ?> selected <?php endif; ?> >Card</option>
                                        <option value="UPI" <?php if($edit->payment_type == 'UPI'): ?> selected <?php endif; ?> >UPI</option>
                                    </select>
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-lg-4">
                                        <label>Status:</label>
                                        <select class="form-control" name="status">
                                            <option value="1" <?php if($edit->status == 1): ?> selected <?php endif; ?>>Active</option>
                                            <option value="0" <?php if($edit->status == 0): ?> selected <?php endif; ?>>Inactive</option>
                                        </select>
                                    </div>
                            </div>

                        </div>

                        <div class="kt-portlet__foot">

                            <div class="kt-form__actions">

                                <div class="row">

                                    <div class="col-lg-4"></div>

                                    <div class="col-lg-8">

                                        <button type="button" class="btn btn-primary submit change_button">Update<i class="la la-spinner change_spin d-none"></i></button>

                                        <a href="<?php echo e($index); ?>"><button type="button" class="btn btn-secondary">Cancel</button></a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

    $(document).ready(function() {

        $(".submit").on("click", function(e) {
            
            e.preventDefault();

            if ($(".add_form").valid()) {
                
                $('.change_button').find('.change_spin').removeClass('d-none');
                $('.change_button').prop('disabled', true);

                $.ajax({

                    type: "POST",

                    url: "<?php echo e($url); ?>",

                    data: new FormData($('.add_form')[0]),

                    processData: false,

                    contentType: false,

                    success: function(data) {

                        if (data.status === 'success') {
                            
                            window.location = "<?php echo e($index); ?>";

                            toastr["success"]("<?php echo e($module); ?> Updated Successfully", "Success");

                            

                        } else if (data.status === 'error') {
                            location.reload();

                            toastr["error"]("Something went wrong", "Error");

                        }

                    },
                    error :function( data ) {
                        console.log(data.status)
                        if(data.status === 422) {
                            var errors = $.parseJSON(data.responseText);
                            $.each(errors.errors, function (key, value) {
                                console.log(key+ " " +value);
                                $('#'+key).addClass('is-invalid');
                                 $('#'+key).parent().append('<div id="'+key+'-error" class="error invalid-feedback ">'+value+'</div>');
                            });
                                
                            }

                    }

                });

            } else {
                $('.change_button').prop('disabled', false);
                $('.change_button').find('.change_spin').addClass('d-none');
                e.preventDefault();

            }

        });

    });
    
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

</script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\rohit\buzzed\buzzed\resources\views/adminseller/vendors/edit.blade.php ENDPATH**/ ?>