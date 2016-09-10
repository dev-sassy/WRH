<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Profile
            </header>
            <div class="panel-body">
                <div class="col-md-6">
				 <form id="add_asd_form" role="form" class="cmxform form-horizontal adminex-form" method="post">
					<div class="form-group clearfix">
						<div class="col-md-12">
							<label for="exampleInputEmail1">First Name</label>
							<input type="text" name="firstname" id="firstname" value="<?php echo $asd[0]['fname']; ?>" class="form-control" />
							<span id="mail_err"></span>
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-md-12">
							<label for="exampleInputEmail1">Last Name</label>
							<input type="text" name="lastname" id="lastname" value="<?php echo $asd[0]['lname']; ?>" class="form-control" />
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-md-12">
							<label for="exampleInputEmail1">User Name</label>
							<input type="text" name="username" id="username" value="<?php echo $asd[0]['username']; ?>"  class="form-control" readonly />
						</div>
					</div>
					
					<div class="col-md-12">
						<input type="submit" class="btn btn-primary" name="update_asd" id="update_asd" value="Update"/>
					  
						<a href="<?php echo base_url() .'/category' ?>" class="btn btn-default"> Cancel </a>                            
						
					</div>
				</form>
                    
                </div>
            </div>
        </section>
    </div>
</div>