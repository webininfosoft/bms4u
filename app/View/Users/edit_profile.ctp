<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
   $('input[type="radio"]').click(function(){
	    if($(this).attr("value")=="red"){
        $("#pro").show();
		}
  });
  $("#hide").click(function(){
    $(".hide").show();
  });
});

</script>


<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
			<?php echo $this->Session->flash(); ?>

		<div class="hr dotted"></div>

		
<?php //print_r($userDetail);?>
		

		<div class="" id="pro">
			<div id="user-profile-3" class="user-profile row">
				<div class="col-sm-offset-1 col-sm-10">
				

				
						<div class="tabbable">
							<ul class="nav nav-tabs padding-16">
								<li class="active">
									<a data-toggle="tab" href="#edit-basic">
										<i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
										Basic Info
									</a>
								</li>
								<li>
									<a data-toggle="tab" href="#edit-password">
										<i class="blue ace-icon fa fa-key bigger-125"></i>
										Password
									</a>
								</li>
							</ul>

							<div class="tab-content profile-edit-tab-content">
                            	
									<div id="edit-basic" class="tab-pane in active">
                                    
                                     <?php echo $this->Form->create('',array('class'=>'form-horizontal'));?>
									<h4 class="header blue bolder smaller">General</h4>

									<div class="row">
									

										<div class="col-xs-12 col-sm-8">
											<div class="form-group">
												<label class="col-sm-4 control-label no-padding-right" for="form-field-username">Username</label>

												<div class="col-sm-8">
													
                                                    <?php echo $this->Form->input('User.user_name',array('div'=>false,'label'=>false,'class'=>'col-xs-12 col-sm-10','id'=>'form-field-username','placeholder'=>"Username"));?>	
												</div>
											</div>

											<div class="space-4"></div>

											<div class="form-group">
												<label class="col-sm-4 control-label no-padding-right" for="form-field-first">Name</label>

												<div class="col-sm-8">
                                                     <?php echo $this->Form->input('UserProfile.first_name',array('div'=>false,'label'=>false,'class'=>'col-xs-12 col-sm-10','id'=>'form-field-first','placeholder'=>"First Name"));?>	
                                                     
													
												</div>
											</div>
                                            
                                            <div class="space-4"></div>
                                            <div class="form-group">
												<label class="col-sm-4 control-label no-padding-right" for="form-field-last">Last Name</label>

												<div class="col-sm-8">
                                                    <?php echo $this->Form->input('UserProfile.last_name',array('div'=>false,'label'=>false,'class'=>'col-xs-12 col-sm-10','id'=>'form-field-last','placeholder'=>"Last Name"));?>	
                                                     
													
												</div>
											</div>
                                            <div class="space-4"></div>
											<div class="form-group">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-comment">Address</label>

										<div class="col-sm-8">
                                         <?php echo $this->Form->input('UserProfile.address',array('type'=>'textarea','div'=>false,'label'=>false,'class'=>'col-xs-12 col-sm-10','id'=>'form-field-comment','placeholder'=>"Address"));?>	
											
										</div>
									</div>
                                    
                                    	<div class="space-4"></div>
									<h4 class="header blue bolder smaller">Contact</h4>

									<div class="form-group">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-email">Email</label>

										<div class="col-sm-8">
											<span class="input-icon input-icon-right">
												
                                                 <?php echo $this->Form->input('UserProfile.email',array('div'=>false,'label'=>false,'class'=>'col-xs-12 col-sm-12','id'=>'form-field-email','placeholder'=>"Email"));?>	
												<i class="ace-icon fa fa-envelope"></i>
											</span>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-phone">Phone</label>

										<div class="col-sm-8">
											<span class="input-icon input-icon-right">
												
                                                 <?php echo $this->Form->input('UserProfile.phone',array('div'=>false,'label'=>false,'class'=>' col-xs-12 col-sm-12','id'=>'form-field-phone','placeholder'=>"Phone"));?>	
												<i class="ace-icon fa fa-phone fa-flip-horizontal"></i>
											</span>
										</div>
									</div>
                                    <div class="space-4"></div>
                                    <div class="form-group">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-phone">Website</label>

										<div class="col-sm-8">
											<span class="input-icon input-icon-right">
												
                                                 <?php echo $this->Form->input('UserProfile.url',array('div'=>false,'label'=>false,'class'=>' col-xs-12 col-sm-12','id'=>'form-field-web','placeholder'=>"URL"));?>	
												<i class="ace-icon fa fa-globe"></i>
											</span>
										</div>
									</div>
										</div>
									</div>
									

								
                                    <div class="clearfix form-actions">
							<div class="col-md-offset-3 col-md-9">
								<button class="btn btn-info" type="submit" id="submit" onclick="submitform();">
									<i class="ace-icon fa fa-check bigger-110"></i>
									Save
								</button>

								&nbsp; &nbsp;
								<button class="btn" type="reset">
									<i class="ace-icon fa fa-undo bigger-110"></i>
									Reset
								</button>
							</div>
						</div>
                     <?php echo $this->Form->end();?>
								</div>
								
								
								
								<div id="edit-password" class="tab-pane" >
                               <?php echo $this->Form->create('',array('class'=>'form-horizontal'));?>
                                
									<div class="space-10"></div>
									<?php echo $this->Form->input('User.profVal',array('type'=>'hidden','value'=>1));?>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-pass1">New Password</label>

										<div class="col-sm-9">
										
                                      <?php echo $this->Form->input('User.user_password',array('div'=>false,'label'=>false,'type'=>'password','value'=>'','autocomplete'=>false,'id'=>'form-field-pass1'));?>	
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-pass2">Confirm Password</label>
										<div class="col-sm-9">
                                            <?php echo $this->Form->input('User.cnpassword',array('div'=>false,'label'=>false,'type'=>'password','id'=>'form-field-pass2'));?>
										</div>
									</div>
                                    <div class="space-4"></div>
                                    <div class="clearfix form-actions">
							<div class="col-md-offset-3 col-md-9">
								<button class="btn btn-info" type="submit" id="submit" onclick="submitform();">
									<i class="ace-icon fa fa-check bigger-110"></i>
									Save
								</button>

								&nbsp; &nbsp;
								<button class="btn" type="reset">
									<i class="ace-icon fa fa-undo bigger-110"></i>
									Reset
								</button>
							</div>
						</div>
                          <?php echo $this->Form->end();?>
								</div>
                              
							</div>
						</div>

						

					
				</div><!-- /.span -->
			</div><!-- /.user-profile -->
		</div>
		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
</div><!-- /.row -->
<script type="text/javascript">
document.write("<script src='<?php echo $this->html->url('/');?>js/user_profile.js'>"+"<"+"/script>");
</script>

