<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading pd-btm-25px">
                All Subscribers
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
                                    Subscriber Email-Id
                                </td>    
                                <td>
                                    Subscribed At
                                </td>
                            </tr>
                        </thead>
                        <?php
                        if ($subscribers_count >= 1) {
                            ?>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($subscribers as $subscriber) {
                                    ?>
                                    <tr>
                                        <td width="3%"><?php echo $i++; ?></td>
                                        <td>
                                            <?php echo $subscriber['subscriberEmailId']; ?>
                                        </td>
                                        <td>
                                            <?php echo $subscriber['subscribedAt']; ?>
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
