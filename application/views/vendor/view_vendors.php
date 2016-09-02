<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading pd-btm-25px">
                All Vendors
                <div class="btn-group pull-right">
                    <a href="<?php echo base_url() . 'vendor/addVendor'; ?>" id="editable-sample_new" class="btn btn-primary">
                        Add New <i class="fa fa-plus"></i>
                    </a>
                </div>
            </header>

            <div class="panel-body">
                <div class="adv-table table-responsive">
                    <table  class="display table table-bordered table-striped icon-color-blk" id="dynamic-table">
                        <thead>
                            <tr>
                                <td>
                                    Sr No.
                                </td>                                
                                <td>
                                    Vendor Name
                                </td>
                                <td>
                                    Created on
                                </td>                                
                                <td></td>
                            </tr>
                        </thead>
                        <?php
                        if ($vendor_count >= 1) {
                            ?>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($vendors as $company) {
                                    ?>
                                    <tr>
                                        <td width="3"><?php echo $i++; ?></td>                                        
                                        <td>
                                            <?php echo $company['vendorName']; ?>
                                        </td>
                                        <td>
                                            <?php echo $company['createdOn']; ?>
                                        </td>                                        
                                        <td>
                                            <a href="<?php echo base_url() . 'vendor/editVendor/' . $company['vendorId']; ?>">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="<?php echo base_url() . 'vendor/deleteVendor/' . $company['vendorId']; ?>" onclick="return confirm('Are you sure?');">
                                                <i class="fa fa-times" aria-hidden="true" title="Delete"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                            <?php
                        } else {
                            echo "No Record Found.";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>