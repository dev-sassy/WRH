<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Add Category
            </header>
            <div class="panel-body">
                <div class="col-md-6">
                    <?php
                    $attributes = array('id' => 'add_category_form', 'role' => 'form', 'class' => 'cmxform form-horizontal adminex-form');
                    echo form_open_multipart('category/addCategory', $attributes);

                    $categoryName_field = array(
                        'name' => 'categoryName',
                        'id' => 'categoryName',
                        'value' => '',
                        'maxlength' => '50',
                        'class' => 'form-control',
                        'placeholder' => 'Category Name'
                    );
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Category Name :', 'categoryName'); ?>
                            <?php echo form_input($categoryName_field); ?>
                        </div>
                    </div>

                    <?php
                    $categoryImage_field = array(
                        'name' => 'categoryImage',
                        'id' => 'categoryImage',
                        'value' => '',
                        'accept' => 'image/*',
                        'class' => 'default',
                        'placeholder' => 'Category Image'
                    );
                    ?>

                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            <?php echo form_label('Category Image :', 'categoryImage'); ?>
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
                                        <?php echo form_upload($categoryImage_field); ?>
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $add_category_btn = array(
                        'name' => 'add_category',
                        'id' => 'add_category',
                        'value' => 'Add Category',
                        'class' => 'btn btn-primary'
                    );
                    ?>
                    <div class="form-group col-md-12">                        
                        <?php echo form_submit($add_category_btn); ?>     
                        <a href="<?php echo base_url() . 'category' ?>" class="btn btn-default"> Cancel </a>                            
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </section>
    </div>
</div>    
