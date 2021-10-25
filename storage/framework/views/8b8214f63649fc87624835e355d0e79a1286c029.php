<?php $__env->startSection('content'); ?>

<link href="<?php echo e(asset('assets/plugins/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<br>
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
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
					<table class="table table-striped- table-bordered table-hover table-checkable datatable" id="datatable_rows">
						<?php echo csrf_field(); ?>
						<thead>
							<tr>
								<th>Order Number</th>
								<!-- <th>Seller Name</th> -->
								<th>Customer Name</th>								
								<th>Amount</th>
								<th>Credit </th>
								<th>Date</th>
								<!-- <th>Order Status</th> -->
                                <th>Action</th>
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

<?php
if($status_id != '')  {
    $datatable_url = route('admin.order.status.index', $status_id);
} else {
    $datatable_url = route('admin.order.index');
}
?>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script src="<?php echo e(asset('assets/plugins/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
<script>
	$(document).ready(function() {
		$('#datatable_rows').DataTable({
			processing: true,
			serverSide: true,
			searchable: true,
			columnDefs: [{
				orderable: false,
				targets: -1,
			}],
			ajax: "<?php echo e($datatable_url); ?>",
			columns: [
				{
					orderable: false,
                    searchable: true,
					data: 'order_uniqueid',
				},
				// {
				// 	"data": "seller_name"
				// },
				{
					"data": "customer_name"
				},
				{
					"data": "price"
				},

				{

					"data": "discount"
				},
				{
					"data": "order_date"
				},
    //             {
    //                 orderable: false,
    //                 searchable: false,
				// 	"data": "order_status"
				// },
                {
                    orderable: false,
                    searchable: false,
					"data": "action"
				},
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
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\rohit\buzzed\buzzed\resources\views/adminseller/order/index.blade.php ENDPATH**/ ?>