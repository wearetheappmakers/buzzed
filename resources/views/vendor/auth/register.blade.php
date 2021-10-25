
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
		<base href="../../../">
		<meta charset="utf-8" />
		<title>Fashion B2B</title>
		<meta name="description" content="Edit user example">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

		<!--end::Fonts -->

		<!--begin::Page Custom Styles(used by this page) -->
		<link href="{{asset('assets/css/pages/wizard/wizard-4.css')}}" rel="stylesheet" type="text/css" />

		<!--end::Page Custom Styles -->

		<!--begin::Global Theme Styles(used by all pages) -->
		<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />

		<!--end::Global Theme Styles -->

		<!--begin::Layout Skins(used by all pages) -->

		<!--end::Layout Skins -->
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico')}}" />
        <script src="{{asset('assets/plugins/global/plugins.bundle.js')}}" type="text/javascript"></script>
		<script src="{{asset('assets/js/scripts.bundle.js')}}" type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts(used by this page) -->
		<script src="{{asset('assets/js/pages/custom/user/edit-user.js')}}" type="text/javascript"></script>
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-aside--minimize kt-page--loading">

		<!-- begin:: Page -->

	

		<!-- end:: Header Mobile -->
		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

				<!-- begin:: Aside -->
				<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
			

				<!-- end:: Aside -->
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

					
					<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">


						<!-- begin:: Content -->
						<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
							<div class="kt-portlet kt-portlet--tabs">
                                <form action="{{url('/vendor/register')}}" method="POST">
                                @csrf
                                    <div class="kt-portlet__body">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
                                                    <div class="kt-form kt-form--label-right">
                                                        <div class="kt-form__body">
                                                            <div class="kt-section kt-section--first">
                                                                <div class="kt-section__body">
                                                                    <div class="row">
                                                                        <label class="col-xl-3"></label>
                                                                        <div class="col-lg-9 col-xl-6">
                                                                            <h3 class="kt-section__title kt-section__title-sm">Vendor Info:</h3>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="form-group row">
                                                                        <label class="col-xl-3 col-lg-3 col-form-label">Name</label>
                                                                        <div class="col-lg-9 col-xl-6">
                                                                            <input class="form-control" type="text" placeholder="Name" name="name">
                                                                            
                                                                                @if ($errors->has('name'))
                                                                                    <span class="help-block">
                                                                                        <strong>{{ $errors->first('name') }}</strong>
                                                                                    </span>
                                                                                @endif
                                                                        </div>
                                                                    </div>
                                                                 
                                                                   
                                                                    
                                                                    <div class="form-group row">
                                                                        <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                                                                        <div class="col-lg-9 col-xl-6">
                                                                                <input type="email" name="email" class="form-control" placeholder="Email" aria-describedby="basic-addon1">
                                                                            
                                                                            @if ($errors->has('email'))
                                                                                <span class="help-block">
                                                                                    <strong>{{ $errors->first('email') }}</strong>
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                   
                                                                    <div class="form-group row">
                                                                        <label class="col-xl-3 col-lg-3 col-form-label">Password</label>
                                                                        <div class="col-lg-9 col-xl-6">
                                                                                <input type="password" name="password" class="form-control">
                                                                            
                                                                            @if ($errors->has('password'))
                                                                                <span class="help-block">
                                                                                    <strong>{{ $errors->first('password') }}</strong>
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <label class="col-xl-3 col-lg-3 col-form-label">Confirm Password</label>
                                                                        <div class="col-lg-9 col-xl-6">
                                                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                                                            
                                                                            @if ($errors->has('password_confirmation'))
                                                                                <span class="help-block">
                                                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                        
                                    </div>
                                
                                    <div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <a href="{{url('/vendor/login')}}" class="btn btn-secondary">Back</a>
                                            <button type="submit" class="btn btn-primary submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
							</div>
						</div>

						<!-- end:: Content -->
					</div>

					<!-- begin:: Footer -->
					

					<!-- end:: Footer -->
				</div>
			</div>
		</div>

		<!-- end:: Page -->


		<!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#22b9ff",
						"light": "#ffffff",
						"dark": "#282a3c",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
						"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
					}
				}
			};
		</script>

		<!-- end::Global Config -->

		<!--begin::Global Theme Bundle(used by all pages) -->
	

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>