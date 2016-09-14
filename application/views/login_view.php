<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

<script src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.js" ></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" ></script>

<div class="login-body">
    <?php if ($this->session->flashdata('success_message') !== NULL) { ?>
    <div class="alert alert-success" style="text-align: center;" id="alert_success">
            <?php echo '<h6>' . $this->session->flashdata('success_message') . '</h6>'; ?>
        </div>
    <?php } ?>

    <?php if ($this->session->flashdata('error_message') !== NULL) { ?>
        <div class="alert alert-danger" style="text-align: center;" id="alert-error">
            <?php echo '<h6>' . $this->session->flashdata('error_message') . '</h6>'; ?>
        </div>
    <?php } ?>

    <div class="container">
        <form id="login_form" role="form" class="form-signin" method="post">

            <div class="form-signin-heading text-center">
                <h1 class="sign-title">Sign In</h1>                
            </div>

            <div class="login-wrap">
                <input type="text" id="signin_id" name="username" autofocus="" placeholder="User ID" class="form-control">
                <input type="password" id="signin_password" name="password" placeholder="Password" class="form-control">

                <button type="submit" value="Login" id="chk_login" name="chk_login" class="btn btn-lg btn-login btn-block">
                    <i class="fa fa-check"></i>
                </button>
            </div>
        </form>
    </div>
</div>