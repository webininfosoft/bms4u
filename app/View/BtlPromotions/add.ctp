<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCX1SGbjQbXFBLjBa-6BQtE6TWZ-Vi6oGI&sensor=false"></script>
<script type="text/javascript" src="<?php echo $this->html->url('/');?>js/StyledMarker.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
<script>
 function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
						
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
		 function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah1')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
						
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>

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
	//var city=$('#city').val();
	//var country="India";
	//var state=$('#state').val();
	if(address)
	address=address;

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
		 <form method="post" action="" class="form-m" enctype="multipart/form-data">
     <input type="hidden" name="data[Retailer][web_latitude]" id="lat" value="<?php echo $Details['Retailer']['web_latitude'];?>" />
	 <input type="hidden" name="data[Retailer][web_longitude]" id="long" value="<?php echo $Details['Retailer']['web_longitude'];?>" />    
	<input type="hidden" name="data[Retailer][id]" value="<?php echo $arrRetailer['Retailer']['id']; ?>" />
    <input type="hidden" name="data[User][token_id]" value="<?php echo $Detail['User']['token_id'];?>">
     <input type="hidden" name="data[User][role]" value="<?php echo $Detail['User']['role'];?>">
     <input type="hidden" name="data[User][created_at]" value="<?php echo $Detail['User']['created_at'];?>">
     <input type="hidden" name="data[User][company_id]" value="<?php echo $Detail['User']['company_id'];?>">
				<ol>
				<li>
					<label class="big"><b>Login Information</b></label>
				</li>
				<li>
					<label class="small">Username</label>
					<input type="text" class="small-full"  name="data[User][user_name]" value="<?php echo $Detail['Retailer']['']; ?>" required />

				</li>
				<li>
					<label class="small">Password</label>
					<input type="password" class="small-full"  name="data[User][user_password]" value=""  required />

				</li>
              
				<li>
					<label class="big"><b>Retailer Information</b></label>
				</li>
               
				<li>
					<label class="small">Owner Name</label>
					<input type="text" class="small-full"  name="data[Retailer][owner_name]"  value="<?php echo $arrRetailer['Retailer']['owner_name']; ?>" required />

				</li>
      <?php  if($arrRetailer['Retailer']['profile_image'])
	  {
		echo   "<li>
                <label class='small'></label>
					<div style='margin-left:80px;'>
                  <img src='".$this->html->url('/')."images/".$arrRetailer[Retailer][profile_image]."' height='150' width='200'>
                  </div>
					</li>";
	   }
	 
       ?>
      
     
                 <li>
					<label class="small">Profile Photo</label>
					<input type="file" class="small-full"  onchange="readURL(this);"  name="data[Retailer][profile_image]" value="<?php echo $this->html->url('/');?>/images<?php echo $arrRetailer['Retailer']['profile_image'] ?>" required />
 
				</li>
                 <li>
                <label class="small"></label>
					<div style="margin-left:80px;">
 
                 </div>
					
				</li>
                <li>
					<label class="small">Shop Photo</label>
					<input type="file" class="small-full"  onchange="readURL1(this);"  name="data[Retailer][shop_photo]" value="" required />

				</li>
				<li>
					<label class="small">Shop Name</label>
					<input type="text" class="small-full"  name="data[Retailer][shop_name]" value="<?php echo $arrRetailer['Retailer']['shop_name']; ?>" required />

				</li>
                
                
                <li>
					<label class="small">Distributer</label>
					<select class="small-full" name='data[Retailer][distributer]' >
							<option value=''>----Select Distributer----</option>
                           
							
						</select>
						
				</li>
                 <li>
					<label class="small">FOS</label>
					<select class="small-full" name='data[Retailer][FOS]' >
							<option value=''>----Select fos----</option>
						</select>
						
				</li>
               <li>
					<label class="small">Deals in</label>
					<select class="small-full" name='data[Retailer][deal_in]' >
							<option value=''>----Select Deal----</option>
                            <option value='Sales'>Sales</option>
                            <option value=''>Purches</option>
                            <option value=''>Renting</option>
                           
							
						</select>
						
				</li>
                <li>
					<label class="small">Categories</label>
					<select class="small-full" name='data[Retailer][Categories]' >
							<option value=''>----Select Categories----</option>
                            <option value='Categories1'>Categories1</option>
                            <option value=''>Categories2</option>
                            <option value=''>Categories3</option>
                            <option value=''>Categories4</option>
                            <option value=''>Categories5</option>
                           
							
						</select>
						
				</li>
                <li>
					<label class="small">Turn Over</label>
					<select class="small-full" name='data[Retailer][Turn_Over]' >
							<option value=''>----Select Turn Over----</option>
                            <option value='200000-5000000'>200000-5000000</option>
                            <option value=''>500000-10000000</option>.
                            <option value=''>1000000-20000000</option>
                           
							
						</select>
						
				</li>
                 <!-- <li>
				<label class="small">Country</label>
					/*<?php    App::import('Controller', 'Retailers');
                      $EmpCont = new RetailersController;
                      $employee_list = $EmpCont ->getCountryCombo();
					  ?>
					
				</li>
                 <li>
				<label class="small">State</label>
					<?php    App::import('Controller', 'Retailers');
                      $EmpCont = new RetailersController;
                      $employee_list = $EmpCont ->getStateCombo();
					  ?>
					
				</li>
                   <li>
				<label class="small">City</label>
					<?php    App::import('Controller', 'Retailers');
                      $EmpCont = new RetailersController;
                      $employee_list = $EmpCont ->getCityCombo();
					  ?>
					
				</li>-->
				<li>
					<label class="small">Email</label>
					<input type="text" class="small-full"  value="<?php echo $arrRetailer['Retailer']['email']; ?>" name="data[Retailer][email]"  required />
				</li>
				<li>
					<label class="small">Mobile No</label>
					<input type="text" class="small-full"  name="data[Retailer][phone]" value="<?php echo $arrRetailer['Retailer']['phone']; ?>" required />
					<span id="error" style="color: Red; display: none">*Enter Only Integer Value</span>

				</li>
               <li>
					<label class="small">Alternate Mobile No</label>
					<input type="text" class="small-full"  name="data[Retailer][alt_mobile]" value="<?php echo $arrRetailer['Retailer']['alt_mobile']; ?>" required />
					<span id="error" style="color: Red; display: none">*Enter Only Integer Value</span>

				</li>
                
                

				<!--<li>
					<label class="small">Country</label>
					<?php			
						echo $this->requestAction( "/retailers/getCountryCombo/small-full");
					?>
				</li-->
                
                

                <li>
					<label class="small">Address</label>
					<textarea id="address" class="small" name="data[Retailer][address]" style="border-radius: 4px;border: 2px inset;height: 95px;" id="address" onblur="showAddress();return false;"><?php echo $arrRetailer['Retailer']['address'];?></textarea>
				</li>
				
				
				<!--<li>
					<label class="small">State</label>
					<span id="stateplace"></span>
				</li>-->
				
				<!--<li>
					<label class="small">City</label>
					<select class="small-full" id="state"  name="data[Retailer][city]" value="<?php echo $Detail['Retailer']['city']; ?>"  />
				<option value="">----Select city----</option>
<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option><option value="Andhra Pradesh">Andhra Pradesh</option><option value="Arunachal Pradesh">Arunachal Pradesh</option><option value="Assam">Assam</option><option value="Bihar">Bihar</option><option value="Chandigarh">Chandigarh</option><option value="Chhattisgarh">Chhattisgarh</option><option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option><option value="Daman and Diu">Daman and Diu</option><option value="Delhi">Delhi</option><option value="Goa">Goa</option><option value="Gujarat">Gujarat</option><option value="Haryana">Haryana</option><option value="Himachal Pradesh">Himachal Pradesh</option><option value="Jammu and Kashmir">Jammu and Kashmir</option><option value="Jharkhand">Jharkhand</option><option value="Karnataka">Karnataka</option><option value="Kerala">Kerala</option><option value="Lakshadweep">Lakshadweep</option><option value="Madhya Pradesh">Madhya Pradesh</option><option value="Maharashtra">Maharashtra</option><option value="Manipur">Manipur</option><option value="Meghalaya">Meghalaya</option><option value="Mizoram">Mizoram</option><option value="Nagaland">Nagaland</option><option value="Orissa">Orissa</option><option value="Pondicherry">Pondicherry</option><option value="Punjab">Punjab</option><option value="Rajasthan">Rajasthan</option><option value="Sikkim">Sikkim</option><option value="Tamil Nadu">Tamil Nadu</option><option value="Tripura">Tripura</option><option value="Uttaranchal">Uttaranchal</option><option value="Uttar Pradesh">Uttar Pradesh</option><option value="West Bengal">West Bengal</option>


					</select>
				</li>-->
               
            
                
				
				<li><label class="small"></label>
                 <?php if($Details['Retailer']['id']){?>
				 
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

