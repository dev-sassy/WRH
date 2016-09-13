<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Change Password
            </header>

            <div class="panel-body">
                <div class="col-md-6">
                    <form id="change_pass" role="form" class="cmxform form-horizontal adminex-form" method="post">
                        <div class="form-group clearfix">
                            <div class="col-md-12">
                                <label for="exampleInputEmail1">Old Password :</label>
                                <input type="password" name="old_password" id="old_password" class="form-control" />
                                <span id="mail_err"></span>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="col-md-12">
                                <label for="exampleInputEmail1">Password :</label>
                                <input type="password" name="password" id="password"  class="form-control" />
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="col-md-12">
                                <label for="exampleInputEmail1">Confirm Password :</label>
                                <input type="password" name="re_password" id="re_password" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <input type="submit" class="btn btn-primary" name="update" id="update" value="Change It"/>
                            <a href="<?php echo base_url(); ?>" class="btn btn-default"> Cancel </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>    
