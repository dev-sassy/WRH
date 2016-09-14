<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading pd-btm-25px">
                All Invites                
            </header>

            <div class="panel-body">
                <div class="adv-table table-responsive">
                    <table  class="display table table-bordered table-striped icon-color-blk" id="invite-table">
                        <thead>
                            <tr>
                                <td>
                                    Sr No.
                                </td>
                                <td>
                                    Recipient Name
                                </td>    
                                <td>
                                    Recipient Email
                                </td>
                                <td>
                                    Recipient Phone
                                </td>
                            </tr>
                        </thead>
                        <?php
                        if ($invite_count >= 1) {
                            ?>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($invites as $invite) {
                                    ?>
                                    <tr>
                                        <td width="3%"><?php echo $i++; ?></td>
                                        <td>
                                            <?php echo $invite['recipientName']; ?>
                                        </td>
                                        <td>
                                            <?php echo $invite['recipientEmail']; ?>
                                        </td>
                                        <td>
                                            <?php echo $invite['recipientPhone']; ?>
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
