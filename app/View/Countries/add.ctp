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
	//loadDesignation($('#parentDesignation').val());
});
</script>
	
<script>

       var specialKeys = new Array();
       specialKeys.push(8); 
       function IsNumeric(e) 
	   {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementById("error").style.display = ret ? "none" : "inline";
            return ret;
        }
		
	function loadDesignation(data)
	{
	
		var arrDesignation = data.split('&&');
		
		if(arrDesignation[1]!=0)
		{				
			var selectedUser = '<?php echo $selectedUser;?>';
			$.post(rootpath+"/Users/loadDesignation",{'designation_id':arrDesignation[0],'selected':selectedUser},function(result){
				$('.designationTD').html('<label class="small">Select User</label>'+result).show();
				
			});
		}	
		else
			$('.designationTD').html('').hide();
	}
</script>

<?php 
if(@$permissions['perm_add'] != 1 || $this->Session->read('user.User.role_id') == 0){ ?>

<div id="addDesgnForm">
	<div class="title">Add Retailer</div>
	<div class="form-ct" id="ct-form-ct">
		<p style="margin-left: 20px;color: green;font-size: 18px;"><?php echo $msg; ?></p>
		<div style="color: green;font-size: 17px;float: left;padding-left: 95px;padding-top: 6px;"><?php echo $message; ?></div>
		 <form method="post" action="" class="form-m">
	<input type="hidden" name="data[Retailer][id]" value="<?php echo $Detail['Retailer']['id']; ?>" />
				<ol>
				<li>
					<label class="big"><b>Login Information</b></label>
				</li>
				<li>
					<label class="small">Username</label>
					<input type="text" class="small-full"  name="data[Retailer][user_name]" value="" required />

				</li>
				<li>
					<label class="small">Password</label>
					<input type="password" class="small-full"  name="data[Retailer][user_password]" value=""  required />

				</li>
				<li>
					<label class="big"><b>Retailer Information</b></label>
				</li>
				<li>
					<label class="small">First Name</label>
					<input type="text" class="small-full"  name="data[Retailer][first]"  value="<?php echo $Detail['Retailer']['first']; ?>" required />

				</li>
				<li>
					<label class="small">Last Name</label>
					<input type="text" class="small-full"  name="data[Retailer][last_name]" value="<?php echo $Detail['Retailer']['last_name']; ?>" required />

				</li>
               
				<li>
					<label class="small">Email</label>
					<input type="text" class="small-full"  value="<?php echo $Detail['Retailer']['email']; ?>" name="data[Retailer][email]"  required />
				</li>
				<li>
					<label class="small">Phone</label>
					<input type="text" class="small-full"  name="data[Retailer][phone]" value="<?php echo $Detail['Retailer']['phone']; ?>" required />
					<span id="error" style="color: Red; display: none">*Enter Only Integer Value</span>

				</li>
                <li>
					<label class="small">Shop Name</label>
					<input type="text" class="small-full"  name="data[Retailer][shop]" value="<?php echo $Detail['Retailer']['shop']; ?>" required />
					<span id="error" style="color: Red; display: none">*Enter Only Integer Value</span>

				</li>
				<li>
					<label class="small">Country</label>
					
					<select class="small-full"  name="data[Retailer][country]" />
					<option value="">--Select--</option>
                   
                    <option> <?php echo $Country['Retailer']['country']; ?></option>
						</select>
				</li>
				
				<li>
					<label class="small">State</label>
					<select class="small-full" name="data[Retailer][state]">
							<option value=''>----Select State----</option>
							
						</select>
						
				</li>
				<li class="designationTD">
					
					
						
				</li>
				
				<li>
					<label class="small">City</label>
					<select class="small-full" id="state"  name="data[Retailer][city]" value="<?php echo $Detail['Retailer']['city']; ?>"  />
				<option value="">----Select city----</option>
<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option><option value="Andhra Pradesh">Andhra Pradesh</option><option value="Arunachal Pradesh">Arunachal Pradesh</option><option value="Assam">Assam</option><option value="Bihar">Bihar</option><option value="Chandigarh">Chandigarh</option><option value="Chhattisgarh">Chhattisgarh</option><option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option><option value="Daman and Diu">Daman and Diu</option><option value="Delhi">Delhi</option><option value="Goa">Goa</option><option value="Gujarat">Gujarat</option><option value="Haryana">Haryana</option><option value="Himachal Pradesh">Himachal Pradesh</option><option value="Jammu and Kashmir">Jammu and Kashmir</option><option value="Jharkhand">Jharkhand</option><option value="Karnataka">Karnataka</option><option value="Kerala">Kerala</option><option value="Lakshadweep">Lakshadweep</option><option value="Madhya Pradesh">Madhya Pradesh</option><option value="Maharashtra">Maharashtra</option><option value="Manipur">Manipur</option><option value="Meghalaya">Meghalaya</option><option value="Mizoram">Mizoram</option><option value="Nagaland">Nagaland</option><option value="Orissa">Orissa</option><option value="Pondicherry">Pondicherry</option><option value="Punjab">Punjab</option><option value="Rajasthan">Rajasthan</option><option value="Sikkim">Sikkim</option><option value="Tamil Nadu">Tamil Nadu</option><option value="Tripura">Tripura</option><option value="Uttaranchal">Uttaranchal</option><option value="Uttar Pradesh">Uttar Pradesh</option><option value="West Bengal">West Bengal</option>


					</select>
				</li>
				
				<li><label class="small"></label>
                 <?php if($Detail['Retailer']['id']){?>
				 
				   <input type="submit" class="login" value="Update">
				    <?php }else{?>
				   <input type="submit" class="login" value="Submit">
				  <?php }?>
				   
				   </li>
				</ol>
			</form>

	</div>
		<div class="map" id="google_map" style="width:55%; height:600px;margin-right:10px;"></div>

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
