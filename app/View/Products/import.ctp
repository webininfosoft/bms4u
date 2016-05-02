<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset="utf-8">
<script src="<?php echo $this->html->url('/');?>js/ace-extra.min.js"></script>
<script src="<?php echo $this->html->url('/');?>js/jquery.hotkeys.min.js" ></script>
<script src="<?php echo $this->html->url('/');?>js/bootstrap-wysiwyg.min.js" ></script>
<script src="<?php echo $this->html->url('/');?>js/ace-elements.min.js" ></script>
<script src="<?php echo $this->html->url('/');?>js/ace.min.js" ></script>
<script src="<?php echo $this->html->url('/');?>js/jquery.min.js" ></script>
<script src="<?php echo $this->html->url('/');?>assets/js/bootstrap.min.js" ></script>
<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/dropzone.css" />
<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/ace.min.css" />
<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/ace-fonts.css" />       
 

<?php 
if(@$permissions['perm_add'] != 1 || $this->Session->read('user.User.role_id') == 0){ ?>

 <?php if(isset($message)){
 echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class=ace-icon fa fa-check></i>$message</strong></div>";}?>

			
<div class="row">

							<!-- PAGE CONTENT BEGINS -->
							<div class="col-xs-6">
								<form action="" class="dropzone" id="dropzone" method="post" enctype="multipart/form-data">
									<div class="fallback">
										<input name="xlfile" type="file"  />
                                         
									</div>
                                    <button class="btn btn-app btn-purple btn-sm" type="submit">
											<i class="ace-icon fa fa-cloud-upload bigger-200"></i>
											Upload
										</button>
								</form>
                            
							</div><!-- PAGE CONTENT ENDS -->
                          <div class="col-xs-6 col-sm-3 pricing-box">
									<div class="widget-box widget-color-dark">
										<div class="widget-header">
											<h5 class="widget-title bigger lighter">Basic Package</h5>
										</div>

										<div class="widget-body">
											<div class="widget-main">
                                            <img src="<?php echo $this->html->url('/');?>img/download.jpg" />
											</div>

											<div>
												<a href="<?php echo $this->html->url('/');?>tempUploadData/products.xls" class="btn btn-block btn-inverse">
													<i class="ace-icon fa fa-shopping-cart bigger-110"></i>
													<span>Downlode Sample</span>
												</a>
											</div>
										</div>
									</div>
								</div>
		
</div><!-- /.row -->

	
                    
	
		


	<?php } 
	else { ?>
		<article class="module width_full" style="width: 75%;float: right;margin: 0px;margin-top:10px;">
		<header><h3 style="color: #1F1F20;text-transform: uppercase;text-shadow: 0 1px 0 #fff;font-size: 13px;margin-left: 10px;">Restricted This Page</h3></header>
					<div style="text-align:center">
						<img src="<?php echo $this->html->url('/img/restriction.jpg')?>" width="300"><br>Sorry, You are not autorized to access this page
					</div>
		</article>			
	<?php } ?>