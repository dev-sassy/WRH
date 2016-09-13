<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Coupon
            </header>
            <div class="panel-body">
                <div class="col-md-6">
                    <?php
                    $attributes = array('id' => 'edit_coupon_form', 'role' => 'form', 'class' => 'cmxform form-horizontal adminex-form');
                    $hidden_coupon_id = array('couponId' => $coupon_details[0]['couponId']);
                    echo form_open_multipart('coupons/editCoupon/' . $coupon_details[0]['couponId'], $attributes, $hidden_coupon_id);

                    $attrib = array("class" => "form-control", "required" => TRUE, "title" => "Please select category.");
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Category Name :', 'categoryName'); ?>
                            <?php echo form_dropdown('categoryId', $categories, $coupon_details[0]['categoryId'], $attrib); ?>
                        </div>
                    </div>

                    <?php
                    $attrib = array("class" => "form-control", "required" => TRUE, "title" => "Please select vendor.");
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Vendor Name :', 'vendorName'); ?>
                            <?php echo form_dropdown('vendorId', $vendors, $coupon_details[0]['vendorId'], $attrib); ?>
                        </div>
                    </div>

                    <?php
                    $couponName_field = array(
                        'name' => 'couponName',
                        'id' => 'couponName',
                        'value' => $coupon_details[0]['couponName'],
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
                        'value' => $coupon_details[0]['couponImage'],
                        'accept' => 'image/*',
                        'class' => 'default',
                        'placeholder' => 'Coupon Image'
                    );
                    ?>

                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Coupon Image :', 'couponImage'); ?>
                            <div class="fileupload <?php
                            if (empty($coupon_details[0]['couponImage'])) {
                                echo 'fileupload-new';
                            } else {
                                echo 'fileupload-exists';
                            }
                            ?>" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="<?php echo base_url() . 'assets/images/no-image.png' ?>" alt="No image" />                                    
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" 
                                     style="max-width: 200px; max-height: 150px; line-height: 10px;">
                                         <?php
                                         if (!empty($coupon_details[0]['couponImage'])) {
                                             echo '<img src="' . base_url() . 'images/' . $coupon_details[0]['couponImage'] . '" alt="No image" />';
                                         }
                                         ?>
                                </div>
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
                        'value' => $coupon_details[0]['couponCode'],
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
                        'value' => $coupon_details[0]['startDate'],
                        'class' => 'form-control',
                        'placeholder' => 'Start Date',
                        'required' => 'true',
                        'readonly' => 'true'
                    );
                    ?>                    
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Start Date :', 'startDate'); ?>
                            <?php echo form_input($startDate_field); ?>                            
                        </div>
                    </div>

                    <?php
                    $expiryDate_field = array(
                        'name' => 'expiryDate',
                        'id' => 'expiryDate',
                        'value' => $coupon_details[0]['expiryDate'],
                        'class' => 'form-control',
                        'placeholder' => 'Expiry Date',
                        'required' => 'true',
                        'readonly' => 'true'
                    );
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Expiry Date :', 'expiryDate'); ?>
                            <?php echo form_input($expiryDate_field); ?>
                        </div>
                    </div>

                    <?php
                    $couponDescription_field = array(
                        'name' => 'couponDescription',
                        'id' => 'couponDescription',
                        'value' => $coupon_details[0]['couponDescription'],
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
                        'type' => 'number',
                        'min' => '1',
                        'value' => $coupon_details[0]['couponLimit'],
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
                    $edit_coupon_btn = array(
                        'name' => 'edit_coupon',
                        'id' => 'edit_coupon',
                        'value' => 'Update Coupon',
                        'class' => 'btn btn-primary'
                    );
                    ?>
                    <div class="form-group col-md-12">                        
                        <?php echo form_submit($edit_coupon_btn); ?>     
                        <a href="<?php echo base_url() . 'coupons' ?>" class="btn btn-default"> Cancel </a>                            
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </section>
    </div>
</div>