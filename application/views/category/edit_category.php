<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Category
            </header>
            <div class="panel-body">
                <div class="col-md-6">
                    <?php
                    $attributes = array('id' => 'edit_category_form', 'role' => 'form', 'class' => 'cmxform form-horizontal adminex-form');
                    $hidden_category_id = array('categoryId' => $cat_details[0]['categoryId']);
                    echo form_open('category/editCategory/' . $cat_details[0]['categoryId'], $attributes, $hidden_category_id);

                    $categoryName_field = array(
                        'name' => 'categoryName',
                        'id' => 'categoryName',
                        'value' => $cat_details[0]['categoryName'],
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
                    $edit_category_btn = array(
                        'name' => 'edit_category',
                        'id' => 'edit_category',
                        'value' => 'Edit Category',
                        'class' => 'btn btn-primary'
                    );
                    ?>
                    <div class="form-group col-md-12">                        
                        <?php echo form_submit($edit_category_btn); ?>     
                        <a href="<?php echo base_url() . 'category' ?>" class="btn btn-default"> Cancel </a>                            
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </section>
    </div>
</div>