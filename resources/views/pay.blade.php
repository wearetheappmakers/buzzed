
<!DOCTYPE html>

<html lang="en">

<head>
    <base href="../../../../">
    <meta charset="utf-8" />
    <title>FashionB2B</title>
    <meta name="description" content="User profile personal information example">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />

    <script src="{{ asset('assets/plugins/global/plugins.bundle.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js')}}" type="text/javascript"></script>

    <link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}" />
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <!-- Include whatever JQuery which you are using -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <style>
        .hide{
            display: none;
        }
    </style>
</head>

<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-aside--minimize kt-page--loading">

    <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
        <div class="kt-header-mobile__logo">
            <a href="index.html">
                <img alt="Logo" src="{{asset('assets/media/logos/logo-6-sm.png')}}" />
            </a>
        </div>
        <div class="kt-header-mobile__toolbar">
            <div class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></div>
            <div class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></div>
            <div class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></div>
        </div>
    </div>

    <div id="main-content">
        <div class="container clear">
            <div class="panel-body" style="border: 1px solid #ddd;padding: 10px;background: #eee;width: 30%;">
                <form id="rzp-footer-form" method="POST" style="width: 100%; text-align: center" >
                    @csrf

                    <a href="https://amzn.to/2RlZQXk">
                        <img src="https://images-na.ssl-images-amazon.com/images/I/31tPpWGQWzL.jpg" />
                    </a>    
                    <br/>
                    <p><br/>Price: 2,475 INR </p>
                    <input type="hidden" name="amount" id="amount" value="2475"/>
                    <div class="pay">
                        <button class="razorpay-payment-button btn filled small" id="paybtn" type="button">Pay with Razorpay</button>                        
                    </div>
                </form>
                <br/><br/>
                <div id="paymentDetail" style="display: none">
                    <center>
                        <div>paymentID: <span id="paymentID"></span></div>
                        <div>paymentDate: <span id="paymentDate"></span></div>
                    </center>
                </div>
            </div>

        </div>
    </div>
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>
    <script>
        $('#rzp-footer-form').submit(function (e) {
            var button = $(this).find('button');
            var parent = $(this);
            button.attr('disabled', 'true').html('Please Wait...');
            $.ajax({
                method: 'get',
                url: this.action,
                data: $(this).serialize(),
                complete: function (r) {
                    console.log('complete');
                    console.log(r);
                }
            })
            return false;
        })
    </script>

    <script>
        function padStart(str) {
            return ('0' + str).slice(-2)
        }

        function demoSuccessHandler(transaction) {
            $("#paymentDetail").removeAttr('style');
            $('#paymentID').text(transaction.razorpay_payment_id);
            var paymentDate = new Date();
            $('#paymentDate').text(
                padStart(paymentDate.getDate()) + '.' + padStart(paymentDate.getMonth() + 1) + '.' + paymentDate.getFullYear() + ' ' + padStart(paymentDate.getHours()) + ':' + padStart(paymentDate.getMinutes())
                );

            $.ajax({
                method: 'post',
                url: "{{ route('admin.dopayment') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "razorpay_payment_id": transaction.razorpay_payment_id
                },
                complete: function (r) {
                    console.log('complete');
                    console.log(r);
                }
            })
        }
    </script>
    <script>
        var options = {
            key: "{{ env('RAZORPAY_KEY') }}",
            amount: '247500',
            name: 'CodesCompanion',
            description: 'TVS Keyboard',
            image: 'https://i.imgur.com/n5tjHFD.png',
            handler: demoSuccessHandler
        }
    </script>
    <script>
        window.r = new Razorpay(options);
        document.getElementById('paybtn').onclick = function () {
            r.open()
        }
    </script>
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
    <script src="{{ asset('assets/js/pages/dashboard.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/pages/custom/user/profile.js')}}" type="text/javascript"></script>

</body>

</html>