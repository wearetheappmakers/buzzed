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

                <img class="kt-hidden" alt="Pic" src="<?php echo e(asset('assets/media/users/300_25.jpg')); ?>" />



                <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->

                <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">S</span>

            </div>

            <div class="kt-user-card__name">

                <?php echo e(Session::get('login_name')); ?>


            </div>

            <div class="kt-user-card__badge">
            <?php if(Auth::guard('admin')->check()): ?>
            <form id="logout-form" action="<?php echo e(url('admin/logout')); ?>" method="POST" >
                            <?php echo csrf_field(); ?>
                <!-- <span class="btn btn-success btn-sm btn-bold btn-font-md"> -->
                    <button class="btn btn-success btn-sm btn-bold btn-font-md" type="submit"  style="color: white;">Logout</button>
                    <!-- href="<?php echo e(url('admin/logout')); ?>" -->
                <!-- </span> -->
            </form>
            <?php endif; ?>
            <?php if(Auth::guard('customer')->check()): ?>
            <form id="logout-form" action="<?php echo e(url('customer/logout')); ?>" method="POST" >
                            <?php echo csrf_field(); ?>
                <button class="btn btn-success btn-sm btn-bold btn-font-md" type="submit"  style="color: white;">Logout</button>   
            </form>
            <?php endif; ?>
        
        </div>

        </div>



        <!--end: Head -->



    

    </div>

</div>



<!--end: User bar -->



</div>

</div><?php /**PATH D:\rohit\buzzed\buzzed\resources\views/admin/layout/sidebar.blade.php ENDPATH**/ ?>