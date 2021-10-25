<?php $__env->startSection('content'); ?>

<!-- <?php
$waiting_order = DB::table('order_headers')->where('order_status_id',1)->count();
$preparing_order = DB::table('order_headers')->where('order_status_id',2)->count();
$ontheway_order = DB::table('order_headers')->where('order_status_id',3)->count();
$comp_order = DB::table('order_headers')->where('order_status_id',4)->count();
$cancel_order = DB::table('order_headers')->where('order_status_id',5)->count();
$return_order = DB::table('order_headers')->where('order_status_id',6)->count();

$month_order_cod = DB::table('order_headers')->where('payment_type','COD')->whereMonth('created_at', '=', date('m'))->count();
$month_order_online = DB::table('order_headers')->where('payment_type','online')->whereMonth('created_at', '=', date('m'))->count();
$total_month_order = $month_order_cod + $month_order_online;
$month_order_cod_count = DB::table('order_headers')->where('payment_type','COD')->whereMonth('created_at', '=', date('m'))->sum('total_price');
$month_order_online_count = DB::table('order_headers')->where('payment_type','online')->whereMonth('created_at', '=', date('m'))->sum('total_price');
$total_month_order_count = $month_order_cod_count + $month_order_online_count;

$cod_order = DB::table('order_headers')->where('payment_type','COD')->sum('total_price');
$online_order = DB::table('order_headers')->where('payment_type','online')->sum('total_price');
$count_cod_order = DB::table('order_headers')->where('payment_type','COD')->count();
$count_online_order = DB::table('order_headers')->where('payment_type','online')->count();
$count_total = $count_cod_order + $count_online_order;
?> -->
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<br>
	
	<?php if(Auth::user()->id == 1): ?>
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="row">
			<div class="col-lg-2" style="cursor: pointer;" data-toggle="modal" data-target="#kt_modal_4">
				<div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-fast">
					<div class="kt-portlet__body">
						<div class="kt-iconbox__body">
							
							<div class="kt-iconbox__desc">
								<h3 class="kt-iconbox__title">
									<a class="kt-link" href="#">Add Order</a>
								</h3>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- <div class="col-md-12 col-lg-2 col-xl-2">
				<div class="kt-widget24" style="background-color: #DAF7A6; border: solid 1px;">
					<div class="kt-widget24__details">
						<div class="kt-widget24__info">
							<button type="button" class="btn btn-brand  btn-upper btn-bold  kt-inbox__compose" data-toggle="modal" data-target="#kt_inbox_compose">new message</button>
							<a class="kt-widget24__title" style="font-size: 15px; color: black;">
								Add Order
							</a>
						</div>
						<span class="kt-widget24__stats kt-font-brand">
							<a style="color: white;"><?php echo e($waiting_order); ?></a>
						</span>
					</div>
					<div class="kt-widget24__action">
						<a href="<?php echo e(route('admin.order.status.index',1)); ?>" class="small-box-footer" style="color: green; font-size: 12px;">view <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
			</div> -->
			<!-- <div class="col-md-12 col-lg-2 col-xl-2">
				<div class="kt-widget24" style=" background-color: #61FFC6; border: solid 1px;">
					<div class="kt-widget24__details">
						<div class="kt-widget24__info">
							<a class="kt-widget24__title" style="font-size: 15px; color: black;">
								Preparing
							</a>
						</div>
						<span class="kt-widget24__stats kt-font-warning">
							<a style="color: white;"><?php echo e($preparing_order); ?></a>
						</span>
					</div>
					<div class="kt-widget24__action">
						<a href="<?php echo e(route('admin.order.status.index',2)); ?>" class="small-box-footer" style="color: green; font-size: 12px;">view <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-2 col-xl-2">
				<div class="kt-widget24" style="background-color: #9A9DFF; border: solid 1px;">
					<div class="kt-widget24__details">
						<div class="kt-widget24__info">
							<a class="kt-widget24__title" style="font-size: 15px; color: black;">
								On the way
							</a>
						</div>
						<span class="kt-widget24__stats kt-font-danger">
							<a style="color: white;"><?php echo e($ontheway_order); ?></a>
						</span>
					</div>
					<div class="kt-widget24__action">
						<a href="<?php echo e(route('admin.order.status.index',3)); ?>" class="small-box-footer" style="color: green; font-size: 12px;">view <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-2 col-xl-2">
				<div class="kt-widget24" style="background-color: #8BFF83; border: solid 1px;">
					<div class="kt-widget24__details">
						<div class="kt-widget24__info">
							<a class="kt-widget24__title" style="font-size: 15px; color: black;">
								Completed
							</a>
						</div>
						<span class="kt-widget24__stats kt-font-success">
							<a style="color: white;"><?php echo e($comp_order); ?></a>
						</span>
					</div>
					<div class="kt-widget24__action">
						<a href="<?php echo e(route('admin.order.status.index',4)); ?>" class="small-box-footer" style="color: green; font-size: 12px;">view <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-2 col-xl-2">
				<div class="kt-widget24" style="background-color: #FD7F62; border: solid 1px;">
					<div class="kt-widget24__details">
						<div class="kt-widget24__info">
							<a class="kt-widget24__title" style="font-size: 15px; color: black;">
								Cancel
							</a>
						</div>
						<span class="kt-widget24__stats kt-font-success">
							<a style="color: white;"><?php echo e($cancel_order); ?></a>
						</span>
					</div>
					<div class="kt-widget24__action">
						<a href="<?php echo e(route('admin.order.status.index',5)); ?>" class="small-box-footer" style="color: green; font-size: 12px;">view <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-2 col-xl-2">
				<div class="kt-widget24" style="background-color: #FFB341; border: solid 1px;">
					<div class="kt-widget24__details">
						<div class="kt-widget24__info">
							<a class="kt-widget24__title" style="font-size: 15px; color: black;">
								Return
							</a>
						</div>
						<span class="kt-widget24__stats kt-font-success">
							<a style="color: white;"><?php echo e($return_order); ?></a>
						</span>
					</div>
					<div class="kt-widget24__action">
						<a href="<?php echo e(route('admin.order.status.index',6)); ?>" class="small-box-footer" style="color: green; font-size: 12px;">view <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
			</div> -->
		</div>
	</div>
	<br>

	<!-- <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="kt-portlet kt-portlet--height-fluid">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
						Order history
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<a>

					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-md">
						<ul class="kt-nav">

						</ul>
					</div>
				</div>
			</div>
			<div class="kt-portlet__body">
				<div class="row">
					<h4>All Order</h4>
					<div class="col-lg-12">
						<div class="kt-widget16">
							<div class="kt-widget16__items">
								<div class="kt-widget16__item">
									<span class="kt-widget16__sceduled">
										Type
									</span>
									<span class="kt-widget16__amount">
										Amount
									</span>
								</div>
								<div class="kt-widget16__item">
									<span class="kt-widget16__date">
										Prepaid
									</span>
									<span class="kt-widget16__price  kt-font-brand">
										&#8377; <?php echo e($online_order); ?>

									</span>
								</div>
								<div class="kt-widget16__item">
									<span class="kt-widget16__date">
										COD
									</span>
									<span class="kt-widget16__price  kt-font-success">
										&#8377; <?php echo e($cod_order); ?>

									</span>
								</div>
								<div class="kt-widget16__item">
									<span class="kt-widget16__date">
										Total
									</span>
									<span class="kt-widget16__price  kt-font-danger">
										<?php $total = $cod_order + $online_order ?>
										&#8377; <?php echo e($total); ?>

									</span>
								</div>

							</div>
							<div class="kt-widget16__stats">
								<div class="kt-widget16__visual">
									<div class="kt-widget16__chart">
										<div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
										<div class="kt-widget16__stat"><?php echo e($count_total); ?></div>
										<canvas id="kt_chart_support_requests" style="height: 140px; width: 140px; display: block;" width="140" height="140" class="chartjs-render-monitor"></canvas>
									</div>
								</div>
								<div class="kt-widget16__legends">
									<div class="kt-widget16__legend">
										<span class="kt-widget16__bullet" style="background-color: #FFA07A;"></span>
										<span class="kt-widget16__stat"><?php echo e($count_cod_order); ?> COD</span>
									</div>
									<div class="kt-widget16__legend">
										<span class="kt-widget16__bullet" style="background-color: #FFC0CB; !important"></span>
										<span class="kt-widget16__stat"><?php echo e($count_online_order); ?> Prepaid</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<h4>This month</h4>
					<div class="col-lg-12">
						<div class="kt-widget16">
							<div class="kt-widget16__items">
								<div class="kt-widget16__item">
									<span class="kt-widget16__sceduled">
										Type
									</span>
									<span class="kt-widget16__amount">
										Amount
									</span>
								</div>
								<div class="kt-widget16__item">
									<span class="kt-widget16__date">
										Prepaid
									</span>
									<span class="kt-widget16__price  kt-font-brand">
										&#8377; <?php echo e($month_order_online_count); ?>

									</span>
								</div>
								<div class="kt-widget16__item">
									<span class="kt-widget16__date">
										COD
									</span>
									<span class="kt-widget16__price  kt-font-success">
										&#8377; <?php echo e($month_order_cod_count); ?>

									</span>
								</div>
								<div class="kt-widget16__item">
									<span class="kt-widget16__date">
										Total
									</span>
									<span class="kt-widget16__price  kt-font-danger">
										&#8377; <?php echo e($total_month_order_count); ?>

									</span>
								</div>

							</div>
							<div class="kt-widget16__stats">
								<div class="kt-widget16__visual">
									<div class="kt-widget16__chart">
										<div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
										<div class="kt-widget16__stat"><?php echo e($total_month_order); ?></div>
										<canvas id="kt_chart_support_requests_1" style="height: 140px; width: 140px; display: block;" width="140" height="140" class="chartjs-render-monitor"></canvas>
									</div>
								</div>
								<div class="kt-widget16__legends">
									<div class="kt-widget16__legend">
										<span class="kt-widget16__bullet" style="background-color: #FFA07A;"></span>
										<span class="kt-widget16__stat"><?php echo e($month_order_cod); ?> COD</span>
									</div>
									<div class="kt-widget16__legend">
										<span class="kt-widget16__bullet" style="background-color: #FFC0CB; !important"></span>
										<span class="kt-widget16__stat"><?php echo e($month_order_online); ?> Prepaid</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> -->
	<?php endif; ?>
