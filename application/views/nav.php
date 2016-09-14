<div class="left-side sticky-left-side">
    <!--logo and iconic logo start-->
    <div class="logo">
        <a href="<?php echo base_url() . 'coupons'; ?>">
            <img src="<?php echo base_url(); ?>assets/images/wrh_logo.png" height="50px" alt="">
        </a>
    </div>

    <div class="left-side-inner">

        <!-- visible to small devices only -->
        <div class="visible-xs hidden-sm hidden-md hidden-lg">
            <div class="media logged-user">
                <img alt="" src="<?php echo base_url(); ?>assets/images/photos/user-avatar.png" class="media-object">
                <div class="media-body">
                    <h4><a href="#"><?php echo $this->session->userdata('user_name'); ?></a></h4></div>
            </div>

            <h5 class="left-nav-title">Account Information</h5>
            <ul class="nav nav-pills nav-stacked custom-nav">
                <li><a href="<?php echo base_url() . 'admin/logout' ?>"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
            </ul>
        </div>

        <!--sidebar nav start-->
        <ul class="nav nav-pills nav-stacked custom-nav">
            <li class="menu-list"><a href=""><i class="fa fa-users"></i> <span>Vendors</span></a>
                <ul class="sub-menu-list">
                    <li><a href="<?php echo base_url() . 'vendor/addVendor'; ?>"> Add Vendor</a></li> 
                    <li><a href="<?php echo base_url() . 'vendor/viewVendors' ?>"> View All Vendors</a></li>
                </ul>
            </li>

            <li class="menu-list"><a href=""><i class="fa fa-exchange"></i> <span> Categories</span></a>
                <ul class="sub-menu-list">
                    <li><a href="<?php echo base_url() . 'category/addCategory'; ?>"> Add Category</a></li>                    
                    <li><a href="<?php echo base_url() . 'category/viewCategories'; ?>"> View All Categories</a></li>                    
                </ul>
            </li>

            <li class="menu-list"><a href=""><i class="fa fa-credit-card"></i> <span>Coupons</span></a>
                <ul class="sub-menu-list">
                    <li><a href="<?php echo base_url() . 'coupons/addCoupon'; ?>"> Add Coupon</a></li> 
                    <li><a href="<?php echo base_url() . 'coupons/viewCoupons' ?>"> View All Coupons</a></li>                    
                </ul>
            </li>

            <li class="menu-list"><a href=""><i class="fa fa-info"></i> <span>Notifications</span></a>
                <ul class="sub-menu-list">
                    <li><a href="<?php echo base_url() . 'notifications/addNotification'; ?>"> Add Notification</a></li> 
                    <li><a href="<?php echo base_url() . 'notifications'; ?>"> View All Notifications</a></li>                     
                </ul>
            </li>
            
            <li class="menu-list"><a href=""><i class="fa fa-book"></i> <span>Inquiries</span></a>
                <ul class="sub-menu-list">
                    <li><a href="<?php echo base_url() . 'inquiry'; ?>"> View All inquiries</a></li> 
                </ul>
            </li>

            <li class="menu-list"><a href=""><i class="fa fa-user-md"></i> <span>Subscribers</span></a>
                <ul class="sub-menu-list">
                    <li><a href="<?php echo base_url() . 'subscribers/viewSubscribers'; ?>"> View All Subscribers</a></li> 
                </ul>
            </li>

            <li class="menu-list"><a href=""><i class="fa fa-book"></i> <span>Invites</span></a>
                <ul class="sub-menu-list">
                    <li><a href="<?php echo base_url() . 'invite/viewInvites'; ?>"> View All Invites</a></li> 
                </ul>
            </li>

        </ul>
        <!--sidebar nav end-->

    </div>
</div>