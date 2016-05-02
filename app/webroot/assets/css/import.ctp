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
        
 

<?php 
if(@$permissions['perm_add'] != 1 || $this->Session->read('user.User.role_id') == 0){ ?>

 <?php if(isset($message)){
 echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class=ace-icon fa fa-check></i>$message</strong></div>";}?>

			
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<h4 class="header green clearfix">
			Add Products
			<span class="block pull-right">
			</span>
		</h4>
		

<div class="page-header">
						<h1>
							Dropzone.js
							<small>
								<i class="ace-icon fa fa-angle-double-right"></i>
								Drag &amp; drop file upload with image preview
							</small>
						</h1>
					</div><!-- /.page-header -->

					<div class="row">
						<div class="col-xs-12">
							<!-- PAGE CONTENT BEGINS -->
							<div>
								<form action="../dummy.html" class="dropzone" id="dropzone">
									<div class="fallback">
										<input name="file" type="file" multiple="" />
									</div>
								</form>
							</div><!-- PAGE CONTENT ENDS -->
						</div><!-- /.col -->
					</div><!-- /.row -->
	</div><!-- /.col -->
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