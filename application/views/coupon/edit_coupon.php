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
                    echo form_open('coupons/editCoupon/' . $coupon_details[0]['couponId'], $attributes, $hidden_coupon_id);

                    $attrib = array("class" => "form-control", "required" => TRUE, "title" => "Please select atleast one category.");
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Category Name :', 'categoryName'); ?>
                            <?php echo form_dropdown('categoryId', $categories, $coupon_details[0]['categoryId'], $attrib); ?>
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
                    $couponCode_field = array(
                        'name' => 'couponCode',
                        'id' => 'couponCode',
                        'type' => 'number',
                        'min' => '1',
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
                        'placeholder' => 'Start Date'
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
                        'placeholder' => 'Expiry Date'
                    );
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Expiry Date :', 'expiryDate'); ?>
                            <?php echo form_input($expiryDate_field); ?>
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
                        'value' => 'Edit Coupon',
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