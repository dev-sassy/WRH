<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading pd-btm-25px">
                All Inquiries
            </header>

            <div class="panel-body">
                <div class="adv-table table-responsive">
                    <table  class="display table table-bordered table-striped icon-color-blk" id="inquiry-table">
                        <thead>
                            <tr>
                                <td>
                                    Sr No.
                                </td>
                                <td>
                                    Name
                                </td>
                                <td>
                                    Email
                                </td>
                                <td>
                                    Subject
                                </td>
                                <td>
                                    Message
                                </td>
                            </tr>
                        </thead>
                        <?php
                        if ($inq_count >= 1) {
                            ?>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($inq_detail as $inq_detail_list) {
                                    ?>
                                    <tr>
                                        <td width="3%">
                                            <?php echo $i++; ?>
                                        </td>
                                        <td>
                                            <?php echo $inq_detail_list->inquiryName; ?>
                                        </td>
                                        <td>
                                            <?php echo $inq_detail_list->inquiryEmail; ?>
                                        </td>
                                        <td>
                                            <?php echo $inq_detail_list->inquirySubject; ?>
                                        </td>
                                        <td>
                                            <?php echo $inq_detail_list->inquiryMessage; ?>
                                        </td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
