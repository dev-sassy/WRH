<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading pd-btm-25px">
                All Notification
                <div class="btn-group pull-right">
                    <a href="<?php echo base_url() . 'notifications/addNotification'; ?>" id="editable-sample_new" class="btn btn-primary">
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
                                    Message
                                </td>
                                <td>
                                    Date
                                </td>
                                <td></td>
                            </tr>
                        </thead>
                        <?php
                        if ($noti_count >= 1) {
                            ?>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($noti_detail as $noti_detail_list) {
                                    ?>
                                    <tr>
                                        <td width="3%">
                                            <?php echo $i++; ?>
                                        </td>
                                        <td>
                                            <?php echo $noti_detail_list->notification_message; ?>
                                        </td>
                                        <td>
                                            <?php echo $noti_detail_list->created_on; ?>
                                        </td>
                                        <td width="5%">
                                            <?php if ($noti_detail_list->created_on >= date('Y-m-d')) { ?>
                                                <a href="javascript: void(0);" 
                                                   onclick="open_confirmation_modal('<?php echo base_url() . 'notifications/del_notifications/' . $noti_detail_list->notificationId; ?>');">
                                                    <i class="fa fa-times" aria-hidden="true" title="Delete"></i>
                                                </a>
                                            <?php } ?>
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

            <?php $this->load->view('confirmation_modal'); ?>
        </section>
    </div>
</div>
