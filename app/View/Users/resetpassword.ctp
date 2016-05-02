<script>
function checkPasswordMatch() {
    var password = $("#pass1").val();
    var confirmPassword = $("#pass2").val();

    if (password != confirmPassword)
        $("#msg1").html("Passwords do not match!");
    else
        $("#msg1").html("Passwords match.");
}

$(document).ready(function () {
   $("#txtConfirmPassword").keyup(checkPasswordMatch);
});
</script>


<div class="col-xs-10">
							<!-- PAGE CONTENT BEGINS -->
							<h4 class="lighter">
								<i class="ace-icon fa fa-hand-o-right icon-animated-hand-pointer blue"></i>
								<a href="#modal-wizard" data-toggle="modal" class="pink">AVDHI CR </a>
							</h4>

							<div class="hr hr-18 hr-double dotted"></div>

							<div class="widget-box" style="width:600px; margin-left:450px;">
								<div class="widget-header widget-header-blue widget-header-flat">
									<h4 class="widget-title lighter">Enter Login information</h4>

									
								</div>

								<div class="widget-body">
									<div class="widget-main">
										


										<div class="step-content pos-rel" id="step-container">

<div class="step-pane active" id="step1">
												<h3 class="lighter block green" style="margin-top:-10px;"></h3>



												<form class="form-horizontal"  action="" method="post" style="margin-left:40px;" id="form1">
													<div class="form-group">
														<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">New Password</label>

														<div class="col-xs-12 col-sm-9">
															<div class="clearfix">
																
                                                                <input type="text" required title="newpass" Placeholder="New Password" name="newpass" size="45" id="pass1" />
															</div>
														</div>
													</div>


													<div class="form-group">
														<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="password">Confirm Password:</label>

														<div class="col-xs-12 col-sm-9">
															<div class="clearfix">
												
                                                                <input type="text" required title="cPassword" name="cpassword" onkeyup="checkPasswordMatch()" Placeholder="Confirm Password" id="pass2" size="45" /><br />
                                                                <span id="msg1"></span>
                                                             
															</div>
                                                          
														</div>
                                                        
                                                        <div class="form-group">
														

														<div class="col-xs-7 col-sm-7">
															<div class="clearfix" style="margin-left:70px; margin-top:30px;">
												         
                                                           <button id="loading-btn"  type="submit" class="btn btn-success"  data-loading-text="Loading...">Login</button>
                                                           
															</div>
                                                            
                                                          
														</div>
                                                
													
												          
                                              
													</div>

													
													</div>
												</form>
                                                

                                                
											</div>
                                            
 <!-- /.widget-body -->
</div>
<!-- PAGE CONTENT ENDS -->
						</div>
                        </div>
                        </div></div>
  