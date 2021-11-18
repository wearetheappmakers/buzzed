<?php $__env->startSection('content'); ?>

<link href="<?php echo e(asset('assets/plugins/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<br>

	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

		<div class="row">
			<div class="col-lg-3">
			<div class="kt-portlet kt-iconbox kt-iconbox--success kt-iconbox--animate-slow">
				<div class="kt-portlet__body">
					<div class="kt-iconbox__body">
						<div class="kt-iconbox__icon">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<rect x="0" y="0" width="24" height="24"></rect>
									<path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"></path>
									<path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000"></path>
									<path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"></path>
								</g>
							</svg> </div>
						<div class="kt-iconbox__desc">
							<h3 class="kt-iconbox__title">
								<a class="kt-link" href="#"><span id="savedBanalce"></span></a>
							</h3>
							<div class="kt-iconbox__content">
								Total amount saved
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-3">
									<div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
										<div class="kt-portlet__body">
											<div class="kt-iconbox__body">
												<div class="kt-iconbox__icon">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"></rect>
															<path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3"></path>
															<path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000"></path>
														</g>
													</svg> </div>
												<div class="kt-iconbox__desc">
													<h3 class="kt-iconbox__title">
														<a class="kt-link" href="#"><span id="ExpiryDate"></span></a>
													</h3>
													<div class="kt-iconbox__content">
														Membership Validity Date
													</div>
												</div>
											</div>
										</div>
									</div>
		</div>
		</div>
		

		<div class="kt-portlet kt-portlet--mobile">
			<div class="kt-portlet__head kt-portlet__head--lg">
				<div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon">
						<i class="kt-font-brand flaticon2-line-chart"></i>
					</span>
					<h3 class="kt-portlet__head-title">
						All Order List
					</h3>
				</div>
			</div>

			<div class="kt-portlet__body">
				<div id="kt_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4">
					<table class="table table-striped- table-bordered table-hover table-checkable datatable responsive" id="datatable_rows">
						<?php echo csrf_field(); ?>
						<thead>
							<tr>
								<th>Date</th>
								<th>Order Number</th>
								<th>Outlet</th>
								<th>Steward</th>								
								<th>Payment Type</th>
								<th>Amount</th>
								<th>Discount</th>
								<th>Final Bill</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>

			<?php echo $__env->make('admin.layout.multiple_action', array(
			'table_name' => 'option_values',
			'is_orderby'=>'yes',
			'folder_name'=>'',
			'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))
			), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
	</div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script src="<?php echo e(asset('assets/plugins/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
<script>
	$(document).ready(function() {

		getSavedBalance();

		$('#datatable_rows').DataTable({
			processing: true,
			serverSide: true,
			searchable: true,
			columnDefs: [{
				orderable: false,
				targets: -1,
			}],
			ajax: "<?php echo e(route('customer.order.index')); ?>",
			columns: [
				{
					"data": "order_date"
				},
				{
					orderable: false,
                    searchable: true,
					data: 'order_uniqueid',
				},
				{

					"data": "outlet"
				},
				{

					"data": "captain"
				},{

					"data": "payment_type"
				},{

					"data": "price"
				},{

					"data": "discount_price"
				},
				{
					"data": "total_price"
				},

				
    //             {
    //                 orderable: false,
    //                 searchable: false,
				// 	"data": "order_status"
				// },
    //             {
    //                 orderable: false,
    //                 searchable: false,
				// 	"data": "action"
				// },
			]
		});

        $(document).on('change', '.order_status_change', function(e){
            e.preventDefault();
            var order_header_id = $(this).data('header_id');
            var status_id = $(this).val();            
            $.ajax({
                type: "GET",
                url: "<?php echo e(route('admin.order.changeOrderStatus')); ?>",
                data: {
					'order_header_id' : order_header_id,
                    'status_id': status_id, 
				},
				dataType: 'json',
                success: function(data) {
                    toastr["success"](data.message, "Success");
                },
                error :function( data ) {
                    var errors = $.parseJSON(data.responseText);
                    toastr["error"](errors.message, "Error");
                }
            });
            return false;
        });
	});

	function getSavedBalance(){
		$.ajax({
                type: "GET",
                url: "<?php echo e(route('get.saved.balance')); ?>",
				dataType: 'json',
                success: function(data) {
                	$('#savedBanalce').text('₹ '+data.saved_balance);
                	$('#ExpiryDate').text('Dt. '+moment(data.user.validity_date).format('D-M-Y'));
                	// $('#savedBanalce').val(data.saved_balance);
                    // toastr["success"](data.message, "Success");
                },
                error :function( data ) {
                    // var errors = $.parseJSON(data.responseText);
                    // toastr["error"](errors.message, "Error");
                }
            });
	}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\rohit\buzzed\buzzed\resources\views/customer/billhistory.blade.php ENDPATH**/ ?>