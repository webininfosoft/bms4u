<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCX1SGbjQbXFBLjBa-6BQtE6TWZ-Vi6oGI&sensor=false"></script>
<script type="text/javascript" src="<?php echo $this->html->url('/');?>js/StyledMarker.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>


<?php 
if(@$permissions['perm_add'] != 1 || $this->Session->read('user.User.role_id') == 0){ ?>	
<div class="col-sm-12">

	<?php foreach($arrOrders as $val) {?>
    
    
<div class="row">
								<div class="col-sm-10 col-sm-offset-1">
									<!-- #section:pages/invoice -->
									<div class="widget-box transparent">
										<div class="widget-header widget-header-large">
											<h3 class="widget-title grey lighter">
												<i class="ace-icon fa fa-leaf green"></i>
												Order Details 
                                                
											<a href="#" class="btn btn-app btn-info btn-sm no-radius" style="margin-top:20px;">
											<i class="ace-icon fa fa-envelope bigger-200"></i>
                                            SendMail
											
										</a>
									
                                       
                                        <button class="btn btn-app btn-light btn-xs" style="margin-top:30px;">
											<i class="ace-icon fa fa-print bigger-160"></i>
											Print
										</button>
                                        <button class="btn btn-app btn-grey btn-xs radius-4" style="margin-top:30px;">
											<i class="ace-icon fa fa-floppy-o bigger-160"></i>

											Save
											<span class="badge badge-transparent">
												<i class="light-red ace-icon fa fa-asterisk"></i>
											</span>
										</button>
											</h3>

											<!-- #section:pages/invoice.info -->
											<div class="widget-toolbar no-border invoice-info">
												<span class="invoice-info-label">Order ID:</span>
												<span class="red"><?php echo $val['o']['id']  ?></span>

												<br>
												<span class="invoice-info-label">Date:</span> 
												<span class="blue"><?php echo $val['o']['date_time']  ?></span>
											</div>

											<div class="widget-toolbar hidden-480">

												<?php echo $this->Html->link(__('PDF'), array('action' => 'invoice', 'ext' => 'pdf', $val['o']['id'])); ?>
													<i class="ace-icon fa fa-print"></i>
												
											</div>

											<!-- /section:pages/invoice.info -->
										</div>

										<div class="widget-body">
											<div class="widget-main padding-24">
												<div class="row">
													<div class="col-sm-6">
														<div class="row">
															<div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
																<b>Order Info</b>
															</div>
														</div>

														<div class="row">
															<ul class="list-unstyled spaced">
																<li>
																	<i class="ace-icon fa fa-caret-right blue"></i>Retailer Name : &nbsp; <?php echo $val['up']['shop_name'] ?>
																</li>

																<li>
																	<i class="ace-icon fa fa-caret-right blue"></i>Sales Executive : &nbsp; <?php echo $val['o']['fosname']?>
																</li>

																<li>
																	<i class="ace-icon fa fa-caret-right blue"></i>Phone : <?php echo $val['up']['phone']  ?>
																</li>

																	<li>
																	<i class="ace-icon fa fa-caret-right blue"></i>Email : <?php echo $val['up']['email']  ?>
																</li>


																<li class="divider"></li>

																<li>
																	<i class="ace-icon fa fa-caret-right blue"></i>
																	Paymant Info
																</li>
															</ul>
														</div>
													</div><!-- /.col -->

													<div class="col-sm-6">
														<div class="row">
															<div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
																<b>Address Info</b>
															</div>
														</div>

														<div>
															<ul class="list-unstyled  spaced">
																<li>
																	<i class="ace-icon fa fa-caret-right green"></i>Address  : <?php echo $val['up']['address']; ?>
																</li>

																<!--<li>
																	<i class="ace-icon fa fa-caret-right green"></i>Zip Code
																</li>

																<li>
																	<i class="ace-icon fa fa-caret-right green"></i>State, Country
																</li>

																<li class="divider"></li>

																<li>
																	<i class="ace-icon fa fa-caret-right green"></i>
																	Contact Info
																</li>-->
															</ul>
														</div>
													</div><!-- /.col -->
												</div><!-- /.row -->

												<div class="space"></div>

												<div>
													<table class="table table-striped table-bordered">
														<thead>
															<tr>
																<th>#</th>
																<th>Product</th>
																<th class="hidden-xs">Price</th>
																<th class="hidden-480">Quantity</th>
                                                                <th>Total</th>
                                                                </tr>
														   </thead>
                                                            <tbody>
                                                         
                                                              <?php foreach($productData as $pdata){ ?>
                                                             
															<tr>
                                                          
                                                            <td>
                                                            <?php echo $pdata['id']; ?>
                                                              </td>
                                                              <td>
                                                               <?php echo $pdata['name'];?>
                                                              </td>
                                                              <td>
                                                              <?php echo $pdata['price']?>
                                                              </td>
                                                              
                                                          
                                                               <td class="hidden-xs"><?php echo $pdata['qty']?></td>
                                                                <td><?php echo $pdata['total']?></td>
                                                            </tr>
                                                            <?php }?>
                                                            
                                                                 
                                                           <tr>
                                                           <td colspan="3" align="right"></td>
                                                           <td align="right">Order Amount</td>
                                                           <td> <?php echo $orderamount; ?></td>
                                                           </tr>
                                                           <tr>
                                                             <td colspan="4" align="right">Discount</td>
                                                             <td><?php echo $val['o']['discount'] ;?></td>
                                                            </tr>
                                                             <tr>
                                                             <td colspan="4" align="right">Taxes</td>
                                                             <td><?php echo $val['o']['taxes'] ;?></td>
                                                             </tr>
                                                           <tr>
                                                             <td colspan="4" align="right">Old Credit</td>
                                                             <td><?php echo $val['o']['credit'] ;?></td>
                                                             </tr>
                                                          <tr>
                                                          <td colspan="4" align="right">Net Amount</td>
                                                          <td><?php echo $netamount?></td>
                                                          </tr>
                                                             
                                                            <tr>
                                                            <td colspan="4" align="right">Cheque Paid</td>
                                                            <td><?php echo $val['o']['cheque_paid']; ?></td>
                                                            </tr>
                                                            
                                                            <tr><td colspan="4" align="right">Cash Paid</td>
															<td><?php echo $val['o']['cash_paid'];?></td>
                                                            </tr>
                                                            
                                                           </tbody>
													</table>
												</div>
                                                <?php }?>

												<div class="hr hr8 hr-double hr-dotted"></div>

												<div class="row">
													<div class="col-sm-5 pull-right">
														<h4 class="pull-right">
															Balance :
															<span class="red"><?php echo $totalBalence ?></span>
														</h4>
													</div>
													<div class="col-sm-7 pull-left"><b>Remarks:</b> <?php echo $val['o']['remarks']; ?></div>
												</div>

												<div class="space-6"></div>
												<div class="well">
													Thank you for choosing Webin Infosoft Pvt. Ltd. , We believe you will be satisfied by our services.
												</div>
											</div>
										</div>
									</div>

									<!-- /section:pages/invoice -->
								</div>
							</div>
									
                                     
                                   
</div>

	<?php } 
	else { ?>
		<article class="module width_full" style="width: 75%;float: right;margin: 0px;margin-top:10px;">
		<header><h3 style="color: #1F1F20;text-transform: uppercase;text-shadow: 0 1px 0 #fff;font-size: 13px;margin-left: 10px;">Restricted This Page</h3></header>
					<div style="text-align:center">
						<img src="<?php echo $this->html->url('/img/restriction.jpg')?>" width="300"><br>Sorry, You are not autorized to access this page
					</div>
		</article>			
	<?php } ?>

