<?php $__env->startSection('content'); ?>
<form class="kt-form login_form" id="login_form"  role="form" method="POST" action="<?php echo e(url('/admin/login')); ?>">
                        <?php echo e(csrf_field()); ?>

                        	<div class="kt-login__signin">
								<div class="kt-login__head">
									<h3 class="kt-login__title">Sign In To Admin</h3>
								</div>
								</div>

                        <div class="input-group <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="<?php echo e(old('email')); ?>" autofocus>

                        </div>

                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                        <div class="input-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password">

                                
                        </div>
<?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
	                        <div class="row kt-login__extra">
									<div class="col">
										<label class="kt-checkbox">
											<input type="checkbox" name="remember"> Remember me
											<span></span>
										</label>
									</div>
									<div class="col kt-align-right">
										<a href="<?php echo e(url('/admin/password/reset')); ?>" class="kt-login__link">Forget Password ?</a>
									</div>
								</div>
								<div class="kt-login__actions">
									<button type="submit" id="submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Sign In</button>
								</div>
                    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\rohit\buzzed\buzzed\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>