<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCX1SGbjQbXFBLjBa-6BQtE6TWZ-Vi6oGI&sensor=false"></script>
<script type="text/javascript" src="<?php echo $this->html->url('/');?>js/StyledMarker.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script>
  $(function() {
    var availableTags = [

 <?php if($AllFos) {
		foreach($AllFos as $af){ ?>
     "<?php echo $af['UserProfile']['first_name']."-".$af['User']['id'];?>",
     <?php }}?>

     
    ];
    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
 
    $( "#tags" )
      // don't navigate away from the field on tab when selecting an item
      .bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
          event.preventDefault();
        }
      })
      .autocomplete({
        minLength: 0,
        source: function( request, response ) {
          // delegate back to autocomplete, but extract the last term
          response( $.ui.autocomplete.filter(
            availableTags, extractLast( request.term ) ) );
        },
        focus: function() {
          // prevent value inserted on focus
          return false;
        },
        select: function( event, ui ) {
          var terms = split( this.value );
          // remove the current input
          terms.pop();
          // add the selected item
          terms.push( ui.item.value );
          // add placeholder to get the comma-and-space at the end
          terms.push( "" );
          this.value = terms.join( ", " );
          return false;
        }
      });
  });
  </script>
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
<?php if(isset($message)){
		
  echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class=ace-icon fa fa-check></i>Well done!</strong>$message;<br></div>";}?>
<div id="addDesgnForm">
	<div class="title">Add Site</div>
	<div class="form-ct" id="ct-form-ct">
    
	
	 <form method="post" action="" class="form-m" enctype="multipart/form-data">
        
	 <input type="hidden" name="data[Retailer][id]" value="<?php echo $arrRetailer['Retailer']['id']; ?>" />
     <input type="hidden" name="data[User][token_id]" value="<?php echo $Detail['User']['token_id'];?>">
     <input type="hidden" name="data[User][role]" value="<?php echo $Detail['User']['role'];?>">
     <input type="hidden" name="data[User][created_at]" value="<?php echo $Detail['User']['created_at'];?>">
     <input type="hidden" name="data[User][company_id]" value="<?php echo $Detail['User']['company_id'];?>">
				<ol>
                <?php if(!$arrRetailer['Retailer']['id']){?>
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
              <?php }?>
				<li>
					<label class="big"><b>Site Information</b></label>
				</li>
               
				<li>
					<label class="small">RJIL Engineer name</label>
					<input type="text" class="small-full"  name="data[Retailer][owner_name]"  value="<?php echo $arrRetailer['Retailer']['owner_name']; ?>" required />

				</li>

<li>
					<label class="small">RJIL Engineer Email</label>
					<input type="text" class="small-full"  value="<?php echo $arrRetailer['Retailer']['email']; ?>" name="data[Retailer][email]"  required />
				</li>
				<li>
					<label class="small">RJIL Engineer Mobile No</label>
					<input type="text" class="small-full"  name="data[Retailer][phone]" value="<?php echo $arrRetailer['Retailer']['phone']; ?>" required />
					<span id="error" style="color: Red; display: none">*Enter Only Integer Value</span>

				</li>

      <?php  if($arrRetailer['Retailer']['owner_image'])
	  {
		echo   "<li>
                <label class='small'></label>
					<div style='margin-left:80px;'>
                  <img src='".$this->html->url('/')."apis/uploads/retailers/thumbnails/".$arrRetailer['Retailer']['owner_image']."' height='150' width='200'>
				 
                  </div>
					</li>";
	   }
	 
       ?>
                 <li>
					<label class="small">Profile Photo</label>
                   <?php if($arrRetailer['Retailer']['owner_image']){?>
                   <input type="file" class="small-full"  onchange="readURL(this);"  name="data[Retailer][owner_image]" value="" />
                   <input type="hidden" name="data[Retailer][old_profile_image]" value="<?php echo $arrRetailer['Retailer']['owner_image'];?>" />
                   <?php }else{?> 
					<input type="file" class="small-full"  onchange="readURL(this);"  name="data[Retailer][owner_image]" value="<?php echo $this->html->url('/');?>apis/uploads/retailers/thumbnails/<?php echo $arrRetailer['Retailer']['owner_image'] ?>" />
                   <?php }?> 
				</li>
                 <li>
                <label class="small"></label>
					<div style="margin-left:80px;">
 
                 </div>
					
				</li>
                    <?php  if($arrRetailer['Retailer']['shop_image'])
	  {
		echo   "<li>
                <label class='small'></label>
					<div style='margin-left:80px;'>
                  <img src='".$this->html->url('/')."apis/uploads/retailers/thumbnails/".$arrRetailer['Retailer']['shop_image']."' height='150' width='200'>
				 
                  </div>
					</li>";
	   }
	 
       ?>
                <li>
		  <label class="small">Shop Photo</label>
                     <?php if($arrRetailer['Retailer']['shop_image']){?>
                  <input type="file" class="small-full"  onchange="readURL1(this);"  name="data[Retailer][shop_image]" value="" />
                   <input type="hidden" name="data[Retailer][old_shop_photo]" value="<?php echo $arrRetailer['Retailer']['shop_image'];?>" />
                   <?php }else{?> 
					<input type="file" class="small-full"  onchange="readURL1(this);"  name="data[Retailer][shop_image]" value="" />
					<?php }?>
				</li>
				<li>
					<label class="small">Site Name</label>
					<input type="text" class="small-full"  name="data[Retailer][shop_name]" value="<?php echo $arrRetailer['Retailer']['shop_name']; ?>" required />

				</li>
                <li>
					<label class="small">Site SAP ID</label>
					<input type="text" class="small-full"  name="data[Retailer][retailer_code]" value="<?php echo $arrRetailer['Retailer']['retailer_code']; ?>" required />

				</li>
                
                
                <!--li>
					<label class="small">Distributer</label>
					<select class="small-full" name='data[Retailer][distributer]' >
							<option value=''>----Select Distributer----</option>
                            <option value='1'>Distributer 1</option>
                            <option value='2'>Distributer 2</option>
                            <option value='3'>Distributer 3</option>
						</select>
						
				</li-->
                 <li>
					<label class="small">Team Employee</label>
                                        <input id="tags" class="small-full" value="<?php echo $arrRetailer['Retailer']['FOS'];?>" name='data[Retailer][FOS]'>
					
				</li>
               <li>
					<label class="small">Project Type</label>
					<select class="small-full" name='data[Retailer][deal_in]' >
                    <option value=''>----Select Type----</option>
                    <option value='Fiber' <?php if($arrRetailer[Retailer][deal_in]=='Fiber'){?>Selected<?php }?>>Fiber</option>
                    <option value='Cisco' <?php if($arrRetailer[Retailer][deal_in]=='Cisco'){?>Selected<?php }?>>Cisco</option>
                    <option value='Triband' <?php if($arrRetailer[Retailer][deal_in]=='Triband'){?>Selected<?php }?>>Triband</option>
                    <option value='Wifi' <?php if($arrRetailer[Retailer][deal_in]=='Wifi'){?>Selected<?php }?>>Wifi</option>
                    <option value='Small Cell' <?php if($arrRetailer[Retailer][deal_in]=='Small Cell'){?>Selected<?php }?>>Small Cell</option>
                    <option value='Tower Project' <?php if($arrRetailer[Retailer][deal_in]=='Tower Project'){?>Selected<?php }?>>Tower Project</option>
					</select>
						
				</li>
                <li>
					<label class="small">Type Of Tower</label>
						<select class="small-full" name='data[Retailer][categories]' >
							<option value=''>----Select Type----</option>
								    <option value='GBT' <?php if($arrRetailer[Retailer][categories]=='GBT'){?>Selected<?php }?>>GBT</option>
								    <option value='GBM' <?php if($arrRetailer[Retailer][categories]=='GBM'){?>Selected<?php }?>>GBM</option>
								    <option value='RTT' <?php if($arrRetailer[Retailer][categories]=='RTT'){?>Selected<?php }?>>RTT</option>

<option value='RTP' <?php if($arrRetailer[Retailer][categories]=='RTP'){?>Selected<?php }?>>RTP</option>
						</select>
						
				</li>
                <!--li>
					<label class="small">Turn Over</label>
					<input type="text" class="small-full"  value="<?php echo $arrRetailer['Retailer']['turn_over']; ?>" name="data[Retailer][turn_over]"  required />						
				</li-->
                
                <li>
					<label class="small">Address</label>
					<textarea id="address" class="small" name="data[Retailer][address]" style="width:202px;border-radius: 4px;border: 2px inset;height: 95px;" id="address" onblur="showAddress();return false;"><?php echo $arrRetailer['Retailer']['address'];?></textarea>
				</li>

          <li><label class="small">Latitude</label>
 <input type="text" name="data[Retailer][web_latitude]" class="small-full" id="lat" value="<?php echo $Details['Retailer']['web_latitude'];?>" />
</li>
<li><label class="small">Longitude</label>
	 <input type="text" name="data[Retailer][web_longitude]" class="small-full" id="long" value="<?php echo $Details['Retailer']['web_longitude'];?>" />    
</li>

				
				
               <li>
					<label class="small">Alternate Mobile No</label>
					<input type="text" class="small-full"  name="data[Retailer][alt_mobile]" value="<?php echo $arrRetailer['Retailer']['alt_mobile']; ?>" />
					<span id="error" style="color:Red;display:none">*Enter Only Integer Value</span>

				</li>
                
                

               
            
                
				
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

