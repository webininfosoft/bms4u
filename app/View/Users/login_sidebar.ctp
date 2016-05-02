<div id="sidebar" class="sidebar responsive">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon fa fa-signal"></i>
						</button>

						<button class="btn btn-info">
							<i class="ace-icon fa fa-pencil"></i>
						</button>

						<button class="btn btn-warning">
							<i class="ace-icon fa fa-users"></i>
						</button>

						<button class="btn btn-danger">
							<i class="ace-icon fa fa-cogs"></i>
						</button>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->

				<ul class="nav nav-list">
					<li class="">
						<a href="http://localhost/bms/Users/userProfile"> 
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text">Dashboard </span></a>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="hover">
						<a href="<?php echo $this->html->url('/Authentications') ?>" class="dropdown-toggle">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text"> Authentications </span>
							
						</a>
					</li>
			
					<li class="hover">
						<a href="<?php echo $this->html->url('/Designations/') ?>" class="dropdown-toggle">
							<i class="menu-icon fa fa-list"></i>
							<span class="menu-text"> Designations </span>

							<b class="arrow fa fa-angle-right"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="<?php echo $this->html->url('/Designations/') ?>">
									<i class="menu-icon fa fa-caret-right"></i>
									List Designations
								</a>
								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="<?php echo $this->html->url('/Designations/add') ?>">
									<i class="menu-icon fa fa-caret-right"></i>
									Add Designations
								</a>
								<b class="arrow"></b>
							</li>
							
						</ul>
					</li>

					<li class="hover">
						<a href="<?php echo $this->html->url('/Branches/') ?>" class="dropdown-toggle">
							<i class="menu-icon fa fa-pencil-square-o"></i>
							<span class="menu-text"> Branches </span>
							<b class="arrow fa fa-angle-right"></b>
						</a>
						<b class="arrow"></b>
						<ul class="submenu">
							<li class="">
								<a href="<?php echo $this->html->url('/Branches/') ?>">
									<i class="menu-icon fa fa-caret-right"></i>
									List Branches
								</a>
								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo $this->html->url('/Branches/add') ?>">
									<i class="menu-icon fa fa-caret-right"></i>
									Add Branch
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
                    
					<li class="hover">
						<a href="<?php echo $this->html->url('/Users/usersList') ?>">
									<i class="menu-icon fa fa-pencil-square-o"></i>
									<span class="menu-text"> Employees </span>
									<b class="arrow fa fa-angle-right"></b>
						</a>
						<b class="arrow"></b>
						 <ul class="submenu">
						 	 <li class="">
								
								<a href="<?php echo $this->html->url('/Users/add') ?>">
								<i class="menu-icon fa fa-caret-right"></i>
								Add Employee</a>
								<b class="arrow"></b>
							</li>
							 <li class="">
							     <a href="<?php echo $this->html->url('/Users/usersList/') ?>">
								 <i class="menu-icon fa fa-caret-right"></i>
								 List Employees</a>
							 <b class="arrow"></b>
							 </li>
                             <li class="">
							     <a href="<?php echo $this->html->url('/Users/map_view') ?>">
								 <i class="menu-icon fa fa-caret-right"></i>
								View on Map</a>
							 <b class="arrow"></b>
							 </li>
						</ul>
					</li>
                    
                    <li class="hover">
						<a href="<?php echo $this->html->url('') ?>">
									<i class="menu-icon fa fa-pencil-square-o"></i>
									<span class="menu-text"> Retailer </span>
									<b class="arrow fa fa-angle-right"></b>
						</a>
						<b class="arrow"></b>
						 <ul class="submenu">
						 	 <li class="">
								
								<a href="<?php echo $this->html->url('/Retailers/add') ?>">
								<i class="menu-icon fa fa-caret-right"></i>
								Add Retailer</a>
								<b class="arrow"></b>
							</li>
							 <li class="">
							     <a href="<?php echo $this->html->url('/Retailers') ?>">
								 <i class="menu-icon fa fa-caret-right"></i>
								 List Retailer</a>
							 <b class="arrow"></b>
							 </li>
                             <li class="">
							     <a href="<?php echo $this->html->url('/Retailers/map_view') ?>">
								 <i class="menu-icon fa fa-caret-right"></i>
								View on Map</a>
							 <b class="arrow"></b>
							 </li>
						</ul>
					</li>
                    <li class="hover">
						<a href="<?php echo $this->html->url('') ?>">
									<i class="menu-icon fa fa-pencil-square-o"></i>
									<span class="menu-text">Product</span>
									<b class="arrow fa fa-angle-right"></b>
						</a>
						<b class="arrow"></b>
						 <ul class="submenu">
						 	 <li class="">
								
								<a href="<?php echo $this->html->url('/Products/add') ?>">
								<i class="menu-icon fa fa-caret-right"></i>
								Add Product</a>
								<b class="arrow"></b>
							</li>
							 <li class="">
							     <a href="<?php echo $this->html->url('/Products/listProduct') ?>">
								 <i class="menu-icon fa fa-caret-right"></i>
								 Product list</a>
							 <b class="arrow"></b>
							 </li>
						</ul>
                        <li class="hover">
						<a href="<?php echo $this->html->url('/BtlPromotions/') ?>">
									<i class="menu-icon fa fa-pencil-square-o"></i>
									<span class="menu-text">BTL Permotion</span>
									<b class="arrow fa fa-angle-right"></b>
						</a>
						<b class="arrow"></b>
                        <!--<ul class="submenu">
						 	 <li class="">
								
								<a href="<?php echo $this->html->url('/BtlPromotions/map_view') ?>">
								<i class="menu-icon fa fa-caret-right"></i>
								Map View</a>
								<b class="arrow"></b>
							</li>
                            </ul>-->
                        </li>
                        <li class="hover">
						<a href="<?php echo $this->html->url('/Users/track') ?>">
									<i class="menu-icon fa fa-pencil-square-o"></i>
									<span class="menu-text">Track User Location</span>
									<b class="arrow fa fa-angle-right"></b>
						</a>
						<b class="arrow"></b>
                        </li>
                        
					</li>
					<li class="">
						<a href="<?php echo $this->html->url('/Orders/') ?>"> 
							<i class="menu-icon fa fa-pencil-square-o"></i>
							<span class="menu-text">Order List</span></a>
						</a>

						<b class="arrow"></b>
					</li>
					
				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>