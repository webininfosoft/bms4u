<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo $title_for_layout; ?></title>

		<meta name="description" content="3 styles with inline editable feature" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>css/font-awesome/4.0.3/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/datepicker.css" />
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/bootstrap-editable.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/ace.min.css"  />
        <link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/ace-fonts.css"  />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/ace-part2.min.css" />
		<![endif]-->
		
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>css/style.css"  />
		
		<!-- ace settings handler -->
		<script src="<?php echo $this->html->url('/');?>assets/js/ace-extra.min.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?php echo $this->html->url('/');?>assets/js/html5shiv.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/respond.min.js" ></script>
		<![endif]-->
		
		<!--[if !IE]> -->
		<script src="<?php echo $this->html->url('/');?>js/jquery.min.js" ></script>
		<!-- <![endif]-->

		<!--[if IE]>
			<script src="<?php echo $this->html->url('/');?>js/1.11.0/jquery.min.js" ></script>
		<![endif]-->

		

		<!--[if IE]>
		<script type="text/javascript">
		 window.jQuery || document.write("<script src='<?php echo $this->html->url('/');?>assets/js/jquery1x.min.js'>"+"<"+"/script>");
		</script>
		<![endif]-->
        <script>
			var strRoot="";
		</script>
	</head>

<body class="no-skin">
	<?php echo $this->element('main_header'); ?>
	
	<div class="main-container" id="main-container">
		<script type="text/javascript">
			try{ace.settings.check('main-container' , 'fixed')}catch(e){}
		</script>
		<?php echo $this->element('sidebar_login'); ?>
       
		<div class="main-content">
				
				<?php echo $this->element('breadcrumb'); ?>
				
				<div class="page-content">
					<div class="page-header">
						<h1>
						<?php echo $title_for_layout; ?>
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							<?php echo @$smallinfo;?>
						</small>
						</h1>
					</div><!-- /.page-header -->
					<?php echo $this->fetch('content'); ?>
				</div>
		</div>
		
		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
			<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
		</a>
    </div>
<!-- basic scripts -->

		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo $this->html->url('/');?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo $this->html->url('/');?>js/bootstrap/3.1.1/js/bootstrap.min.js" ></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="<?php echo $this->html->url('/');?>assets/js/excanvas.min.js" ></script>
		<![endif]-->
		
		<script src="<?php echo $this->html->url('/');?>assets/js/jquery-ui.custom.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/jquery.ui.touch-punch.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/jquery.gritter.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/bootbox.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/jquery.easypiechart.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/date-time/bootstrap-datepicker.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/jquery.hotkeys.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/bootstrap-wysiwyg.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/select2.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/fuelux/fuelux.spinner.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/x-editable/bootstrap-editable.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/x-editable/ace-editable.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/jquery.maskedinput.min.js" ></script>

		<!-- ace scripts -->
		<script src="<?php echo $this->html->url('/');?>assets/js/ace-elements.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/ace.min.js" ></script>
		
	</body>
</html>