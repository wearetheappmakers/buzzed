<?php $__env->startSection('content'); ?>
<form class="kt-form login_form" id="login_form"  role="form" method="POST" action="<?php echo e(url('/customer/login')); ?>">
                        <?php echo e(csrf_field()); ?>

                        	<div class="kt-login__signin">
								<div class="kt-login__head">
									<h3 class="kt-login__title">Sign In To Customer</h3>
								</div>
								</div>

                        <div class="input-group <?php echo e($errors->has('number') ? ' has-error' : ''); ?>">
                                <input id="number" type="text" class="form-control" name="number" placeholder="Mobile No" onkeypress="return isNumber(event)" onkeyup="CheckCustomer($(this).val())" maxlength="10" value="<?php echo e(old('number')); ?>" autofocus>

                        </div>
                        <span class="help-block">
                            <strong class="error"><?php echo e($errors->first('number')); ?></strong>
                        </span>

                                <?php if($errors->has('number')): ?>
                                    <span class="help-block">
                                        <strong class="error"><?php echo e($errors->first('number')); ?></strong>
                                    </span>
                                <?php endif; ?>
                        <!-- <div class="input-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password">

                                
                        </div>
<?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?> -->
	                        
								<div class="kt-login__actions">
									<button type="submit" id="submit" disabled="" class="btn btn-brand btn-elevate kt-login__btn-primary">Sign In</button>
									<!-- <a href="<?php echo e(url('/customer/register')); ?>"><button type="button" id="submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Register</button></a> -->
								</div>
                    </form>

                <script type="text/javascript">
                	function isNumber(evt) {
				        evt = (evt) ? evt : window.event;
				        var charCode = (evt.which) ? evt.which : evt.keyCode;
				        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				            return false;
				        }
				        return true;
				    }

				    function CheckCustomer(evt){
					    $.ajax({

		                    type: "POST",

		                    url: "<?php echo e(route('customer.validate')); ?>",

		                    data: {
		                    	"_token": "<?php echo e(csrf_token()); ?>",
		                    	"number": evt
		                    },

		                    success: function(data) {

		                        if (data.success) {

		                        	$('.error').html('');
									$('#submit').attr('disabled',false);

		                        } else {
		                           	
		                           	$('.error').html('Please Enter buzzed register number');
		                        	$('#submit').attr('disabled',true);
		                        }

		                    },
		                });
				    }
                </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\rohit\buzzed\buzzed\resources\views/customer/auth/login.blade.php ENDPATH**/ ?>