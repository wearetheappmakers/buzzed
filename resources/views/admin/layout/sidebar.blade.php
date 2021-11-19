	<!-- begin:: Header Topbar -->

    <div class="kt-header__topbar">



<!--begin: User bar -->

<div class="kt-header__topbar-item kt-header__topbar-item--user">

    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">

        

        <span class="kt-header__topbar-icon kt-hidden-"><i class="flaticon2-user-outline-symbol"></i></span>

    </div>

    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">



        <!--begin: Head -->

        <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url(assets/media/misc/bg-1.jpg)">

            <div class="kt-user-card__avatar">

                <img class="kt-hidden" alt="Pic" src="{{asset('assets/media/users/300_25.jpg')}}" />



                <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->

                <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">S</span>

            </div>

            <div class="kt-user-card__name">

                {{ Session::get('login_name') }}

            </div>

            <div class="kt-user-card__badge">
            @if(Auth::guard('admin')->check())
            <form id="logout-form" action="{{  url('admin/logout') }}" method="POST" >
                            @csrf
                <!-- <span class="btn btn-success btn-sm btn-bold btn-font-md"> -->
                    <button class="btn btn-success btn-sm btn-bold btn-font-md" type="submit"  style="color: white;">Logout</button>
                    <!-- href="{{ url('admin/logout')}}" -->
                <!-- </span> -->
            </form>
            @endif
            @if(Auth::guard('customer')->check())
            <form id="logout-form" action="{{  url('customer/logout') }}" method="POST" >
                            @csrf
                <button class="btn btn-success btn-sm btn-bold btn-font-md" type="submit"  style="color: white;">Logout</button>   
            </form>
            @endif

            @if(Auth::guard('waiter')->check())
            <form id="logout-form" action="{{  url('waiter/logout') }}" method="POST" >
                            @csrf
                <button class="btn btn-success btn-sm btn-bold btn-font-md" type="submit"  style="color: white;">Logout</button>   
            </form>
            @endif

            @if(Auth::guard('manager')->check())
            <form id="logout-form" action="{{  url('manager/logout') }}" method="POST" >
                            @csrf
                <button class="btn btn-success btn-sm btn-bold btn-font-md" type="submit"  style="color: white;">Logout</button>   
            </form>
            @endif
        
        </div>

        </div>



        <!--end: Head -->



    

    </div>

</div>



<!--end: User bar -->



</div>

</div>