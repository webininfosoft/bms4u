<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCX1SGbjQbXFBLjBa-6BQtE6TWZ-Vi6oGI&sensor=false"></script>
<script type="text/javascript" src="<?php echo $this->html->url('/');?>js/StyledMarker.js"></script>
<script>
var rootpath='';
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
	var country="India";

	if(address )
	address=address + " "+country;

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
	loadParent($('#parentDesignation').val());
});
</script>
	
<script>

       var specialKeys = new Array();
       specialKeys.push(8); 
       function IsNumeric(e) 
	   {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementById("error").style.display = ret ? "none" : "block";
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

function loadParent(data){

var selectedUser = '<?php echo $selectedUser;?>';
 $.post("<?php echo $this->webroot;?>Users/loadAllParent",{'designation_id':data,'selectedUser':selectedUser},function(result){
				$('#parUser').html(result);
});

}
	
</script>

<?php 
if($permissions['perm_add'] != 1 || $this->Session->read('user.User.role_id') == 0){ ?>
<?php if(isset($message)){
 echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class='ace-icon fa fa-check'></i>$message</strong></div>";}?>
 
  <?php
 if(isset($message1)){
 echo   "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class='ace-icon fa fa-times'></i>&nbsp;$message1</strong><br></div>";}
 ?>
<div id="addDesgnForm">

	<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong>* Your Phone Number will be username to login in the mobile app or website.</strong></div>
	<div class="title">Add User</div>
	<div class="form-ct" id="ct-form-ct">
	 <form method="post" action="" class="form-m">
			
			    <input type="hidden" name="data[UserProfile][latitude]" id="lat" value="<?php echo $employeeDetail['UserProfile']['latitude'];?>" />
		 	    <input type="hidden" name="data[UserProfile][longitude]" id="long" value="<?php echo $employeeDetail['UserProfile']['longitude'];?>" />
		   	    <input type="hidden" name="data[UserProfile][id]" value="<?php echo $employeeDetail['UserProfile']['id'];?>">
			    <input type="hidden" name="data[User][id]" value="<?php echo $employeeDetail['User']['id'];?>">
			    <input type="hidden" name="data[User][role]" value="<?php echo $Detail['User']['role'];?>">
			    <input type="hidden" name="data[User][token_id]" value="<?php echo $Detail['User']['token_id'];?>">
			    <input type="hidden" name="data[User][created_at]" value="<?php echo $Detail['User']['created_at'];?>">
            

				<ol>
				
				<li>
					<label class="big"><b>Personal Information</b></label>
				</li>
				<li>
					<label class="small">First Name*</label>
					<input type="text" class="small-full"  name="data[UserProfile][first_name]" value="<?php echo $employeeDetail['UserProfile']['first_name']; ?>" required />

				</li>
				<li>
					<label class="small">Last Name*</label>
					<input type="text" class="small-full"  name="data[UserProfile][last_name]" value="<?php echo $employeeDetail['UserProfile']['last_name']; ?>" required />

				</li>
				<li>
					<label class="small">Email*</label>
					<input type="email" class="small-full"  name="data[UserProfile][email]" value="<?php echo $employeeDetail['UserProfile']['email']; ?>" required />
				</li>
				<li>
					<label class="small">Phone*</label>
					<input type="text" class="small-full" maxlength=10 onkeypress="return IsNumeric(event)" name="data[UserProfile][phone]" value="<?php echo $employeeDetail['UserProfile']['phone']; ?>" required />
					<span id="error" style="color: Red; display: none;padding-left: 75px;">*Enter Only Integer Value</span>

				</li>
				<li>
					<label class="small">Branch</label>
					
					<select class="small-full"  name="data[UserProfile][branch]"  />
					<option value="">--Select--</option>
                    
					<?php 
					
					while(list($key,$val)=each($arrBranches))
					{
						if($employeeDetail['UserProfile']['branch']==$val['Branch']['first_name'])
							echo "<option selected value='".$val['Branch']['first_name']."'>".$val['Branch']['first_name']."</option>";
						else
							echo "<option value='".$val['Branch']['first_name']."'>".$val['Branch']['first_name']."</option>";
					}
					?>
					</select>
				</li>
				
				<li>
					<label class="small">Designation*</label>
					<select class="small-full" required name='data[User][parent_role_id]' onchange ='loadParent(this.value);' id="parentDesignation">
							<option value=''>----Select Designation----</option>
                           
							<?php while(list($key,$val)=each($arrData)){ 
							if($val['Designation']['designation']!='Retailer'){
							?>
								<option value="<?php echo $val['Designation']['id'];?>" <?php echo $val['Designation']['id'] == $selectedRole?'selected':''?>><?php echo $val['Designation']['designation'];?></option>
							<?php 
							} }?>
						</select>
						
				</li>
				<li class="designationTD">
				<label class="small">Parent Employee</label>
                <select name="data[User][parent_id]" id="parUser">
                <option value=""> Select Parent Employee</option>
                </select>
					
						
				</li>
				

				<li>
					<label class="small">Address</label>
					<textarea id="address" class="small" name="data[UserProfile][address]" style="border-radius: 4px;border: 2px inset;height: 95px;" id="address" onblur="showAddress();return false;"><?php echo $employeeDetail['UserProfile']['address'];?></textarea>
				</li>
				
				
				<li><label class="small"></label>
				   <?php if($employeeDetail['User']['id']){?>
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
