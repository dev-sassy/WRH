<div class="left-side sticky-left-side">
    <!--    logo and iconic logo start
        <div class="logo">
            <a href="<?php echo base_url() . $this->session->userdata('route_path') . '/success_login'; ?>"><img src="<?php echo base_url(); ?>assets/images/HBMC LOGO.png" height="50px" alt=""></a>
        </div>
    
        <div class="logo-icon text-center">
            <a href="<?php echo base_url() . $this->session->userdata('route_path') . '/success_login'; ?>"><img src="<?php echo base_url(); ?>assets/images/HBMC LOGO.png" height="50px" alt=""></a>
        </div>
        logo and iconic logo end-->

    <div class="left-side-inner">

        <!-- visible to small devices only -->
        <div class="visible-xs hidden-sm hidden-md hidden-lg">
            <div class="media logged-user">
                <img alt="" src="<?php echo base_url(); ?>assets/images/photos/user-avatar.png" class="media-object">
                <div class="media-body">
                    <h4><a href="#"><?php echo $this->session->userdata('user_name'); ?></a></h4>
                    <span>"Hello There..."</span>
                </div>
            </div>

            <h5 class="left-nav-title">Account Information</h5>
            <ul class="nav nav-pills nav-stacked custom-nav">
<!--                <li><a href="#"><i class="fa fa-user"></i> <span>Profile</span></a></li>
                <li><a href="#"><i class="fa fa-cog"></i> <span>Settings</span></a></li>-->
                <li><a href="<?php echo base_url() . 'admin/logout' ?>"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
            </ul>
        </div>

        <!--sidebar nav start-->
        <ul class="nav nav-pills nav-stacked custom-nav">
            <!--<li><a href="<?php echo base_url() . $this->session->userdata('route_path') . '/success_login'; ?>"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>-->

            <li class="menu-list"><a href=""><i class="fa fa-exchange"></i> <span> Categories</span></a>
                <ul class="sub-menu-list">
                    <li><a href="<?php echo base_url() . 'category/addCategory'; ?>"> Add Category</a></li>                    
                    <li><a href="<?php echo base_url() . 'category/viewCategories'; ?>"> View All Categories</a></li>                    
                </ul>
            </li>

            <li class="menu-list"><a href=""><i class="fa fa-credit-card"></i> <span>Coupon</span></a>
                <ul class="sub-menu-list">
                    <li><a href="<?php echo base_url() . 'coupons/addCoupon'; ?>"> Add Coupon</a></li> 
                    <li><a href="<?php echo base_url() . 'coupons/viewCoupons' ?>"> View All Coupons</a></li>                    
                </ul>
            </li>
        </ul>
        <!--sidebar nav end-->

    </div>
</div>