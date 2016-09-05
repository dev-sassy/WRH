<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Vendor
            </header>
            <div class="panel-body">
                <div class="col-md-6">
                    <?php
                    $attributes = array('id' => 'edit_vendor_form', 'role' => 'form', 'class' => 'cmxform form-horizontal adminex-form');
                    $hidden_vendor_id = array('vendorId' => $vendor_details[0]['vendorId']);
                    echo form_open_multipart('vendor/editVendor/' . $vendor_details[0]['vendorId'], $attributes, $hidden_vendor_id);

                    $vendorName_field = array(
                        'name' => 'vendorName',
                        'id' => 'vendorName',
                        'value' => $vendor_details[0]['vendorName'],
                        'maxlength' => '50',
                        'class' => 'form-control',
                        'placeholder' => 'Vendor Name'
                    );
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Vendor Name :', 'vendorName'); ?>
                            <?php echo form_input($vendorName_field); ?>
                        </div>
                    </div>

                    <?php
                    $vendorImage_field = array(
                        'name' => 'vendorImage',
                        'id' => 'vendorImage',
                        'value' => '',
                        'accept' => 'image/*',
                        'class' => 'default',
                        'placeholder' => 'Vendor Image'
                    );
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Vendor Image :', 'vendorImage'); ?>
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
                                        <?php echo form_upload($vendorImage_field); ?>
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $edit_vendor_btn = array(
                        'name' => 'edit_vendor',
                        'id' => 'edit_vendor',
                        'value' => 'Update Vendor',
                        'class' => 'btn btn-primary'
                    );
                    ?>
                    <div class="form-group col-md-12">                        
                        <?php echo form_submit($edit_vendor_btn); ?>     
                        <a href="<?php echo base_url() . 'vendor' ?>" class="btn btn-default"> Cancel </a>                            
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </section>
    </div>
</div>