<div class="page-content">
					



					<div class="page-header">
						<h1>
					<img src="<?php echo $this->html->url('/');?>img/AVDHI5.png"  height="70" width="250"/>
							
						</h1>
					</div><!-- /.page-header -->

					<div class="row">
						<div class="col-xs-12">
							
							

							

							<div class="widget-box">
								<div class="widget-header widget-header-blue widget-header-flat">
									<h4 class="widget-title lighter">Compnay Activation Process</h4>

										
										</label>
									</div>
								</div>

								<div class="widget-body">
									<div class="widget-main">
										<div id="fuelux-wizard" data-target="#step-container">
											<ul class="wizard-steps">
												<li data-target="#step1" class="active">
													<span class="step">1</span>
													<span class="title">User Activation</span>
												</li>

												<li data-target="#step2">
													<span class="step">2</span>
													<span class="title">Company Information</span>
												</li>
                                                <li data-target="#step3">
													<span class="step">3</span>
													<span class="title">Modul Access</span>
												</li>

												<li data-target="#step4">
													<span class="step">4</span>
													<span class="title">Finish</span>
												</li>

																							</ul>
										</div>

										

										<div class="step-content pos-rel" id="step-container">
											<div class="step-pane active" id="step1">
												<h3 class="lighter block green" style="margin-left:18%;">Enter the Activation information</h3>

												

												<form class="form-horizontal" id="validation-form" action="<?php echo $this->html->url('/');?>userTokens/index" method="post">
													<div class="form-group">
														<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Username:</label>

														<div class="col-xs-12 col-sm-9">
															<div class="clearfix">
																<input type="text" name="user_name" id="username" class="col-xs-12 col-sm-6" />
															</div>
														</div>
													</div>

													<div class="space-2"></div>

													<div class="form-group">
														<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="password">Password:</label>

														<div class="col-xs-12 col-sm-9">
															<div class="clearfix">
																<input type="password" name="user_password" id="password" class="col-xs-12 col-sm-6" />
															</div>
														</div>
													</div>

													

													<div class="form-group">
														<div class="col-xs-12 col-sm-4 col-sm-offset-3">
															<label>
																<input type="checkbox" required name="terms" checked>
																<span class="lbl"> I accept the policy</span>
															</label>
														</div>
													</div>
												</form>
											</div>

											<div class="step-pane" id="step2">
	<h3 class="lighter block green">Enter the following information</h3>
    <form class="form-horizontal" id="validation-form1" action="<?php echo $this->html->url('/');?>userTokens/registration" method="post">
    <?php echo $message; ?>
                                                 <div class="form-group">
														<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Username</label>

														<div class="col-xs-12 col-sm-9">
															<div class="clearfix">
																<input type="text" name="user_name" id="user_name" class="col-xs-12 col-sm-7" />
															</div>
														</div>
													</div>

												

													<div class="form-group">
														<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="password">Password:</label>

														<div class="col-xs-12 col-sm-9">
															<div class="clearfix">
																<input type="password" name="user_password" id="user_password" class="col-xs-12 col-sm-7" />
															</div>
														</div>
													</div>

											

													<div class="form-group">
														<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="password2">Confirm Password:</label>

														<div class="col-xs-12 col-sm-9">
															<div class="clearfix">
																<input type="password" name="confirm_password" id="confirm_password" class="col-xs-12 col-sm-7" />
															</div>
														</div>
													</div>
													
