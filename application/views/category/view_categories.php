<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading pd-btm-25px">
                All Categories
                <div class="btn-group pull-right">
                    <a href="<?php echo base_url() . 'category/addCategory' ?>" id="editable-sample_new" class="btn btn-primary">
                        Add New <i class="fa fa-plus"></i>
                    </a>
                </div>
            </header>

            <div class="panel-body">
                <div class="adv-table table-responsive">
                    <table  class="display table table-bordered table-striped icon-color-blk" id="category-table">
                        <thead>
                            <tr>
                                <td>
                                    Sr No.
                                </td>
                                <td>
                                    Category Image
                                </td>
                                <td>
                                    Category Name
                                </td>                                    
                                <td></td>
                            </tr>
                        </thead>
                        <?php
                        if ($cat_count >= 1) {
                            ?>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($categories as $item) {
                                    ?>
                                    <tr>
                                        <td width="3%"><?php echo $i++; ?></td>
                                        <td>
                                            <?php
                                            if (empty($item['categoryImage'])) {
                                                echo '<img src="' . base_url() . 'assets/images/no-image.png' . '" height="auto" width="100" alt="Image not available." />';
                                            } else {
                                                echo '<img src="' . base_url() . 'images/' . $item['categoryImage'] . '" height="auto" width="100" alt="Image not available." />';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $item['categoryName']; ?>
                                        </td>                                        
                                        <td>
                                            <a href="<?php echo base_url() . 'category/editCategory/' . $item['categoryId']; ?>">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;                                            
                                            <a href="javascript: void(0);" 
                                               onclick="open_confirmation_modal('<?php echo base_url() . 'category/deleteCategory/' . $item['categoryId']; ?>');">
                                                <i class="fa fa-times" aria-hidden="true" title="Delete"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>

            <?php $this->load->view('confirmation_modal'); ?>
        </section>
    </div>
</div>
