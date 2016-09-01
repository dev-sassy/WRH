<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Add Category
            </header>
            <div class="panel-body">
                <div class="col-md-6">
                    <?php
                    echo $this->session->flashdata('error_message');

                    $attributes = array('id' => 'add_category_form', 'role' => 'form', 'class' => 'cmxform form-horizontal adminex-form');
                    echo form_open('category/addCategory', $attributes);

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
