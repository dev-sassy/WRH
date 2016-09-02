<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Add Vendor
            </header>
            <div class="panel-body">
                <div class="col-md-6">
                    <?php
                    $attributes = array('id' => 'add_vendor_form', 'role' => 'form', 'class' => 'cmxform form-horizontal adminex-form');
                    echo form_open('vendor/addVendor', $attributes);

                    $vendorName_field = array(
                        'name' => 'vendorName',
                        'id' => 'vendorName',
                        'value' => '',
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
                    $createdOn_field = array(
                        'name' => 'createdOn',
                        'id' => 'createdOn',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Created On'
                    );
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Created On :', 'createdOn'); ?>
                            <?php echo form_input($createdOn_field); ?>
                        </div>
                    </div>

                    <?php
                    $add_vendor_btn = array(
                        'name' => 'add_vendor',
                        'id' => 'add_vendor',
                        'value' => 'Add Vendor',
                        'class' => 'btn btn-primary'
                    );
                    ?>
                    <div class="form-group col-md-12">                        
                        <?php echo form_submit($add_vendor_btn); ?>     
                        <a href="<?php echo base_url() . 'vendor' ?>" class="btn btn-default"> Cancel </a>                            
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </section>
    </div>
</div>    
