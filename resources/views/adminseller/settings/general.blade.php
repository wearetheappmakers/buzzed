@extends('admin.main')

@section('content')

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

                    </div>

                    <form class="kt-form kt-form--label-right add_form" method="post" action="#">

                        @csrf
                        <div class="kt-portlet__body">

                            <div class="form-group row">
                                <h5>Site Setting :</h5>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Site Name:</label>
                                    <input type="text" class="form-control" placeholder="Enter site name" value="{{ isset($settings->site_name) ? $settings->site_name :''}}" name="site_name" id="site_name" autocomplete="off">
                                </div>
                                <div class="col-lg-4">
                                    <label>Site Logo:</label>
                                    <input type="file" class="form-control" name="logo" id="logo" autocomplete="off">
                                </div>
                                <div class="col-lg-4">
                                     @if($settings->logo)
                                        <div class="image_layer">
                                            <div class="image_div">
                                                <a target="_blank"  href="{{ url('storage/uploads/brand/'.$settings->logo) }}" rel="gallery" class="fancybox" title="">
                                                    <img src="{{ url('storage/uploads/brand/Tiny/'.$settings->logo) }}" class="img-thumbnail" alt="{{ $settings->logo }}" />
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                
                                <div class="col-lg-4">
                                    <label>Admin Name:</label>
                                    <input type="text" class="form-control" placeholder="Enter name" value="{{ isset($settings->admin_name) ? $settings->admin_name :''}}" name="admin_name" id="admin_name" autocomplete="off">
                                </div>
                                <div class="col-lg-4">
                                    <label>Admin Email:</label>
                                    <input type="email" class="form-control" value="{{ isset($settings->admin_email) ? $settings->admin_email :''}}" placeholder="Enter email" name="admin_email" autocomplete="off">
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                
                                <div class="col-lg-4">
                                    <label>Favicon Icon:</label>
                                    <input type="file" class="form-control" name="favicon_icon" autocomplete="off">
                                </div>
                                <div class="col-lg-4">
                                     @if($settings->favicon_icon)
                                        <div class="image_layer">
                                            <div class="image_div">
                                                <a target="_blank"  href="{{ url('storage/uploads/brand/'.$settings->favicon_icon) }}" rel="gallery" class="fancybox" title="">
                                                    <img src="{{ url('storage/uploads/brand/Tiny/'.$settings->favicon_icon) }}" class="img-thumbnail" alt="{{ $settings->favicon_icon }}" />
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                            </div>

                            <div class="form-group row">
                                <h5>Email Setting :</h5>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>SMTP Host:</label>
                                    <input type="text" class="form-control" value="{{ isset($settings->smtp_host) ? $settings->smtp_host :''}}" placeholder="Enter smtp host" name="smtp_host" id="smtp_host" autocomplete="off">
                                </div>
                                <div class="col-lg-4">
                                    <label>SMTP Port:</label>
                                    <input type="text" class="form-control" value="{{ isset($settings->smtp_port) ? $settings->smtp_port :''}}" placeholder="Enter smtp port" name="smtp_port" id="smtp_port" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>UserName:</label>
                                    <input type="text" class="form-control" value="{{ isset($settings->smtp_username) ? $settings->smtp_username :''}}" placeholder="Enter username" name="smtp_username" id="smtp_username" autocomplete="off">
                                </div>
                                <div class="col-lg-4">
                                    <label>Password:</label>
                                    <input type="password" class="form-control" value="{{ isset($settings->smtp_encrytion) ? $settings->smtp_encrytion :''}}" placeholder="Enter mail password" name="smtp_encrytion" id="smtp_encrytion" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>From Email:</label>
                                    <input type="text" class="form-control" value="{{ isset($settings->from_email) ? $settings->from_email :''}}" placeholder="Enter from email" name="from_email" id="from_email" autocomplete="off">
                                </div>
                                <div class="col-lg-4">
                                    <label>From Name:</label>
                                    <input type="text" class="form-control" value="{{ isset($settings->smtp_from_name) ? $settings->smtp_from_name :''}}" placeholder="Enter from name" name="smtp_from_name" id="smtp_from_name" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <h5>Shop Timing :</h5>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Open Time:</label>
                                    <input type="time" class="form-control" value="{{ isset($settings->shop_open) ? $settings->shop_open :''}}" placeholder="Enter from email" name="shop_open" id="shop_open" autocomplete="off">
                                </div>
                                <div class="col-lg-4">
                                    <label>Close Timing:</label>
                                    <input type="time" class="form-control" value="{{ isset($settings->shop_close) ? $settings->shop_close :''}}" placeholder="Enter from name" name="shop_close" id="shop_close" autocomplete="off">
                                </div>
                            </div>

                        </div>

                        <div class="kt-portlet__foot">

                            <div class="kt-form__actions">

                                <div class="row">

                                    <div class="col-lg-4"></div>

                                    <div class="col-lg-8">

                                        <button type="button" class="btn btn-primary submit change_button">Update<i class="la la-spinner change_spin d-none"></i></button>

                                        <a href="#"><button type="button" class="btn btn-secondary">Cancel</button></a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

    $(document).ready(function() {

        $(".submit").on("click", function(e) {
            
            e.preventDefault();

            if ($(".add_form").valid()) {
                
                $('.change_button').find('.change_spin').removeClass('d-none');
                $('.change_button').prop('disabled', true);

                $.ajax({

                    type: "POST",

                    url: "{{ route('admin.general.update')}}",

                    data: new FormData($('.add_form')[0]),

                    processData: false,

                    contentType: false,

                    success: function(data) {

                        if (data.status === 'success') {
                            
                            window.location.reload();

                            toastr["success"]("Setting Added Successfully", "Success");

                            

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
    
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

</script>



@stop
