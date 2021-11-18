@extends('admin.main')

@section('content')
<style>

	@media print {
		#kt-timeline-v2 {
			display: none;
		}
		.noprint {
			/*visibility: hidden; */
			display: none !important;
		}

		.yesprint {
			/*display: block !important;*/
		}
		#printButton {
			display: none;
		}

		#kt_footer {
			display: none !important;
		}

		#kt_scrolltop {
			display: none !important;
		}

		#kt_header {
			display: none !important;
		}
	}
</style>
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
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
						Order Detail
					</h3>
				</div>

				<div class="kt-portlet__head-toolbar noprint">

					<div class="kt-portlet__head-wrapper">
						<!-- <div class="kt-portlet__head-actions">
							<a href="{{route('admin.order.print',$order_header->id)}}" class="btn btn-brand btn-elevate btn-icon-sm">Invoice</a>
						</div> -->
					</div>&nbsp;&nbsp;&nbsp;
					<div class="kt-portlet__head-wrapper">

						<div class="kt-portlet__head-actions">

							<a href="{{route('admin.order.index')}}" class="btn btn-brand btn-elevate btn-icon-sm" id="printPageButton1">Back</a>

						</div>

					</div>
				</div>
			</div>

			<div class="kt-portlet__body">
				<div class="row">
					<!-- <div class="col-lg-12">
						<h3><b>Order Type:</b> 
							@if($order_header === 'online')
							Prepaid
							@else
							COD
							@endif
						</h3>
					</div> -->
				</div>
				<br>
				<div class="row" style="margin:0 0px 0px 200px">

					<div class="col-lg-3 col-md-3 col-3">
					</div>
				
					<div class="col-lg-3  col-md-3 col-3">
					</div>


					 
				<!-- <div class="col-lg-4">
					<div class="kt-timeline-v2" id="kt-timeline-v2">
						<div class="kt-timeline-v2__items  kt-padding-top-25 kt-padding-bottom-30">
								@php
									$oh_Status = array_column($order_header->order_statuses->toArray(), 'pivot');
									$oh_status_array = [];
									foreach($oh_Status as $s) {
										$oh_status_array[$s['order_status_id']] = $s;
									}
								@endphp
							@foreach($order_status as $status)
								@php
									$circle_class= '';
									if($status['id'] <= $order_header['order_status_id']) {
										$circle_class= 'kt-font-success';
									}
								@endphp
							<div class="kt-timeline-v2__item">
								
								<div class="kt-timeline-v2__item-cricle">
									<i class="fa fa-genderless {{$circle_class}}"></i>
								</div>
								<div class="kt-timeline-v2__item-text  kt-padding-top-5">
								<span class="kt-timeline-v2__item-time">
									{{ $status['name'] }}
								</span>
								<br/>	
								@if(isset($oh_status_array[$status['id']]))
										{{ $status['description'] }}
											<br/>
										{{ \Carbon\Carbon::parse($oh_status_array[$status['id']]['created_at'])->format('d-m-Y g:i A') }}
									@endif
								</div>
							</div>
							@endforeach
							
							<div class="kt-timeline-v2__item">
								<span class="kt-timeline-v2__item-time">12:45</span>
								<div class="kt-timeline-v2__item-cricle">
									<i class="fa fa-genderless kt-font-success"></i>
								</div>
								<div class="kt-timeline-v2_item-text kt-timeline-v2_item-text--bold">
									AEOL Meeting With
								</div>
								<div class="kt-list-pics kt-list-pics--sm kt-padding-l-20">
									<a href="#"><img src="assets/media/users/100_4.jpg" title=""></a>
									<a href="#"><img src="assets/media/users/100_13.jpg" title=""></a>
									<a href="#"><img src="assets/media/users/100_11.jpg" title=""></a>
									<a href="#"><img src="assets/media/users/100_14.jpg" title=""></a>
								</div>
							</div>
							<div class="kt-timeline-v2__item">
								<span class="kt-timeline-v2__item-time">14:00</span>
								<div class="kt-timeline-v2__item-cricle">
									<i class="fa fa-genderless kt-font-brand"></i>
								</div>
								<div class="kt-timeline-v2__item-text kt-padding-top-5">
									Make Deposit <a href="#" class="kt-link kt-link--brand kt-font-bolder">USD 700</a> To ESL.
								</div>
							</div>
							<div class="kt-timeline-v2__item">
								<span class="kt-timeline-v2__item-time">16:00</span>
								<div class="kt-timeline-v2__item-cricle">
									<i class="fa fa-genderless kt-font-warning"></i>
								</div>
								<div class="kt-timeline-v2__item-text kt-padding-top-5">
									Lorem ipsum dolor sit amit,consectetur eiusmdd tempor<br>
									incididunt ut labore et dolore magna elit enim at minim<br>
									veniam quis nostrud
								</div>
							</div>
							<div class="kt-timeline-v2__item">
								<span class="kt-timeline-v2__item-time">17:00</span>
								<div class="kt-timeline-v2__item-cricle">
									<i class="fa fa-genderless kt-font-info"></i>
								</div>
								<div class="kt-timeline-v2__item-text kt-padding-top-5">
									Placed a new order in <a href="#" class="kt-link kt-link--brand kt-font-bolder">SIGNATURE MOBILE</a> marketplace.
								</div>
							</div>
							<div class="kt-timeline-v2__item">
								<span class="kt-timeline-v2__item-time">16:00</span>
								<div class="kt-timeline-v2__item-cricle">
									<i class="fa fa-genderless kt-font-brand"></i>
								</div>
								<div class="kt-timeline-v2__item-text kt-padding-top-5">
									Lorem ipsum dolor sit amit,consectetur eiusmdd tempor<br>
									incididunt ut labore et dolore magna elit enim at minim<br>
									veniam quis nostrud
								</div>
							</div>
							<div class="kt-timeline-v2__item">
								<span class="kt-timeline-v2__item-time">17:00</span>
								<div class="kt-timeline-v2__item-cricle">
									<i class="fa fa-genderless kt-font-danger"></i>
								</div>
								<div class="kt-timeline-v2__item-text kt-padding-top-5">
									Received a new feedback on <a href="#" class="kt-link kt-link--brand kt-font-bolder">FinancePro App</a> product.
								</div>
							</div>
						</div>
					</div>
				</div> -->
				
				<!-- <div class="col-lg-6">
					<label><b>Shipping Address</b></label><br>
					<a>
                        Adhik Bachat Mart,<br/>
                        Rajkot, 3025698<br/> 
                        Gujarat,<br/> 
                        India,<br/> 
                        Mo no: 9999999999,<br/> 
                       Email Id : admart@gmail.com,<br/> 
                            
						{{ $order_header->shipping_fullname }}<br>
						{{ $address }}<br>
						{{ $order_header->shipping_city_name }}<br>
						{{ $order_header->shipping_state_name }}<br>
						{{ $order_header->shipping_country_name}}&nbsp;&nbsp;&nbsp;{{ $order_header->shipping_pincode }}<br>
						{{ $order_header->shipping_mobile }}<br>
						{{ $order_header->customers->email }}<br>
						@if(isset($order_header->gst_no))GST: {{ $order_header->gst_no }}<br>@endif
					</a>
				</div>
				<div class="col-lg-6">
					<label><b>Billing Address</b></label><br>
					<a>
						{{ $order_header->billing_fullname }}<br>
						{{ $address }}<br>
						{{ $order_header->billing_city_name }}<br>
						{{ $order_header->billing_state_name }}<br>
						{{ $order_header->billing_country_name}}&nbsp;&nbsp;&nbsp;{{ $order_header->billing_pincode }}<br>
						{{ $order_header->billing_mobile }}<br>
						{{ $order_header->customers->email }}<br>
						@if(isset($order_header->gst_no))GST: {{ $order_header->gst_no }}<br>@endif
					</a>
				</div> -->
			</div>
				<!-- <div class="row" style="margin-top: 70px;" >
					<br>
					<br><br>
					<br>
					<div class="col-lg-12">
						<p>Dear {{App\User::where('id',$order_header->customer_id)->value('fname')}} {{App\User::where('id',$order_header->customer_id)->value('lname')}}. Thank you for ordering from Myhomefood.
						</p>
						<p>	We would like to gift you with a voucher of ({{$order_header->discount_price}} credit amount)  in return.
						</p>
						<p>You can utilise this amount when you dine at any of our Partner outlets once they open after the lockdown.
						</p>
						<p>Date :{{\Carbon\Carbon::parse($order_header->created_at)->format('d-m-Y')}}</p>
					</div>
				</div> -->
				


			<div id="kt_table_1_wrapper" class="dt-bootstrap4 col-6">
				<table class="table table-hover">
					@csrf
					<tbody>
						<tr>
							<td>Order No</td>
							<td>{{ $order_header->order_uniqueid }}</td>
						</tr>

						<tr>
							<td>Date</td>
							<td>{{\Carbon\Carbon::parse($order_header->created_at)->format('d-m-Y')}}</td>
						</tr>

						<tr>
							<td>Outlet</td>
							<td>{{ $outlet_name }}</td>
						</tr>

						<tr>
							<td>Steward</td>
							<td>{{ App\Models\Captain::where('id',$order_header->captain_id)->value('name') }}</td>
						</tr>

						<tr>
							<td>Payment Type</td>
							<td>{{ $order_header->payment_type }}</td>
						</tr>

						<tr>
							<td>Amount</td>
							<td>{{ $order_header->price }}</td>
						</tr>

						<tr>
							<td>Discount Amount</td>
							<td>{{ $order_header->discount_price }}</td>
						</tr>

						<tr>
							<td>Payable Amount</td>
							<td>{{ $order_header->total_price }}</td>
						</tr>

						<tr>
							<td colspan="2">
							<div class="row noprint">

								<div class="col-sm-12 col-md-12 col-lg-12">
									<br>
									<br>
									<button type="button" class="btn btn-dark btn-default btn btn-flat print noprint"
											style="margin-left: 20px;"><span class="fa fa-print"></span> Print
									</button>
								</div>
							</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
<script>
	$(document).ready(function() {
		$(document).on('click', '.print', function () {
			$('.yesprint').removeAttr('style');
			$('#kt_footer').css('display','none');
			$('#kt_header').css('display','none');
			window.print();
		});
		$(document).on('click', '#accept', function ()
		{
			var obj = $(this);
			var id=$(this).closest('td').find(".line_id").val();
			
			$.ajax(
			{
				type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: "{{route('admin.order.accept')}}",
				data: {
					'_token': $('input[name="_token"]').val(),
					// 'cancel_note': cancel_note,
					'id': id,
				},
				// cache: false,
				// processData: false,
                // contentType: false,
                success: function (data)
                {
                	location.reload();

                }
            });
		});
		$(document).on('click', '#reject', function ()
		{
			var obj = $(this);
			var id=$(this).closest('td').find(".line_id").val();
			
			$.ajax(
			{
				type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: "{{route('admin.order.reject')}}",
				data: {
					'_token': $('input[name="_token"]').val(),
					// 'cancel_note': cancel_note,
					'id': id,
				},
				// cache: false,
				// processData: false,
                // contentType: false,
                success: function (data)
                {
                	location.reload();

                }
            });
		});

	});
</script>


@stop
