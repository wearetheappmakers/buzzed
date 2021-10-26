<!DOCTYPE html>



<!--

Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4 & Angular 8

Author: KeenThemes

Website: http://www.keenthemes.com/

Contact: support@keenthemes.com

Follow: www.twitter.com/keenthemes

Dribbble: www.dribbble.com/keenthemes

Like: www.facebook.com/keenthemes

Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes

Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes

License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.

-->
<html lang="en">



<!-- begin::Head -->

<head>

	<base href="">

	<meta charset="utf-8" />

	<title>{{ App\Models\GeneralSetting::where('deleted_at',NULL)->value('site_name') }}</title>

	<meta name="description" content="Latest updates and statistic charts">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!--begin::Fonts -->

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">



	<!--end::Fonts -->

	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.1/css/fixedHeader.dataTables.min.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.dataTables.min.css" /> -->
	<link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />

	<!--begin::Page Vendors Styles(used by this page) -->

	<link href="{{ asset('/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />



	<!--end::Page Vendors Styles -->



	<!--begin::Global Theme Styles(used by all pages) -->

	<link href="{{ asset('/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />

	<link href="{{ asset('/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />



	<!--end::Global Theme Styles -->

	<script src="{{ asset('/assets/plugins/global/plugins.bundle.js') }}" type="text/javascript"></script>

	<script src="{{ asset('/assets/js/scripts.bundle.js') }}" type="text/javascript"></script>

	<script src="https://momentjs.com/downloads/moment.js" type="text/javascript"></script>

	<!--begin::Layout Skins(used by all pages) -->



	<!--end::Layout Skins -->

	

	@php $icon = App\Models\GeneralSetting::where('deleted_at',NULL)->value('favicon_icon'); @endphp

	@if(!empty($icon))
		<link rel="shortcut icon" href="{{asset('/storage/uploads/brand/'.$icon)}}" />
	@else
		<link rel="shortcut icon" href="{{asset('assets/media/logos/buzzed_logo.png')}}" />
	@endif

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	@stack('styles')

</head>



<!-- end::Head -->



<!-- begin::Body -->

