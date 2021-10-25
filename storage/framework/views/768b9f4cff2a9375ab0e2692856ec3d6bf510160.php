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

						Discount Master

					</h3>

				</div>

				<div class="kt-portlet__head-toolbar">

					<div class="kt-portlet__head-wrapper">

						<div class="kt-portlet__head-actions">

							<a href="<?php echo e(route('admin.discount.create')); ?>" class="btn btn-brand btn-elevate btn-icon-sm">

								<i class="la la-plus"></i>

								Add Discount Master

							</a>

						</div>

					</div>

				</div>

			</div>

			<div class="kt-portlet__body">

				<div id="kt_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4">

					<table class="table table-striped- table-bordered table-hover table-checkable datatable" id="datatable_rows">

						<?php echo csrf_field(); ?>

						<thead>

							<tr>

								<th>#</th>
								<!-- <th><input type="checkbox" id="selectall" /></th> -->

								<th>Source Name</th>

								<th>Discount Percentage</th>

                                <th>Status</th>

								<th>Action</th>
							</tr>

						</thead>

						<tbody>

						</tbody>

					</table>

				</div>

			</div>



			<?php echo $__env->make('admin.layout.multiple_action', array(

			'table_name' => 'discounts',

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



		$('#datatable_rows').DataTable({

			processing: true,

			serverSide: true,

			// searchable: false,

			columnDefs: [{

				orderable: false,

				targets: -1,

			}],

			ajax: "<?php echo e(route('admin.discount.index')); ?>",

			columns: [{

					orderable: false,

					searchable: false,

					data: 'id',

				},

				{

					"data": "source_name"

				},{

					"data": "discount_per"

				},

				{

					orderable: false,

					searchable: false,

					data: 'singlecheckbox',

				},

				{
					orderable: false,
					searchable: false,
					data: 'action',

				},
			]

		});
	});
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\rohit\buzzed\buzzed\resources\views/adminseller/discount/index.blade.php ENDPATH**/ ?>