<hr />
                                                        <div class="form-group">
														<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Email Address:</label>

														<div class="col-xs-12 col-sm-9">
															<div class="clearfix">
																<input type="email" name="email" id="email" class="col-xs-12 col-sm-7" />
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">Company Name:</label>

														<div class="col-xs-12 col-sm-9">
															<div class="clearfix">
																<input type="text" id="first_name" placeholder="Enter company name" name="first_name" class="col-xs-12 col-sm-6">
															</div>
														</div>
													</div>

													<div class="space-2"></div>

													<div class="form-group">
														<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="phone">Mobile Number:</label>

														<div class="col-xs-12 col-sm-9">
															<div class="input-group" style=" margin-right:30px;">
																<span class="input-group-addon">
																	<i class="ace-icon fa fa-phone"></i>
																</span>

																<input type="text" id="phone" name="phone" class="col-xs-12 col-sm-6" style=" margin-right:5px;" placeholder="Enter mobile no">
															</div>
														</div>
													</div>

													<div class="space-2"></div>

													<div class="form-group">
														<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="url">Company URL:</label>

														<div class="col-xs-12 col-sm-9">
															<div class="clearfix">
																<input type="text" id="text" name="url" class="col-xs-12 col-sm-6">
															</div>
														</div>
													</div>

													<div class="hr hr-dotted"></div>

													<div class="form-group">
														<label class="control-label col-xs-12 col-sm-3 no-padding-right">Turn Over</label>

														<div class="col-xs-12 col-sm-9">
															<div>
																<label>
																	<input name="turnover"  id="turnover" value="" type="text" placeholder="Turn Over IN $" class="ace" size="50">
																	
																</label>
															</div>

														
														</div>
													</div>

											

													<div class="form-group">
														<label class="control-label col-xs-12 col-sm-3 no-padding-right">Establish Date</label>

														<div class="col-xs-12 col-sm-9">
															<div>
																<label class="line-height-1 blue">
																	<input name="establishdate" value="" id="establishdate" type="date" class="ace" size="50" style=" width:320px;">
																	
																</label>
															</div>

															
														</div>
													</div>


													<div class="form-group">
													

														
													</div>


													<div class="form-group">
														

													</div>


													<div class="form-group">
														<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="comment">Address</label>

														<div class="col-xs-12 col-sm-9">
															<div class="clearfix">
																<textarea class="input-xlarge" cols="50" rows="7" name="address" id="address"></textarea>
															</div>
														</div>
													</div>

													<div class="space-8"></div>

													
												</form>
    

											</div>

											<div class="step-pane" id="step3">
												<div class="center">
												<form class="form-horizontal" id="validation-form2" action="<?php echo $this->html->url('/');?>userTokens/companymodule" method="post">
												<input type="hidden"  value="" name="company_id" id="txtcompanyid"/>
   <?php foreach($arrModule as $val) {} ?>
                                                 <div class="col-xs-12">
									<table id="sample-table-1" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th class="center">
													<label class="position-relative">
														<input type="checkbox" class="ace checkall" >
														<span class="lbl"></span>
													</label>
												</th>
												<th>Module</th>
												
	
											</tr>
										</thead>

										<tbody>
                                        <?php foreach($arrModule as $val) {?>
                                        
											<tr>
												<td class="center">
													<label class="position-relative">
														<input type="checkbox" class="ace acechecks" name="module_id[]"  value="<?php echo $val['Module']['slug'] ?>">
														<span class="lbl"></span>
													</label>
												</td>
												<td style="text-align:left;">
												 <?php echo strtoupper($val['Module']['module_name']);?>

												</td>
                                                
												
											</tr>
                                            <?php } ?>
										</tbody>
									</table>
								</div>

										</form>
                                                    
												</div>
											</div>

											<div class="step-pane" id="step4">
												<div class="center">
													<h3 class="green">Congrats!</h3>
													Your account is created Successfully! Click finish to continue!
												</div>
											</div>
										</div>

										<hr />
										<div class="wizard-actions">
											<button class="btn btn-prev">
												<i class="ace-icon fa fa-arrow-left"></i>
												Prev
											</button>

											<button class="btn btn-success btn-next" data-last="Finish">
												Next
												<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
											</button>
										</div>
									</div><!-- /.widget-main -->
								</div><!-- /.widget-body -->
							</div>

							<div id="modal-wizard" class="modal">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header" data-target="#modal-step-contents">
											<ul class="wizard-steps">
												<li data-target="#modal-step1" class="active">
													<span class="step">1</span>
													<span class="title">Validation states</span>
												</li>

												<li data-target="#modal-step2">
													<span class="step">2</span>
													<span class="title">Alerts</span>
												</li>

												<li data-target="#modal-step3">
													<span class="step">3</span>
													<span class="title">Payment Info</span>
												</li>

												
											</ul>
										</div>

										<div class="modal-body step-content" id="modal-step-contents">
											<div class="step-pane active" id="modal-step1">
												<div class="center">
													<h4 class="blue">Step 1</h4>
												</div>
											</div>

											<div class="step-pane" id="modal-step2">
												<div class="center">
													<h4 class="blue">Step 2</h4>
												</div>
											</div>

											<div class="step-pane" id="modal-step3">
												<div class="center">
													<h4 class="blue">Step 3</h4>
												</div>
											</div>

											<div class="step-pane" id="modal-step4">
												<div class="center">
													<h4 class="blue">Step 4</h4>
												</div>
											</div>
										</div>

										<div class="modal-footer wizard-actions">
											<button class="btn btn-sm btn-prev">
												<i class="ace-icon fa fa-arrow-left"></i>
												Prev
											</button>

											<button class="btn btn-success btn-sm btn-next" data-last="Finish">
												Next
												<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
											</button>

											<button class="btn btn-danger btn-sm pull-left" data-dismiss="modal">
												<i class="ace-icon fa fa-times"></i>
												Cancel
											</button>
										</div>
									</div>
								</div>
							</div><!-- PAGE CONTENT ENDS -->
					
<script>

$('.checkall').change(function() {

    if ($(this).is(':checked')) {
        $('.acechecks').prop('checked',true);
    } else {

        $('.acechecks').removeAttr('checked');
    }
});


</script>