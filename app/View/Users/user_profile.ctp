<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
var serverpath="<?php echo $this->Html->Url('/');?>";

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
		<div class="clearfix">
			<div class="pull-right">
				<span class="green middle bolder">Edit profile: &nbsp;</span>
				<div class="btn-toolbar inline middle no-margin">
						<a class="btn btn-info" href="<?php echo $this->webroot?>Users/edit_profile"><i class="ace-icon fa fa-pencil"></i></a>
				</div>
			</div>
		</div>

		<div class="hr dotted"></div>

		<div>
			<div id="user-profile-1" class="user-profile row">
				<div class="col-xs-12 col-sm-3 center">
					  <div>
						<span class="profile-picture">
				                        <?php if($userDetail['UserProfile']['profile_image']){?>
							     <img id="avatar" class="editable img-responsive" alt="Avatar" src="<?php echo $this->html->url('/');?>img/ProfileImages/small/<?php echo $userDetail['UserProfile']['profile_image'];?>"  />
				                        <?php }else{?>
								<img id="avatar" class="editable img-responsive" alt="Avatar" src="<?php echo $this->html->url('/');?>assets/avatars/profile-pic.jpg"  />
							<?php }?>
						</span>

						<div class="space-4"></div>

						<div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
							<div class="inline position-relative">
								<a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
									<i class="ace-icon fa fa-circle light-green"></i>
									&nbsp;
									<span class="white"><?php echo $userDetail['UserProfile']['first_name']." ".$userDetail['UserProfile']['last_name'];?></span>
								</a>

								<ul class="align-left dropdown-menu dropdown-caret dropdown-lighter">
									<li class="dropdown-header"> Change Status </li>
									<li>
										<a href="#">
											<i class="ace-icon fa fa-circle green"></i>&nbsp;
											<span class="green">Available</span>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="ace-icon fa fa-circle red"></i>&nbsp;<span class="red">Busy</span>
										</a>
									</li>

									<li>
										<a href="#">
											<i class="ace-icon fa fa-circle grey"></i>&nbsp;<span class="grey">Invisible</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="space-6"></div>
					<div class="profile-contact-info">
						<div class="profile-contact-links align-left">
							<a href="#" class="btn btn-link">
								<i class="ace-icon fa fa-phone bigger-120 green"></i>
								<?php echo $userDetail['UserProfile']['phone'];?>
							</a>

							<a href="mailto:<?php echo $userDetail['UserProfile']['email'];?>" class="btn btn-link">
								<i class="ace-icon fa fa-envelope bigger-120 pink"></i>
								<?php echo $userDetail['UserProfile']['email'];?>
							</a>
						</div>
						<div class="space-6"></div>
					</div>
					<div class="hr hr12 dotted"></div>
				</div>

				<div class="col-xs-12 col-sm-9">
					<div class="center">
						<span class="btn btn-app btn-sm btn-light no-hover">
							<span class="line-height-1 bigger-170 blue"><?php echo $countRetailers;?></span><br />
							<span class="line-height-1 smaller-90"> Retailers </span>

						</span>

						<span class="btn btn-app btn-sm btn-yellow no-hover">
							<span class="line-height-1 bigger-170"> <?php echo $countOrders ;?></span><br />
							<span class="line-height-1 smaller-90"> Orders </span>
						</span>

						<span class="btn btn-app btn-sm btn-pink no-hover">
							<span class="line-height-1 bigger-170"> <?php echo $countBtl ;?> </span><br />
							<span class="line-height-1 smaller-90"> Photos </span>
						</span>

					</div>

					<div class="space-12"></div>

					<div class="profile-user-info profile-user-info-striped">
						<div class="profile-info-row">
							<div class="profile-info-name"> Username </div>

							<div class="profile-info-value">
								<span class="editable" id="username"><?php echo $userDetail['User']['user_name'];?></span>
							</div>
						</div>

						<div class="profile-info-row">
							<div class="profile-info-name"> Location </div>

							<div class="profile-info-value">
								<i class="fa fa-map-marker light-orange bigger-110"></i>
								<span class="editable" id="country"><?php echo $userDetail['UserProfile']['address'];?></span>
								<span class="editable" id="city"><?php echo $userDetail['UserProfile']['city']." ".$userDetail['UserProfile']['state'];?></span>
							</div>
						</div>

						
						<div class="profile-info-row">
							<div class="profile-info-name"> Joined </div>

							<div class="profile-info-value">
								<span class="editable" id="signup"><?php echo date( "Y-m-d" , strtotime($userDetail['User']['created_at']));?></span>
							</div>
						</div>

						<div class="profile-info-row">
							<div class="profile-info-name"> Last Online </div>

							<div class="profile-info-value">
								<span class="editable" id="login">5 minutes ago</span>
							</div>
						</div>

					</div>

					<div class="space-20"></div>
					
				</div>
			</div>
		</div>
	   </div>
	</div><!-- /.col -->
</div><!-- /.row -->
<script>
document.write("<script src='<?php echo $this->html->url('/');?>js/user_profile.js'>"+"<"+"/script>");
</script>

