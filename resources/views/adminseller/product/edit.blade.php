@extends('admin.main')
@section('content')

@php

$title = $data['title'];

$module = $data['module'];

$resourcePath = $data['resourcePath'];

$url = $data['url'];

$id = $data['edit']->id;

$vendors = $data['vendors'];
$brands = $data['brands'];

@endphp
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<br>
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="kt-portlet">
					<div class="kt-portlet__head">
						<div class="kt-portlet__head-label">
							<h3 class="kt-portlet__head-title">
								{{ $title }}
							</h3>
						</div>
                        <div class="kt-portlet__head-toolbar">

                        <div class="kt-portlet__head-wrapper">

                            <div class="kt-portlet__head-actions">
                                @if(Auth::guard('vendor')->check())
                                    <a href="{{ route('vendor.product') }}" class="btn btn-secondary btn-icon-sm">
                                @else
                                    <a href="{{ route('admin.product.index') }}" class="btn btn-secondary btn-icon-sm">
                                @endif
                                    <i class="la la-angle-left"></i>

                                    Back

                                </a>

                            </div>

                        </div>

                    </div>
					</div>
					@php
					$edit = $data['edit'];
					@endphp    
					<div class="kt-portlet__body">
						<div class="form-group row">
							<ul class="nav nav-pills nav-fill" role="tablist">
                                @if(Auth::guard('admin')->check())
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#kt_tabs_5_1">General</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#kt_tabs_category">Category</a>
								</li>
								@if($edit->product_type == 4) 
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#kt_tabs_size">Size</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#kt_tabs_color">Color</a>
								</li>
								@elseif($edit->product_type == 3)
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#kt_tabs_color">Color</a>
								</li>
								@elseif($edit->product_type == 2)
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#kt_tabs_size">Size</a>
								</li>
								@endif
								<!-- <li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#kt_tabs_sizechart">Size Chart</a>
								</li> -->
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#kt_tabs_image">Image</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#kt_tabs_option">Option</a>
								</li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#kt_tabs_tag" class="kt_tabs_tag" id="kt_tabs_tag_tab">Tag</a>
                                </li>
                                @endif
								@if($edit->is_lotwise_display == 0)
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" id="kt_tabs_inventory_tab" class="kt_tabs_inventory" href="#kt_tabs_inventory">Inventory</a>
								</li>
								@elseif($edit->is_lotwise_display == 1)
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab"  id="kt_tabs_lot_inventory_tab"  href="#kt_tabs_lot">Lot</a>
								</li>
								@endif
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab"  id="kt_tabs_price_tab"  href="#kt_tabs_price">Price</a>
								</li>
								<!-- <li class="nav-item">
									<a class="nav-link" data-toggle="tab"  id="kt_tabs_discount_tab"  href="#kt_tabs_discount">Discount</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#kt_tabs_title1" class="kt_tabs_title1" id="kt_tabs_title1_tab">Title 1</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab"  href="#kt_tabs_title2" class="kt_tabs_title2" id="kt_tabs_title2_tab">Title 2</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#kt_tabs_title3" class="kt_tabs_title3" id="kt_tabs_title3_tab">Title 3</a>
								</li> -->
							</ul> 
						</div>
						<div class="tab-content">
                            @if(Auth::guard('admin')->check())
							<div class="tab-pane active" id="kt_tabs_5_1" role="tabpanel">
								@include('adminseller.product.general', array('product'=> $edit,'vendors'=>$vendors,'brands' => $brands ))
							</div>
							<div class="tab-pane" id="kt_tabs_category" role="tabpanel">
								@include('adminseller.product.category_tab', array('product'=> $edit, 'categories'=> $data['categories']))
							</div>
							@if($edit->product_type == 4) 
							<div class="tab-pane" id="kt_tabs_size" role="tabpanel">
								@include('adminseller.product.size_tab', array('product'=> $edit, 'sizes'=> $data['sizes']))
							</div>
							<div class="tab-pane" id="kt_tabs_color" role="tabpanel">
								@include('adminseller.product.color_tab', array('product'=> $edit, 'colors'=> $data['colors']))
							</div>
							@elseif($edit->product_type == 3)
							<div class="tab-pane" id="kt_tabs_color" role="tabpanel">
								@include('adminseller.product.color_tab', array('product'=> $edit, 'colors'=> $data['colors']))
							</div>
							@elseif($edit->product_type == 2)
							<div class="tab-pane" id="kt_tabs_size" role="tabpanel">
								@include('adminseller.product.size_tab', array('product'=> $edit, 'sizes'=> $data['sizes']))
							</div>
							@endif
							<div class="tab-pane" id="kt_tabs_sizechart" role="tabpanel">
								@include('adminseller.product.sizechart_tab', array('product'=> $edit, 'sizechart'=> $data['sizechart']))
							</div>
							<div class="tab-pane" id="kt_tabs_image" role="tabpanel">
								@include('adminseller.product.image_tab', array('product'=> $edit))
							</div>
							<div class="tab-pane" id="kt_tabs_option" role="tabpanel">
								@include('adminseller.product.option_tab', array('product' => $edit, 'options' => $data['options']))
							</div>
                            @endif
							@if($edit->is_lotwise_display == 0)
							<div class="tab-pane" id="kt_tabs_inventory" role="tabpanel">
								{{-- @include('adminseller.product.inventory_tab', array('product'=> $edit)) --}}
							</div>
							@elseif($edit->is_lotwise_display == 1)
							<div class="tab-pane" id="kt_tabs_lot" role="tabpanel">
								{{-- @include('adminseller.product.lot_tab', array('product' => $edit)) --}}
							</div>
							@endif
							<div class="tab-pane" id="kt_tabs_price" role="tabpanel">
							</div>
							<div class="tab-pane" id="kt_tabs_discount" role="tabpanel">
							</div>
							<div class="tab-pane" id="kt_tabs_title1" role="tabpanel">
							</div>
							<div class="tab-pane" id="kt_tabs_title2" role="tabpanel">
							</div>
							<div class="tab-pane" id="kt_tabs_title3" role="tabpanel">
							</div>
                            <div class="tab-pane" id="kt_tabs_tag" role="tabpanel">
                            </div>
						</div>
					</div>
				
				</div>
		

			</div>
		</div>
	</div>
