<div id="navbar" class="navbar navbar-default">
	<script type="text/javascript">
		try{ace.settings.check('navbar' , 'fixed')}catch(e){}
	</script>

	<div class="navbar-container" id="navbar-container">
		<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
			<span class="sr-only">Toggle sidebar</span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>
		</button>

		<div class="navbar-header pull-left">
			<a href="/users/userProfile" class="navbar-brand">
				<small>
					<i class="fa fa-leaf"></i>
					BMS4U
				</small>
			</a>
		</div>

		<div class="navbar-buttons navbar-header pull-right" role="navigation">
			<ul class="nav ace-nav">
				<li class="light-blue">
					<a data-toggle="dropdown" href="#" class="dropdown-toggle">
					 <?php
							 $user_detail= $this->Session->read('user');
							  if( $user_detail['UserProfile']['profile_image']){?>
						                        <img  class="nav-user-photo" alt="" src="<?php echo $this->html->url('/');?>img/ProfileImages/small/<?php echo  $user_detail['UserProfile']['profile_image'];?>"  />
				                        <?php }else{?>
								<img class="nav-user-photo" src="<?php echo $this->html->url('/');?>assets/avatars/profile-pic.jpg" alt="">
				                            <?php }?>
								<span class="user-info">
									<small>Welcome,</small>
									<?php echo $userDetail['UserProfile']['first_name']." ".$userDetail['UserProfile']['last_name']; ?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
					</a>

					<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
						<li>
							<a href="#">
								<i class="ace-icon fa fa-cog"></i>
								Settings
							</a>
						</li>

						<li>
							<a href="<?php echo $this->html->url('/users/userProfile') ?>" >
								<i class="ace-icon fa fa-user"></i>
								Profile
							</a>
						</li>

						<li class="divider"></li>

						<li>
						
							<a href="<?php echo $this->html->url('/users/logout') ?>">
								<i class="ace-icon fa fa-power-off"></i>
								Logout
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div><!-- /.navbar-container -->
</div>
