<script>
var rootpath='/bms';
var webroot='<?php echo $this->html->url('/');?>';

$(document).ready(function(){

});
</script>
<style>
.form-ct form ol li label.small{
width:140px !important;
}
.form-ct form ol li input
{
padding:0 !important;
padding-left:2px !important;
}
</style>
<div id="addDesgnForm">
	<div class="title">Update Company Settings </div>
	<div class="form-ct" id="ct-form-ct" style="width:100%;">
		<p style="margin-left: 20px;color: green;font-size: 18px;"><?php echo $msg; ?></p>
		<div style="color: green;font-size: 17px;padding-left: 21px;padding-top: 6px;"><?php echo $message; ?></div>
		<br/> <form method="post" action="" class="form-m">
                
				<input type="hidden" name="data[CompanySetting][id]" value="<?php echo $Detail['CompanySetting']['id']; ?>" />
				<ol>

		                <li>
					<label class="small">Retailer Per Page</label>
					<input type="text" class="small-full"  name="data[CompanySetting][retailer_per_page]" value="<?php echo $Detail['CompanySetting']['retailer_per_page']; ?>"  />
					
				</li>
				
				<li>
					<label class="small">Checkin Time</label>
					<input type="text" class="small-full"  name="data[CompanySetting][tracking_start_time]" value="<?php echo $Detail['CompanySetting']['tracking_start_time']; ?>"  />
				</li>
				<li>
					<label class="small">Checkout Time</label>
					<input type="text" class="small-full"  name="data[CompanySetting][tracking_end_time]" value="<?php echo $Detail['CompanySetting']['tracking_end_time']; ?>"  />


				</li>

				<li>
					<label class="small">Retailer Radius Check Enable</label>
					<input type="checkbox" class="small-full"  id="city" name="data[CompanySetting][retailer_radius_enable]" <?php if($Detail['CompanySetting']['retailer_radius_enable']==1){ ?> Checked<?php }?> />


				</li>
				<li>
					<label class="small">Radius for Retailer(Add/DailyVisit)</label>
					<input type="text" class="small-full"  id="city" name="data[CompanySetting][retailer_radius_check]" value="<?php echo $Detail['CompanySetting']['retailer_radius_check']; ?>"  />
				</li>
				
				
				
				
				   <li><label class="small"></label>
				   		<input type="submit" class="login" value="Update">
				   
				   
				   </li>
				</ol>
			</form>

	</div>
</div>

	</div>
		

</div>