<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Add Coupon
            </header>
            <div class="panel-body">
                <div class="col-md-6">
                    <?php
                    $attributes = array('id' => 'add_coupon_form', 'role' => 'form', 'class' => 'cmxform form-horizontal adminex-form');
                    echo form_open_multipart('coupons/addCoupon', $attributes);

                    $attrib = array("class" => "form-control", "required" => TRUE, "title" => "Please select category.");
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Category Name :', 'categoryName'); ?>
                            <?php echo form_dropdown('categoryId', $categories, '', $attrib); ?>
                        </div>
                    </div>

                    <?php
                    $attrib = array("class" => "form-control", "required" => TRUE, "title" => "Please select vendor.");
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Vendor Name :', 'vendorName'); ?>
                            <?php echo form_dropdown('vendorId', $vendors, '', $attrib); ?>
                        </div>
                    </div>

                    <?php
                    $couponName_field = array(
                        'name' => 'couponName',
                        'id' => 'couponName',
                        'value' => '',
                        'maxlength' => '50',
                        'class' => 'form-control',
                        'placeholder' => 'Coupon Name'
                    );
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Coupon Name :', 'couponName'); ?>
                            <?php echo form_input($couponName_field); ?>
                        </div>
                    </div>

                    <?php
                    $couponImage_field = array(
                        'name' => 'couponImage',
                        'id' => 'couponImage',
                        'value' => '',
                        'accept' => 'image/*',
                        'class' => 'default',
                        'placeholder' => 'Coupon Image'
                    );
                    ?>

                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Coupon Image :', 'couponImage'); ?>
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <input type="hidden" value="" name="" />
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="<?php echo base_url(); ?>assets/images/no-image.png" alt="No image">
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"></div>
                                <div>
                                    <span class="btn btn-default btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <?php echo form_upload($couponImage_field); ?>
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $couponCode_field = array(
                        'name' => 'couponCode',
                        'id' => 'couponCode',
                        'value' => '',                        
                        'class' => 'form-control',
                        'placeholder' => 'Coupon Code'
                    );
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Coupon Code :', 'couponCode'); ?>
                            <?php echo form_input($couponCode_field); ?>
                        </div>
                    </div>                   

                    <?php
                    $startDate_field = array(
                        'name' => 'startDate',
                        'id' => 'startDate',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Start Date-time',
                        'required' => 'true',
                        'readonly' => 'true'
                    );
                    ?>                    
                    <div class="form-group clearfix">                        
                        <div class="col-md-12">
                            <?php echo form_label('Start Date-time :', 'startDate'); ?>
                            <?php echo form_input($startDate_field); ?>                                
                        </div>
                    </div>

                    <?php
                    $expiryDate_field = array(
                        'name' => 'expiryDate',
                        'id' => 'expiryDate',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Expiry Date-time',
                        'readonly' => 'true'
                    );
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Expiry Date-time :', 'expiryDate'); ?>
                            <?php echo form_input($expiryDate_field); ?>
                        </div>
                    </div>
                    
                    <?php
                    $couponDescription_field = array(
                        'name' => 'couponDescription',
                        'id' => 'couponDescription',
                        'rows' => 3,
                        'class' => 'form-control',
                        'placeholder' => 'Coupon Description'
                    );
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Coupon Description :', 'couponDescription'); ?>
                            <?php echo form_textarea($couponDescription_field); ?>
                        </div>
                    </div>

                    <?php
                    $couponLimit_field = array(
                        'name' => 'couponLimit',
                        'id' => 'couponLimit',
                        'value' => '',
                        'type' => 'number',
                        'min' => '1',
                        'step' => '1',
                        'class' => 'form-control',
                        'placeholder' => 'Coupon Limit'
                    );
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Coupon Limit :', 'couponLimit'); ?>
                            <?php echo form_input($couponLimit_field); ?>
                        </div>
                    </div>

                    <?php
                    $add_coupon_btn = array(
                        'name' => 'add_coupon',
                        'id' => 'add_coupon',
                        'value' => 'Add Coupon',
                        'class' => 'btn btn-primary'
                    );
                    ?>
                    <div class="form-group col-md-12">                        
                        <?php echo form_submit($add_coupon_btn); ?>     
                        <a href="<?php echo base_url() . 'coupons' ?>" class="btn btn-default"> Cancel </a>                            
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </section>
    </div>
</div>    
