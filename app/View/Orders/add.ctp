<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset="utf-8">


<?php 
if(@$permissions['perm_add'] != 1 || $this->Session->read('user.User.role_id') == 0){ ?>

 <?php if(isset($message)){
 echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class=ace-icon fa fa-check></i>$message</strong></div>";}?>

			<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<h4 class="header green clearfix">
			Place Order
			<span class="block pull-right">
			</span>
		</h4>
		</div>
        <div class="step1">
      <form method="post" action="" class="form-m" id="amount" name="myform">
		<input type="hidden" name="data[Order][company_id]" value="<?php echo $Detail['User']['company_id'] ?>" />
        <input type="hidden" name="data[Order][user_id]" value="<?php echo $Detail['User']['id'] ?>" />
         <label>Retailer</label>
				<select name="data[Order][retailer_id]" id="retailer" style="margin-left:30px;" required >
				<option value='0'>----Select Retailer------</option>
                
                   <?php while(list($key,$val)=each($Retailer)){ ?>
								<option value="<?php echo $val['retailers']['id']; ?>"><?php echo $val['retailers']['shop_name'];?></option>
							<?php } ?>
                   
				    </select>
                
        
   <div style="margin-top:20px;">
	  <table class="table table-striped table-bordered">
		<thead>
            <tr>
                <th class="center">#</th>
                <th>Product</th>
                <th class="hidden-xs">Price</th>
                <th class="hidden-480">Quantitiy</th>
            </tr>
        </thead>

				
				<?php foreach($arrProduct as $val) {?>
			    <tr>
                <td>
					 <input type="checkbox" name="data[Order][product_ids][]" value="<?php echo $val['Product']['id']; ?>" /></td>
                <td>
                  <?php echo $val['Product']['name'];?>
                </td>
                <td>
				<span id="price"><?php echo $val['Product']['price'] ?></span>
                <input type="hidden" name="data[Order][prices][]" value="<?php echo $val['Product']['price'] ?>" />
                </td>
                <td><input type="text" name="data[Order][qty][]" id="qty"></td>
                </tr>
                            <?php } ?>
 </tbody>
     </table>
</div>
</div>

<div class="clearfix form-actions">
									<div class="col-md-offset-3 col-md-9">
										<button class="btn btn-info" type="submit">
											<i class="ace-icon fa fa-check bigger-110"></i>
											Submit
										</button>
                                    

										&nbsp; &nbsp; &nbsp;
										<button class="btn" type="reset">
											<i class="ace-icon fa fa-undo bigger-110"></i>
											Reset
										</button>
									</div>
								</div>
							</form>
                           

		<script type="text/javascript">
			var $path_assets = "<?php echo $this->html->url('/');?>assets";//this will be used in loading jQuery UI if needed!
		</script>

		<!-- PAGE CONTENT ENDS -->
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