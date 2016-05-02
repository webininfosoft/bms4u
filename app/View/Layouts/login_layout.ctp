<!doctype html><!--[if lt IE 7 ]> <html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]> <html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]> <html class="ie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]> <html class="ie ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--><html lang="en"><!--<![endif]-->
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $title_for_layout; ?></title>
		<link rel="stylesheet" href="<?php echo $this->html->url('/css/style.css');?>">
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>css/font-awesome/4.0.3/css/font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/select2.css" />
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/css-family=Open+Sans-400,300.css"/>
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/ace.min.css"  />
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="<?php echo $this->html->url('/');?>css/style.css"  />
		<script src="<?php echo $this->html->url('/');?>assets/js/ace-extra.min.js"></script>
		<!--[if !IE]> -->
		<script src="<?php echo $this->html->url('/');?>js/jquery.min.js" ></script>
		<!-- <![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo $this->html->url('/');?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo $this->html->url('/');?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/fuelux.wizard.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/jquery.validate.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/additional-methods.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/bootbox.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/jquery.maskedinput.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/select2.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/ace-elements.min.js" ></script>
		<script src="<?php echo $this->html->url('/');?>assets/js/ace.min.js"></script>
       		<script src="<?php echo $this->html->url('/');?>js/jquery.form.js"></script>
	        <script>
		   var strRoot="<?php echo $this->html->url('/');?>";
			$(document).ready(function(){$("#for").click(function(){$("#step2").show();});});
		</script>

		<script type="text/javascript">

			jQuery(function($) {
			
				function showLoginResponse(responseText, statusText, xhr, $form)  { 

				if(responseText.response=='success')
					{
						$('#fuelux-wizard').ace_wizard({step:2});
						
						$('.wizard-actions').html('<button class="btn btn-prev"><i class="ace-icon fa fa-arrow-left"></i>Prev</button><button class="btn btn-success btn-next btn-next2" data-last="Finish"id="fn" >Next<i class="ace-icon fa fa-arrow-right icon-on-right"></i></button>');
						
						$( ".btn-next2" ).bind( "click", function() {
								if(!$('#validation-form1').valid()){ return false;}
								else
								{
									$('#validation-form1').submit();
								}
						});
					return true;
					}
				else
					alert(responseText.message);
				
  		
				} 
				
				function showRegistrationResponse(responseText, statusText, xhr, $form)  { 

				if(responseText.response=='success')
					{
						$('#fuelux-wizard').ace_wizard({step:3});
						
						$('.wizard-actions').html('<button class="btn btn-prev"><i class="ace-icon fa fa-arrow-left"></i>Prev</button><button class="btn btn-success btn-next btn-next3" data-last="Finish">Next<i class="ace-icon fa fa-arrow-right icon-on-right"></i></button>');
						
						$('#txtcompanyid').val(responseText.company_id);
						$( ".btn-next3" ).bind( "click", function() {
						
							$('#validation-form2').submit();
								
						});
					return true;
					}
				else
					alert(responseText.message);
		
				   } 
			    
				function showModuleResponse(responseText, statusText, xhr, $form)  { 

				if(responseText.response=='success')
					{
						$('#fuelux-wizard').ace_wizard({step:4});
						
						$('.wizard-actions').html('<button class="btn btn-prev"><i class="ace-icon fa fa-arrow-left"></i>Prev</button><button class="btn btn-success btn-next btn-next4" data-last="Finish">Finish<i class="ace-icon fa fa-arrow-right icon-on-right"></i></button>');
						
						$( ".btn-next4" ).bind( "click", function() {
					           window.location.href=strRoot+ "users/userProfile";	
								
						});
					return true;
					}
				else
					alert(responseText.message);
		
				} 
				//Login Form start
				var options = { 
								target:        '#output1',   // target element(s) to be updated with server response 
								success:       showLoginResponse,  // post-submit callback 
								dataType:  'json'
						 
							};
				$('#validation-form').ajaxForm(options); 
				//Login Form End
				
				//Registration Form start
				var options = { 
								target:        '#output1',   // target element(s) to be updated with server response 
								success:       showRegistrationResponse,  // post-submit callback 
								dataType:  'json'
						 
							};
					
				$('#validation-form1').ajaxForm(options);
			   //Registration Form End
				
				//company module form start
				var options = { 
								target:        '#output1',   // target element(s) to be updated with server response 
								success:       showModuleResponse,  // post-submit callback 
								dataType:  'json'
						 
							};
				$('#validation-form2').ajaxForm(options);
				//company module form end 
			
				
				$('[data-rel=tooltip]').tooltip();
					var $validation = true;
					$('#fuelux-wizard').ace_wizard({}).on('change' , function(e, info)
					{
						if(info.step == 1 && $validation) 
						{
								if(!$('#validation-form').valid())
								{ 
									return false;
								}
								else
								{
									$('#validation-form').submit();
									return false;
								}
						}
						else if(info.step == 2 && $validation) 
						{
							
					
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
			
				
				jQuery.validator.addMethod("phone", function (value, element) {
					return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
				}, "Enter a valid phone number.");
			
				$('#validation-form').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: false,
					rules: {
						username: {
							required: true
						},
						password: {
							required: true
					
						}
						
					},
			
					messages: {
						user_name: {
							required: "Please provide a valid username."
							
						},
						user_password: {
							required: "Please specify a password."
							
						},
				
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
			
			
				$('#validation-form1').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: false,
					rules: {
						
						user_name: {
							required: true
							
						},
						user_password: {
							required: true,	
						},
						confirm_password:{
							required: true,
							equalTo: "#user_password"
						},
						email: {
							required: true,
							email:true
						},
						
						first_name: {
							required: true
						},
						phone: {
							required: true
			
						},
						
						turnover: {
							required: true
							
						},
						
						establishdate: {
							required: true,
							date: true
						},
					   
						address: 'required'
						
					},
			
					messages: {
						username: {
							required: "Please provide a username."
							
						},
						password: {
							required: "Please specify a password."
							
						},
						subscription: "Please choose at least one option",
						address: "Please Specify  Adresss",
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
        
<script>
$(document).ready(function()
{
  $("#for").click(function(){
    $("#form2").show();
  });
});
</script>        
</head>
<body>
	<?php echo $this->fetch('content'); ?>
</body></html>