<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-aside--minimize kt-page--loading">



	<!-- begin:: Page -->



	<!-- begin:: Header Mobile -->

	<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed noprint">

		<div class="kt-header-mobile__logo">

			<a href="{{route('admin.home')}}">

				<img alt="Logo" src="{{asset('assets/media/logos/buzzed_logo.png')}}" style="height: 50px; width: 50px;" />

			</a>

		</div>

		<div class="kt-header-mobile__toolbar">

			<div class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></div>

			<div class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></div>

			<div class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></div>

		</div>

	</div>


	<!-- end:: Header Mobile -->

	<div class="kt-grid kt-grid--hor kt-grid--root">

		<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">



			<!-- begin:: Aside -->

			<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>

			<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">



				<!-- begin:: Aside Menu -->

				<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">

					<div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">

						<ul class="kt-menu__nav ">
							@if(Auth::guard('vendor')->check())
								<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('vendor.product')}}" class="kt-menu__link "><i class="kt-menu__link-icon fa fa-box"></i><span class="kt-menu__link-text">Product</span></a></li>

								<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('vendor.revenue.index')}}" class="kt-menu__link "><i class="kt-menu__link-icon fa fa-percent"></i><span class="kt-menu__link-text">Commision Report</span></a></li>

							@endif

							@if(Auth::guard('admin')->check())

							<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('admin.vendors.index','all')}}" class="kt-menu__link "><i class="kt-menu__link-icon fas fa-users"></i><span class="kt-menu__link-text">Customer</span></a></li>

							<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('admin.discount.index')}}" class="kt-menu__link "><i class="kt-menu__link-icon fas fa-users"></i><span class="kt-menu__link-text">Discount Master</span></a></li>

							<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('admin.outlet.index')}}" class="kt-menu__link "><i class="kt-menu__link-icon fas fa-users"></i><span class="kt-menu__link-text">Outlet</span></a></li>

							<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('admin.captain.index')}}" class="kt-menu__link "><i class="kt-menu__link-icon fas fa-users"></i><span class="kt-menu__link-text">Captain</span></a></li>

							<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('admin.order.index')}}" class="kt-menu__link "><i class="kt-menu__link-icon fas fa-users"></i><span class="kt-menu__link-text">All Bills</span></a></li>


							<!-- <li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('admin.brand.index')}}" class="kt-menu__link "><i class="kt-menu__link-icon fas fa-bookmark"></i><span class="kt-menu__link-text">Brand</span></a></li>

							<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('admin.banner.index',array('type'=>'Banner'))}}" class="kt-menu__link "><i class="kt-menu__link-icon fa fa-map"></i><span class="kt-menu__link-text">Banner Images</span></a></li>

						 	<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('admin.category.index')}}" class="kt-menu__link "><i class="kt-menu__link-icon fas fa-clipboard-list"></i><span class="kt-menu__link-text">Category</span></a></li>
							
							<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('admin.image_optimize.index')}}" class="kt-menu__link "><i class="kt-menu__link-icon fa fa-file-image"></i><span class="kt-menu__link-text">Image Optimize</span></a></li>
							
							<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('admin.product.index')}}" class="kt-menu__link "><i class="kt-menu__link-icon fa fa-box"></i><span class="kt-menu__link-text">Product</span></a></li>
							
							
							<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('admin.reviewrating.index')}}" class="kt-menu__link "><i class="kt-menu__link-icon fa fa-ticket-alt"></i><span class="kt-menu__link-text">Review</span></a></li>

							<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('admin.offer.index')}}" class="kt-menu__link "><i class="kt-menu__link-icon fa fa-gift"></i><span class="kt-menu__link-text">offers</span></a></li>

							<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('admin.discount.index')}}" class="kt-menu__link "><i class="kt-menu__link-icon fa fa-tag"></i><span class="kt-menu__link-text">Discount</span></a></li>

							<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('admin.revenue.index')}}" class="kt-menu__link "><i class="kt-menu__link-icon fa fa-percent"></i><span class="kt-menu__link-text">Commision Report</span></a></li>

							<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('admin.general.setting')}}" class="kt-menu__link "><i class="kt-menu__link-icon fa fa-cog"></i><span class="kt-menu__link-text">Settings</span></a></li> -->
												
							@endif
						</ul>

					</div>

				</div>



				<!-- end:: Aside Menu -->

			</div>



			<!-- end:: Aside -->

			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">



				<!-- begin:: Header -->

				<div id="kt_header" class="kt-header kt-grid kt-grid--ver  kt-header--fixed ">



					<!-- begin:: Aside -->

					<div class="kt-header__brand kt-grid__item  " id="kt_header_brand">

						<div class="kt-header__brand-logo">

							<a href="{{route('admin.home')}}">
								@php $logo = App\Models\GeneralSetting::where('deleted_at',NULL)->value('logo'); @endphp

								@if(!empty($logo))
									<img alt="Logo" src="{{asset('/storage/uploads/brand/'.$logo)}}" style="height: 80px; width: 100px;" />
								@else
									<img alt="Logo" src="{{asset('assets/media/logos/buzzed_logo.png')}}" style="height: 80px; width: 100px;" />
								@endif

							</a>

						</div>

					</div>



					<!-- end:: Aside -->



					<!-- begin:: Title -->

					<h3 class="kt-header__title kt-grid__item">
						<a href="{{route('admin.home')}}" style="color: #00c5ff;">
							{{ App\Models\GeneralSetting::where('deleted_at',NULL)->value('site_name') }}
						</a>
					</h3>



					<!-- end:: Title -->



					<!-- begin: Header Menu -->

					<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>

					<div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">

						<div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">

							<ul class="kt-menu__nav ">
								<!-- <li class="kt-menu__item  kt-menu__item--active " aria-haspopup="true"><a href="{{route('admin.home')}}" class="kt-menu__link "><span class="kt-menu__link-text">Dashboard</span></a></li> -->

								

							<!-- @if(Auth::guard('admin')->check())

								@if(Auth::user()->orders == 1)
								<li class="kt-menu__item kt-menu__item--active kt-menu__item--submenu kt-menu__item--rel kt-menu__item--open-dropdown" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Order</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
									<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
										<ul class="kt-menu__subnav">
											@if(Auth::user()->id == 1)
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.orderstatus.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Order Status Master</span></a></li>
											@endif
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.order.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">All Order List</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.order.status.index',2)}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Preparing Order List</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.order.status.index',4)}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Completed Order List</span></a></li>
											
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.order.status.index',5)}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Cancelled Order List</span></a></li>
											
										</ul>
									</div>
								</li>
								@endif 
								@if(Auth::user()->id == 1)
								<li class="kt-menu__item kt-menu__item--active kt-menu__item--submenu kt-menu__item--rel kt-menu__item--open-dropdown" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Vendors</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
									<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
										<ul class="kt-menu__subnav">
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.vendors.index','all')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">All</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.vendors.index',1)}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Active</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.vendors.index',0)}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">InActive</span></a></li>
										</ul>
									</div>
								</li>
								@endif

								@if(Auth::user()->id == 1)
								<li class="kt-menu__item kt-menu__item--active kt-menu__item--submenu kt-menu__item--rel kt-menu__item--open-dropdown" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">User</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
									<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
										<ul class="kt-menu__subnav">
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.user.index','all')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">All</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.user.index',1)}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Active</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.user.index',0)}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">InActive</span></a></li>
										</ul>
									</div>
								</li>
								@endif

								@if(Auth::user()->id == 1)
								<li class="kt-menu__item kt-menu__item--active kt-menu__item--submenu kt-menu__item--rel kt-menu__item--open-dropdown" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Location Managemet</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
									<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
										<ul class="kt-menu__subnav">
											
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.country.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Country</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.state.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">State</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.city.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">City</span></a></li>
										</ul>
									</div>
								</li>
								@endif

								@if(Auth::user()->products == 1)
								<li class="kt-menu__item kt-menu__item--active kt-menu__item--submenu kt-menu__item--rel kt-menu__item--open-dropdown" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Product Master</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
									<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
										<ul class="kt-menu__subnav">

											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.color.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Colors</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.size.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Sizes</span></a></li>
											
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.option.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Option</span></a></li>

											<li class="kt-menu__item " aria-haspopup="true"><a href="{{route('admin.option-value.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Option Value</span></a></li>
										</ul>
									</div>
								</li>
								@endif
							@endif -->
							</ul>

						</div>

					</div>



					<!-- end: Header Menu -->