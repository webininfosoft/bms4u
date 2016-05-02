<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCX1SGbjQbXFBLjBa-6BQtE6TWZ-Vi6oGI&sensor=false"></script>
<script type="text/javascript" src="<?php echo $this->html->url('/');?>js/StyledMarker.js"></script>
<script>
var rootpath='/bms';
var webroot='<?php echo $this->html->url('/');?>';

function load(address,latitude,longitude) 
{	
	var image = webroot+'img/beachflag.png'
	image = "http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png";

	if(address)
	{
		

		var mapProp = {
			center:new google.maps.LatLng(latitude,longitude),
			zoom:15,
			mapTypeId:google.maps.MapTypeId.ROADMAP
			  };

			var map=new google.maps.Map(document.getElementById("google_map"),mapProp);
			

			var marker=new google.maps.Marker({
			  position:new google.maps.LatLng(latitude,longitude),
				icon:image
			  });

			marker.setMap(map);
			
			var styleMaker1 = new StyledMarker({styleIcon:new StyledIcon(StyledIconTypes.BUBBLE,{color:"#04b3e9",text:address}),position:new google.maps.LatLng(latitude,longitude),map:map});
			
	}
	else
	{	

		if (navigator.geolocation) {
		     navigator.geolocation.getCurrentPosition(function (position) {
			 initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		        
			 var mapProp = {
					zoom:15,
					mapTypeId:google.maps.MapTypeId.ROADMAP
			  };

			var map=new google.maps.Map(document.getElementById("google_map"),mapProp);

			

			var marker=new google.maps.Marker({
			  position:initialLocation,
			  icon:image
			  });

			marker.setMap(map);
			
			var styleIconClass = new StyledIcon(StyledIconTypes.CLASS,{color:"#ff0000"});
			var styleMaker1 = new StyledMarker({styleIcon:new StyledIcon(StyledIconTypes.BUBBLE,{color:"#04b3e9",text:"Current Location"}),position:initialLocation,map:map});
			 
			 map.setCenter(initialLocation);
		     });
		 }

	
	}	 
}

function showAddress() 
{			
	var address=$('#address').val();
	var city=$('#city').val();
	var country="India";
	var state=$('#state').val();
	if(address || city || state)
	address=address+" "+city+" "+state+" "+country;

	address = address.replace('-',' ');


	var geo = new google.maps.Geocoder;
	geo.geocode({'address':address},function(results, status){

		if (status == google.maps.GeocoderStatus.OK) 
		{			

			var latitude = results[0].geometry.location.lat();
			var longitude = results[0].geometry.location.lng();	
			$('#lat').val(latitude);
			$('#long').val(longitude);
			load(address,latitude,longitude); 
		}
		else
		{
			load(); 
		}
		
	});
}
$(document).ready(function(){
	var data = $('#address').val();
	if(data)
		showAddress(data);
	else
		showAddress('');
	//loadDesignation($('#parentDesignation').val());Detail
});
</script>
<div id="addDesgnForm">
			<?php if( $message){?>
			<div class="alert alert-block alert-success">
			<p><strong><i class="ace-icon fa fa-check"></i></strong><?php echo $message; ?></p>
			</div>
			<?php }?>

			<?php if( $message1){?>
			<div class="alert alert-block alert-danger">
			<p><strong><i class="ace-icon fa fa-check"></i></strong><?php echo $message1; ?></p>
			</div>
			<?php }?>

	<div class="title">Add Branch Detail</div>
	<div class="form-ct" id="ct-form-ct">
		

		 <form method="post" action="" class="form-m">
                
			<input type="hidden" name="data[Branch][latitude]" id="lat" value="<?php echo $Detail['Branch']['latitude'];?>" />
			<input type="hidden" name="data[Branch][longitude]" id="long" value="<?php echo $Detail['Branch']['longitude'];?>" />
				<input type="hidden" name="data[Branch][company_id]" value="<?php echo $Detail['Branch']['id']; ?>" />
				<ol>
				<li><label class="small">Branch</label><input type="text" class="small-full"  name="data[Branch][first_name]" value="<?php echo $Detail['Branch']['first_name']; ?>" required/>
				</li>
							
			<li>
					<label class="small">Contact Person</label>
					<input type="text" class="small-full"  name="data[Branch][last_name]" value="<?php echo $Detail['Branch']['last_name']; ?>" required />

				</li>
                <li>
					<label class="small">Address</label>
					<textarea id="address" class="small" name="data[Branch][address]" style="border-radius: 4px;border: 2px inset;height: 95px;" id="address"  onblur="showAddress();return false;" ><?php echo $Detail['Branch']['address'];?></textarea>
				</li>
				
				<li>
					<label class="small">Email</label>
					<input type="text" class="small-full"  name="data[Branch][email]" value="<?php echo $Detail['Branch']['email']; ?>" required />
				</li>
				<li>
					<label class="small">Phone</label>
					<input type="text" class="small-full"  name="data[Branch][phone]" value="<?php echo $Detail['Branch']['phone']; ?>" required />
					<span id="error" style="color: Red; display: none">*Enter Only Integer Value</span>

				</li>
				<li>
					<label class="small">State</label>
					<select class="small-full" id="state"  name="data[Branch][state]" value="<?php echo $Detail['Branch']['state']; ?>" required />
				<option value="">----Select State----</option>
<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option><option value="Andhra Pradesh">Andhra Pradesh</option><option value="Arunachal Pradesh">Arunachal Pradesh</option><option value="Assam">Assam</option><option value="Bihar">Bihar</option><option value="Chandigarh">Chandigarh</option><option value="Chhattisgarh">Chhattisgarh</option><option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option><option value="Daman and Diu">Daman and Diu</option><option value="Delhi">Delhi</option><option value="Goa">Goa</option><option value="Gujarat">Gujarat</option><option value="Haryana">Haryana</option><option value="Himachal Pradesh">Himachal Pradesh</option><option value="Jammu and Kashmir">Jammu and Kashmir</option><option value="Jharkhand">Jharkhand</option><option value="Karnataka">Karnataka</option><option value="Kerala">Kerala</option><option value="Lakshadweep">Lakshadweep</option><option value="Madhya Pradesh">Madhya Pradesh</option><option value="Maharashtra">Maharashtra</option><option value="Manipur">Manipur</option><option value="Meghalaya">Meghalaya</option><option value="Mizoram">Mizoram</option><option value="Nagaland">Nagaland</option><option value="Orissa">Orissa</option><option value="Pondicherry">Pondicherry</option><option value="Punjab">Punjab</option><option value="Rajasthan">Rajasthan</option><option value="Sikkim">Sikkim</option><option value="Tamil Nadu">Tamil Nadu</option><option value="Tripura">Tripura</option><option value="Uttaranchal">Uttaranchal</option><option value="Uttar Pradesh">Uttar Pradesh</option><option value="West Bengal">West Bengal</option>


					</select>
				</li>
				<li>
					<label class="small">City</label>
					<input type="text" class="small-full"  id="city" name="data[Branch][city]" value="<?php echo $Detail['Branch']['city']; ?>" required />
				</li>
				
				
				
				
				   <li><label class="small"></label>
				   <?php if($Detail['Branch']['id']){?>
						<input type="submit" class="login" value="Update">
				   <?php }else{?>
							<input type="submit" class="login" value="Submit">
				   <?php }?>
				   
				   </li>
				</ol>
			</form>

	</div>
</div>

	</div>
		<div class="map" id="google_map" style="width:55%; height:600px;margin-right:10px;"></div>

</div>