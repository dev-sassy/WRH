<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading pd-btm-25px">
                All Coupons
                <div class="btn-group pull-right">
                    <a href="<?php echo base_url() . 'coupons/addCoupon'; ?>" id="editable-sample_new" class="btn btn-primary">
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
                                    Coupon Name
                                </td>
                                <td>
                                    Coupon Code
                                </td>
                                <td>
                                    Start Date
                                </td>
                                <td>
                                    Expiry Date
                                </td>
                                <td>
                                    Coupon Limit
                                </td>
                                <td></td>
                            </tr>
                        </thead>
                        <?php
                        if ($coupon_count >= 1) {
                            ?>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($coupons as $item) {
                                    ?>
                                    <tr>
                                        <td width="3"><?php echo $i++; ?></td>                                        
                                        <td>
                                            <?php echo $item['couponName']; ?>
                                        </td>
                                        <td>
                                            <?php echo $item['couponCode']; ?>
                                        </td>
                                        <td>
                                            <?php echo $item['startDate']; ?>
                                        </td>
                                        <td>
                                            <?php echo $item['expiryDate']; ?>
                                        </td>                                        
                                        <td>
                                            <?php echo $item['couponLimit']; ?>
                                        </td>                                        
                                        <td>
                                            <a href="<?php echo base_url() . 'coupons/editCoupon/' . $item['couponId']; ?>">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="<?php echo base_url() . 'coupons/deleteCoupon/' . $item['couponId']; ?>" onclick="return confirm('Are you sure?');">
                                                <i class="fa fa-times" aria-hidden="true" title="Delete"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                            <?php
                        } else {
                            echo "No Record Found";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