</div> 

<?php 
	$customers = App\User::where('status',1)->get();
	$sources = App\Models\Discount::where('status',1)->get();
?>

<div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				 <form class="kt-form kt-form--label-right add_form" method="post" >
                    <?php echo csrf_field(); ?>
					<div class="form-group row">
						<div class="col-lg-6">
							<label for="recipient-name" class="form-control-label">Select Customer:</label>
							<select class="form-control" name="customer_id">
								<option>--select customer--</option>
								<?php if(!empty($customers)): ?>
									<?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($customer->id); ?>"><?php echo e($customer->fname); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php else: ?>
									<option value="">No customer found</option>
								<?php endif; ?>
							</select>
						</div>
						<div class="col-lg-6">
							<label for="recipient-name" class="form-control-label">Select Source:</label>
							<select class="form-control" name="source_id">
								<option>--select source--</option>
								<?php if(!empty($sources)): ?>
									<?php $__currentLoopData = $sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($source->id); ?>"><?php echo e($source->source_name); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php else: ?>
									<option value="">No source found</option>
								<?php endif; ?>
							</select>
						</div>
						
					</div>
					<div class="form-group row">
						<div class="col-lg-6">
							<label for="recipient-name" class="form-control-label">Amount:</label>
							<input type="text" class="form-control" name="price" onkeyup="if(/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
						</div>




						
					</div>
					<div class="form-group">
						<label for="message-text" class="form-control-label">Remark:</label>
						<textarea class="form-control" id="message-text"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary submit change_button">Add Order<i class="la la-spinner change_spin d-none"></i></button>
				<!-- <button type="submit" class="btn btn-primary">Add Order</button> -->
			</div>
		</div>
	</div>
