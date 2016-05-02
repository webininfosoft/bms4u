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
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/select2.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/ace.min.css"  />

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
	</head>

<body class="no-skin">
	
	<div class="main-container" id="main-container">
		<script type="text/javascript">
			try{ace.settings.check('main-container' , 'fixed')}catch(e){}
		</script>
		
		<div class="main-content">
				
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
		<div class="footer">
				<?php echo $this->element('footer'); ?>
		</div>

		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
			<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
		</a>
    </div>
<!-- basic scripts -->

		<script src="<?php echo $this->html->url('/');?>assets/js/fuelux/fuelux.wizard.min.js" ></script>
<script src="<?php echo $this->html->url('/');?>assets/js/jquery.validate.min.js" ></script>
<script src="<?php echo $this->html->url('/');?>assets/js/additional-methods.min.js" ></script>
<script src="<?php echo $this->html->url('/');?>assets/js/bootbox.min.js" ></script>
<script src="<?php echo $this->html->url('/');?>assets/js/jquery.maskedinput.min.js" ></script>
<script src="<?php echo $this->html->url('/');?>assets/js/select2.min.js" ></script>

		
		

		<!-- ace scripts -->
		<script src="<?php echo $this->html->url('/');?>assets/js/ace-elements.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/ace.min.js" ></script>


<script type="text/javascript">
			jQuery(function($) {
			
				
				
			
				var $validation = false;
				$('#fuelux-wizard')
				.ace_wizard({
					//step: 2 //optional argument. wizard will jump to step "2" at first
				})
				.on('change' , function(e, info){
					if(info.step == 1 && $validation) {
						if(!$('#validation-form').valid()) return false;
					}
				})
				.on('finished', function(e) {
					bootbox.dialog({
						message: "Thank you! Your information was successfully saved!", 
						buttons: {
							"success" : {
								"label" : "OK",
								"className" : "btn-sm btn-primary"
							}
						}
					});
				}).on('stepclick', function(e){
					//e.preventDefault();//this will prevent clicking and selecting steps
				});
			
			
				//jump to a step
				$('#step-jump').on('click', function() {
					var wizard = $('#fuelux-wizard').data('wizard')
					wizard.currentStep = 3;
					wizard.setState();
				})
				//determine selected step
				//wizard.selectedItem().step
			
			
			
				//hide or show the other form which requires validation
				//this is for demo only, you usullay want just one form in your application
				$('#skip-validation').removeAttr('checked').on('click', function(){
					$validation = this.checked;
					if(this.checked) {
						$('#sample-form').hide();
						$('#validation-form').removeClass('hide');
					}
					else {
						$('#validation-form').addClass('hide');
						$('#sample-form').show();
					}
				})
			
			
			
				//documentation : http://docs.jquery.com/Plugins/Validation/validate
			
			
				$.mask.definitions['~']='[+-]';
				$('#phone').mask('(999) 999-9999');
			
				jQuery.validator.addMethod("phone", function (value, element) {
					return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
				}, "Enter a valid phone number.");
			
				$('#validation-form').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: false,
					rules: {
						email: {
							required: true,
							email:true
						},
						password: {
							required: true,
							minlength: 5
						},
						password2: {
							required: true,
							minlength: 5,
							equalTo: "#password"
						},
						name: {
							required: true
						},
						phone: {
							required: true,
							phone: 'required'
						},
						agree:{
							
							agree: 'required'
						},
						comment: {
							required: true
						},
						date: {
							required: true,
							date: true
						},
						state: {
							required: true
						},
						platform: {
							required: true
						},
						subscription: {
							required: true
						},
						gender: 'required',
						agree: 'required'
					},
			
					messages: {
						email: {
							required: "Please provide a valid email.",
							email: "Please provide a valid email."
						},
						password: {
							required: "Please specify a password.",
							minlength: "Please specify a secure password."
						},
						subscription: "Please choose at least one option",
						gender: "Please choose gender",
						agree: "Please accept our policy"
					},
			
			
					highlight: function (e) {
						$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
					},
			
					success: function (e) {
						$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
						$(e).remove();
					},
			
					errorPlacement: function (error, element) {
						if(element.is(':checkbox') || element.is(':radio')) {
							var controls = element.closest('div[class*="col-"]');
							if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
							else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
						}
						else if(element.is('.select2')) {
							error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
						}
						else if(element.is('.chosen-select')) {
							error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
						}
						else error.insertAfter(element.parent());
					},
			
					submitHandler: function (form) {
					},
					invalidHandler: function (form) {
					}
				});
			
				
				
				
				$('#modal-wizard .modal-header').ace_wizard();
				$('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');
				
				
				
			})
		</script>									
		</script>									
	</body>
</html>