</div>
@if(Auth::guard('vendor')->check())
    @php
        $user = 'vendor';
        $url = route('vendor.product'); 
        $price_update = route('vendor.product.price_update'); 
        $inventory_update = route('vendor.product.inventory_update'); 
    @endphp
@else
    @php 
        $user = 'admin'; 
        $url = route('admin.product.index'); 
        $price_update = route('admin.product.price_update'); 
        $inventory_update = route('admin.product.inventory_update'); 
    @endphp
@endif

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
    	$(document).on("click", "#kt_tabs_title1_tab", function(e) {
			
            e.preventDefault();
            $.ajax({
                type: "Get",
                url: "{{ route('admin.product.title1') }}",
                data: {
					'product_id' : "{{$edit->id}}"
				},
				dataType: 'html',
                success: function(data) {
                     $('#kt_tabs_title1').html(data);
                }
            });
            return false;
		});

        setTimeout(function(){ 
            if ('{{ $user }}' == 'vendor') {
                $( "#kt_tabs_inventory_tab" ).trigger( "click" );
            }
        },
        1000);
        

    	$(document).on("submit", "#general-form-title1", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product.title1') }}",
                data: new FormData($('#general-form-title1')[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status === 'success') {
                        toastr["success"]("{{ $module }} Update Successfully", "Success");
                        // location.reload();
                    } else if (data.status === 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                }
            });
            return false;
        });
        $(document).on("click", "#kt_tabs_title2_tab", function(e) {
			
            e.preventDefault();
            $.ajax({
                type: "Get",
                url: "{{ route('admin.product.title2') }}",
                data: {
					'product_id' : "{{$edit->id}}"
				},
				dataType: 'html',
                success: function(data) {
                     $('#kt_tabs_title2').html(data);
                }
            });
            return false;
		});

    	$(document).on("submit", "#general-form-title2", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product.title2') }}",
                data: new FormData($('#general-form-title2')[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status === 'success') {
                        toastr["success"]("{{ $module }} Update Successfully", "Success");
                        // location.reload();
                    } else if (data.status === 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                }
            });
            return false;
        });
         $(document).on("click", "#kt_tabs_title3_tab", function(e) {
			
            e.preventDefault();
            $.ajax({
                type: "Get",
                url: "{{ route('admin.product.title3') }}",
                data: {
					'product_id' : "{{$edit->id}}"
				},
				dataType: 'html',
                success: function(data) {
                     $('#kt_tabs_title3').html(data);
                }
            });
            return false;
		});

    	$(document).on("submit", "#general-form-title3", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product.title3') }}",
                data: new FormData($('#general-form-title3')[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status === 'success') {
                        toastr["success"]("{{ $module }} Update Successfully", "Success");
                        // location.reload();
                    } else if (data.status === 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                }
            });
            return false;
        });
        $(document).on("click", "#kt_tabs_tag_tab", function(e) {
            
            e.preventDefault();
            $.ajax({
                type: "Get",
                url: "{{ route('admin.product.tag') }}",
                data: {
                    'product_id' : "{{$edit->id}}"
                },
                dataType: 'html',
                success: function(data) {
                     $('#kt_tabs_tag').html(data);
                }
            });
            return false;
        });

        $(document).on("submit", "#general-form-tag", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product.tag') }}",
                data: new FormData($('#general-form-tag')[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status === 'success') {
                        toastr["success"]("{{ $module }} Update Successfully", "Success");
                        // location.reload();
                    } else if (data.status === 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                }
            });
            return false;
        });
        $(document).on("click", "#kt_tabs_inventory_tab", function(e) {
			
            e.preventDefault();
            $.ajax({
                type: "Get",
                url: "{{ $inventory_update }}",
                data: {
					'product_id' : "{{$edit->id}}"
				},
				dataType: 'html',
                success: function(data) {
                     $('#kt_tabs_inventory').html(data);
                }
            });
            return false;
		});
		
        $(document).on("submit", "#product_inventory_form", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ $inventory_update }}",
                data: new FormData($('#product_inventory_form')[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status === 'success') {
                        toastr["success"]("Inventory Update Successfully", "Success");
                    } else if (data.status === 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                }
            });
            return false;
        });

		$(document).on("click", "#kt_tabs_lot_inventory_tab", function(e) {
			
            e.preventDefault();
            $.ajax({
                type: "Get",
                url: "{{ route('admin.product.lot_inventory_update') }}",
                data: {
					'product_id' : "{{$edit->id}}"
				},
				dataType: 'html',
                success: function(data) {
                     $('#kt_tabs_lot').html(data);
                }
            });
            return false;
		});
		 $(document).on("submit", "#product_lot_inventory_form", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product.lot_inventory_update') }}",
                data: new FormData($('#product_lot_inventory_form')[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status === 'success') {
                        toastr["success"]("Inventory Update Successfully", "Success");
                    } else if (data.status === 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                }
            });
            return false;
        });

		$(document).on('submit', '#image-color-save-form', function(e) {
			e.preventDefault();
            $.ajax({
                type: "POST",
                url: $('#image-color-save-form').attr('action'),
                data: new FormData($('#image-color-save-form')[0]),
                processData: false,
                contentType: false,
				dataType: 'json',
                success: function(data) {
                    if (data.status === 'success') {
						$('#color_popup'+data.id).html(data.color_name);
						$('#exampleModal').modal("hide");
                        toastr["success"](data.message, "Success");
                    } else if (data.status === 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                }
            });
            return false;
		})

		// PRICE TAB
		
		$(document).on("click", "#kt_tabs_price_tab", function(e) {
			
            e.preventDefault();
            $.ajax({
                type: "Get",
                url: "{{ $price_update }}",
                data: {
					'product_id' : "{{$edit->id}}"
				},
				dataType: 'html',
                success: function(data) {
                     $('#kt_tabs_price').html(data);
                }
            });
            return false;
		});
		 $(document).on("submit", "#product_price_form", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ $price_update }}",
                data: new FormData($('#product_price_form')[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status === 'success') {
                        toastr["success"]("Price Update Successfully", "Success");
                    } else if (data.status === 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                }
            });
            return false;
		});
		
		// DIscount Tab
		$(document).on("click", "#kt_tabs_discount_tab", function(e) {
            e.preventDefault();
            $.ajax({
                type: "Get",
                url: "{{ route('admin.product.discount_update') }}",
                data: {
					'product_id' : "{{$edit->id}}"
				},
				dataType: 'html',
                success: function(data) {
                     $('#kt_tabs_discount').html(data);
                }
            });
            return false;
		});

		$(document).on("submit", "#discount-form", function(e) {
			e.preventDefault();
			var form_data = new FormData($('#discount-form')[0]);
			form_data.append('product_id', "{{$edit->id}}");
			applyDiscount(form_data, '');
            return false;
		});

		$(document).on("click", "#remove-discount", function(e) {
			e.preventDefault();
			var form_data = new FormData($('#discount-form')[0]);
			form_data.append('product_id', "{{$edit->id}}");
			form_data.delete('discount');
			form_data.append('discount', "");
			applyDiscount(form_data, 'reset');
            return false;
		});

		function applyDiscount(form_data, reset) {
			$.ajax({
                type: "POST",
                url: "{{ route('admin.product.discount_update') }}",
                data: form_data,
				dataType: 'json',
				processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status === 'success') {
						if(reset == 'reset') {
							$('#discount-form')[0].reset();
						}
                        toastr["success"](data.message, "Success");
                    } else if (data.status === 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                }
            });
		}
    });
</script>
@endpush
@stop