</div>
<script src="<?php echo e(asset('assets/js/pages/dashboard.js')); ?>" type="text/javascript"></script>
<script>

	$(document).ready(function() {

        $(".submit").on("click", function(e) {
            
            e.preventDefault();

            if ($(".add_form").valid()) {
                
                $('.change_button').find('.change_spin').removeClass('d-none');
                $('.change_button').prop('disabled', true);

                $.ajax({

                    type: "POST",

                    url: "<?php echo e(route('admin.order.add')); ?>",

                    data: new FormData($('.add_form')[0]),

                    processData: false,

                    contentType: false,

                    success: function(data) {

                        if (data.status === 'success') {
                            
                            window.location.reload();

                            toastr["success"]("Order Added Successfully", "Success");

                            

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

	namename();
	namename1();
	function namename() {
		var container = KTUtil.getByID('kt_chart_support_requests');

		if (!container) {
			return;
		}

		var randomScalingFactor = function() {
			return Math.round(Math.random() * 100);
		};

		var config = {
			type: 'doughnut',
			data: {
				datasets: [{
					data: [
					<?php echo e($count_cod_order); ?>,<?php echo e($count_online_order); ?>

					],
					backgroundColor: [
					'#FFA07A',
					'#FFC0CB'
					]
				}],
				labels: [
				'COD',
				'Prepaid'
				]
			},
			options: {
				cutoutPercentage: 75,
				responsive: true,
				maintainAspectRatio: false,
				legend: {
					display: false,
					position: 'top',
				},
				title: {
					display: false,
					text: 'Technology'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				},
				tooltips: {
					enabled: true,
					intersect: false,
					mode: 'nearest',
					bodySpacing: 5,
					yPadding: 10,
					xPadding: 10, 
					caretPadding: 0,
					displayColors: false,
					backgroundColor: '#000000',
					titleFontColor: '#ffffff', 
					cornerRadius: 4,
					footerSpacing: 0,
					titleSpacing: 0
				}
			}
		};

		var ctx = container.getContext('2d');
		var myDoughnut = new Chart(ctx, config);
	}
	function namename1() {
		var container = KTUtil.getByID('kt_chart_support_requests_1');

		if (!container) {
			return;
		}

		var randomScalingFactor = function() {
			return Math.round(Math.random() * 100);
		};

		var config = {
			type: 'doughnut',
			data: {
				datasets: [{
					data: [
					<?php echo e($month_order_cod); ?>,<?php echo e($month_order_online); ?>

					],
					backgroundColor: [
					'#FFA07A',
					'#FFC0CB'
					]
				}],
				labels: [
				'COD',
				'Prepaid'
				]
			},
			options: {
				cutoutPercentage: 75,
				responsive: true,
				maintainAspectRatio: false,
				legend: {
					display: false,
					position: 'top',
				},
				title: {
					display: false,
					text: 'Technology'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				},
				tooltips: {
					enabled: true,
					intersect: false,
					mode: 'nearest',
					bodySpacing: 5,
					yPadding: 10,
					xPadding: 10, 
					caretPadding: 0,
					displayColors: false,
					backgroundColor: '#000000',
					titleFontColor: '#ffffff', 
					cornerRadius: 4,
					footerSpacing: 0,
					titleSpacing: 0
				}
			}
		};

		var ctx = container.getContext('2d');
		var myDoughnut = new Chart(ctx, config);
	}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\rohit\buzzed\buzzed\resources\views/admin/home.blade.php ENDPATH**/ ?>