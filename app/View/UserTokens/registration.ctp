<script>
	function load(address,latitude,longitude) 
	{		
		if(!address)
		{
			var map = new google.maps.Map(document.getElementById('google_map'), {
				zoom: 2,
				center: new google.maps.LatLng(48.89364,48.89364),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});		
		}
	else
		{		
			var map = new google.maps.Map(document.getElementById('google_map'), {
				zoom:12,
				center: new google.maps.LatLng(latitude,longitude),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});
		}	 
	}

	function showAddress(address) 
	{				
		var geo = new google.maps.Geocoder;
		geo.geocode({'address':address},function(results, status){
			if (status == google.maps.GeocoderStatus.OK) 
			{			
				var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();			
				load(address,latitude,longitude);
			}
			
		});
	}
	$(document).ready(function(){
		showAddress('noida');
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
</script>

  <div class="form-ct" id="form-ct-bg">
      <h2>Registration</h2>
        <form method="post" action="">
          <ol>
            <li><input type="text" class="full" placeholder="Company Name:"/></li>
              <li><select class="half"><option>City</option></select> <select class="half-r"><option>State</option></select></li>
                <li><input type="text" class="full" placeholder="Mobile no:"/></li>
                 <li><input type="text" class="full" placeholder="Website:"/></li>
                   <li><input type="text" class="full" placeholder="Turn over:"/></li>
                     <li><input type="text" class="full" placeholder="Deals in:"/></li>
                      <li><input type="text" class="full" placeholder="Establish Date:"/></li>
                        <li><input type="text" class="full" placeholder="Email id:"/></li>
                          <li><input type="text" class="full" placeholder="Contact no:"/></li>
                           <li><input type="text" class="full" placeholder="Designation:"/></li>
                            <li><input type="submit" class="login" value="Login"><a href="#">Forgot Password</a></li>
                          </ol>
                        </form>
  </div>


<!--div id="registration_form">Create An Account</div>	
	<form action="" method="post">
	<article class="module width_full" style="width: 75%;float: right;margin: 0px;">
		<header><h3 style="color: #1F1F20;text-transform: uppercase;text-shadow: 0 1px 0 #fff;font-size: 13px;margin-left: 10px;">Login Information</h3></header>
				<div class="module_content">
				<table>
					<tr>
						<td>Username</td>
						<td><input type="text" name="data[User][user_name]" required> <span style="color:red;"><?php echo $message; ?></span></td>
					</tr>
					<tr>
						<td>Password</td>
						<td><input type="password" name="data[User][user_password]" required></td>
					</tr>	
				</table>

				</div>
		</article>
		
		<article class="module width_full" style="width: 75%;float: right;margin: 0px;margin-top:10px;">
		<header><h3 style="color: #1F1F20;text-transform: uppercase;text-shadow: 0 1px 0 #fff;font-size: 13px;margin-left: 10px;">Enter Your Contact Information</h3></header>
				<div class="module_content">
				<table style="float:left;width:50%">
					<tr>
						<td>Role</td>
						<td><select style="width: 155px;border: 2px inset;" name="data[User][role]">
								<option>Client</option>
							</select>	
						</td>
					</tr>
					<tr>
						<td>First Name</td>
						<td><input type="text" name="data[UserProfile][first_name]" required></td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td><input type="text" name="data[UserProfile][last_name]" required></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="email" name="data[UserProfile][email]" required></td>
					</tr>
					<tr>
						<td>Phone no.</td>
						<td><input type="text" name="data[UserProfile][phone]" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" maxlength="10" required></td>
					</tr>
					<tr>
						<td></td>
						<td><span id="error" style="color: Red; display: none">*Enter Only Integer Value</span></td>
					</tr>
					<tr>
						<td>City</td>
						<td><input type="text" name="data[UserProfile][city]" required></td>
					</tr>
					<tr>
						<td>State</td>
						<td><input type="text" name="data[UserProfile][state]" required></td>
					</tr>
					<tr>
						<td>Address</td>
						<td><textarea name="data[UserProfile][address]" style="border-radius: 4px;border: 2px inset;height: 95px;" id="address" onblur="showAddress(this.value);return false;"></textarea></td>
					</tr>					
				</table>
					<div id="google_map" style="width:48%;border:1px solid rgb(194, 194, 194); height:300px;"></div>
				</div>
				<footer>
				<div class="submit_link">
					<input type="submit" value="Publish" class="alt_btn">
				</div>
			</footer>
		</article>
		</form-->