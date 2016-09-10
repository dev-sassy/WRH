<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Add Notification
            </header>
            <div class="panel-body">
                <div class="col-md-6">
                    <form id="add_note_form" role="form" class="cmxform form-horizontal adminex-form" method="post">
						<div class="form-group clearfix">
                            <div class="col-md-12">
                                <label for="exampleInputEmail1">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="5" cols="50" placeholder="Description"></textarea>
                            </div>
                        </div>
						 <div class="form-group clearfix">
                            <div class="col-md-12">
                                <label for="exampleInputEmail1">Date</label>
								<input type="text" class="form-control"  name="event_date" id="event_date" placeholder="Date" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-primary" name="add_note" id="add_note" value="Add Notification"/>
                            <a href="<?php echo base_url() . 'notifications' ?>" class="btn btn-default"> Cancel </a>                            
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>    
