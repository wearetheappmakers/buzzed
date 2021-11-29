<?php $__env->startSection('content'); ?>

<style type="text/css">
	.mandatory{
		color: red;
	}
</style>

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

	<br>

	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="row">
			<div class="col-lg-2" style="cursor: pointer;" data-toggle="modal" data-target="#kt_modal_4">
				<div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-fast">
					<div class="kt-portlet__body">
						<div class="kt-iconbox__body">
							
							<div class="kt-iconbox__desc">
								<h3 class="kt-iconbox__title">
									<a class="kt-link" href="#">Add Bill</a>
								</h3>
								
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<?php 
	$customers = App\User::where('status',1)->get();
	$captains = App\Models\Captain::where('status',1)->get();
	$sources = App\Models\Discount::where('status',1)->get();
	$sources1 = App\Models\Discount::select('discount_per')->where([['status',1],['id',2]])->first();
	$sources2 = App\Models\Discount::select('discount_per')->where([['status',1],['id',3]])->first();
?>

<div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Bill</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"  onclick="return window.location.reload();">
				</button>
			</div>
			<div class="modal-body">
				 <form class="kt-form kt-form--label-right add_form" method="post" >
                    <?php echo csrf_field(); ?>

                    <div class="form-group row">
						<?php if(Auth::guard('waiter')->check()): ?>
							<input type="hidden" name="captain_id" value="<?php echo e(Auth::guard('waiter')->user()->id); ?>" required="">
						<?php endif; ?>
						
                    	<div class="col-lg-6">
							<label for="recipient-name" class="form-control-label">Total Amount:<span class="mandatory">*</span></label>
							<input type="text" class="form-control total_amount" name="price" id="price" required="" onkeyup="if(/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
						</div>
                    </div>
					<div class="form-group row">
						<div class="col-lg-6">
							<label for="recipient-name" class="form-control-label">Select Customer:<span class="mandatory">*</span></label>
							<select class="form-control kt-selectpicker customer" data-live-search="true" name="customer_id" required="">
								<option value="" disabled="">--select customer--</option>
								<?php if(!empty($customers)): ?>
									<?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($customer->id); ?>"><?php echo e($customer->number); ?> ( <?php echo e($customer->fname); ?> )</option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php else: ?>
									<option value="">No customer found</option>
								<?php endif; ?>
							</select>
						</div>
						<div class="col-lg-6">
							<label for="recipient-name" class="form-control-label">Discount On:<span class="mandatory">*</span></label>
							<input type="hidden" name="discount_per" id="discount_per_hid">
							<select class="form-control" id="discount_per" required="" disabled>
								<option value="">--discount--</option>
								<?php if(!empty($sources)): ?>
									<?php $__currentLoopData = $sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($source->id); ?>"><?php echo e($source->source_name); ?> ( <?php echo e($source->discount_per); ?> %)</option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php else: ?>
									<option value="">No source found</option>
								<?php endif; ?>
							</select>
						</div>
						
					</div>
					<div class="form-group row">
						<div class="col-lg-6">
							<label for="recipient-name" class="form-control-label">Payable Amount:<span class="mandatory">*</span></label>
							<input type="text" class="form-control" name="total_price" id="total_price" readonly="" onkeyup="if(/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required="">
						</div>
						<div class="col-lg-6">
							<label for="recipient-name" class="form-control-label">Discount Amount:<span class="mandatory">*</span></label>
							<input type="text" class="form-control" name="discount_price" id="discount_price" readonly="">
						</div>
						
					</div>
					<div class="form-group row">
						<div class="col-lg-6">
							<label for="recipient-name" class="form-control-label">Payment Type:<span class="mandatory">*</span></label>
							<select class="form-control payment_type" data-live-search="true" name="payment_type" required="">
								<option value="">--select payment type--</option>
								<option value="Cash">Cash</option>
								<option value="Card">Card</option>
								<option value="UPI">UPI</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="message-text" class="form-control-label">Remark:</label>
						<textarea class="form-control" id="message-text"></textarea>
					</div>
					<span class="mandatory note">Note : Add button only enable when you fill all mandatory field</span>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="return window.location.reload();">Close</button>
				<button type="button" class="btn btn-primary submit change_button" disabled>Add<i class="la la-spinner change_spin d-none"></i></button>
				<!-- <button type="submit" class="btn btn-primary">Add Order</button> -->
			</div>
		</div>
	</div>
</div>
<script>

	var customers = <?php echo json_encode($customers); ?>;
	var sources1 = <?php echo json_encode($sources1); ?>;
	var sources2 = <?php echo json_encode($sources2); ?>;
	var now = moment().format('MM-DD');


	$(document).ready(function() {

		$('.kt-selectpicker').selectpicker('val', '');

        $(".submit").on("click", function(e) {
            
            e.preventDefault();

            if ($(".add_form").valid()) {
                
                $('.change_button').find('.change_spin').removeClass('d-none');
                $('.change_button').prop('disabled', true);

                $.ajax({

                    type: "POST",

                    url: "<?php echo e(route('waiter.order.add')); ?>",

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

        $(".total_amount").on("keyup", function(e) {
        	Customer();
        	CheckField();
        });

        $(".captain").on("change", function(e) {
        	CheckField();
        });

        $(".payment_type").on("change", function(e) {
        	CheckField();
        });

        $(".customer").on("change", function(e) {
        	// $('#source_id').val();
        	e.stopImmediatePropagation()
        	var id = $(this).val();
        	if (id == '') {
        		$('#discount_per').val('');
        		$('#discount_per_hid').val('');
        		return;
        	}
        	console.log($('[name=customer_id]').val().length);
        	Customer();
        });

    });

	function GetAmount($total_price,$discount){
		
		var discount_price = ((Number($total_price) * Number($discount))/100);
		var total_price = (Number($total_price) - Number(discount_price)).toFixed(2);
		$('#total_price').val(total_price);
		$('#discount_price').val(discount_price);
		$('#total_price').css({'backgroundColor':'#D8D8D8'});
		$('#discount_price').css({'backgroundColor':'#D8D8D8'});
	}

	function Customer(){
		$.each(customers,function(key,value){
    		if (value.id == $('[name=customer_id]').val()) {
        		var date = moment(value.b_date).format('MM-DD');
	        		if (date == now) {
	        			GetAmount($('#price').val(),sources2.discount_per);
	        			$('#discount_per').val(3);
	        			$('#discount_per_hid').val(sources2.discount_per);
	        		}else{
	        			GetAmount($('#price').val(),sources1.discount_per);
	        			$('#discount_per').val(2);
	        			$('#discount_per_hid').val(sources1.discount_per);
	        		}
    		}
    	});
    	CheckField();
	}

	function EnableSubmit(){
		$('.submit').prop('disabled',false);
		$('.note').hide();
	}

	function CheckField(){
		
		if ($('[name=captain_id]').val().length > 0 
			&& $('.total_amount').val().length > 0
			&& $('[name=customer_id]').val().length > 0
			&& $('[name=discount_per]').val().length > 0
			&& $('#total_price').val().length > 0
			&& $('#discount_price').val().length > 0
			&& $('[name=payment_type]').val().length > 0

			) {
			EnableSubmit();
		}else{
			$('.submit').prop('disabled',true);
			$('.note').show();
		}
	}
	
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\rohit\buzzed\buzzed\resources\views/waiter/home.blade.php ENDPATH**/ ?>