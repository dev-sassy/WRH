<div class="header-section">

    <!--toggle button start-->
    <a class="toggle-btn"><i class="fa fa-bars"></i></a>
    <!--toggle button end-->


    <!--notification menu start -->
    <div class="menu-right">
        <ul class="notification-menu">            
            <li>
                <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <img src="<?php echo base_url(); ?>assets/images/photos/user_icon.png" alt="" />
                    <?php echo strtoupper($this->session->userdata('USERNAME')); ?>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-usermenu pull-right">                    
                    <li><a href="<?php echo base_url() . 'login/edit_profile' ?>"><i class="fa fa-sign-out"></i>Edit Profile</a></li>
                    <li><a href="<?php echo base_url() . 'login/change_password' ?>"><i class="fa fa-sign-out"></i>Change Password</a></li>
                    <li><a href="<?php echo base_url() . 'login/logout' ?>"><i class="fa fa-sign-out"></i> Log Out</a></li>
                </ul>
            </li>

        </ul>
    </div>
    <!--notification menu end -->

</div>