<script>
$(document).ready(function(){
  $("#map").click(function(){
    $("#employeeList").hide();
	$("#filterBlock").hide();
	$("#mapShow").show();
	
  });
  $("#list").click(function(){
    $("#mapShow").hide();
	$("#filterBlock").show();
	$("#employeeList").show();
  });
});

var map;
	var markers=new Array();
</script>
<?php 
	
	foreach($multiMarker as $values)
	{ 
		if($values['UserProfile']['latitude'])
		{
			 $latitude = $values['UserProfile']['latitude'];
			 $longitude = $values['UserProfile']['longitude'];
			 $fname = $values['UserProfile']['first_name']; 
	?>
	<script>
			var latitude = "<?php echo $latitude;?>";
			var longitude = "<?php echo $longitude;?>";
			var name = "<?php echo $fname;?>";	
			var Center=new Array(latitude,longitude,name);
			markers.push(Center);
	</script>
<?php }} ?>
	
<script>

		function initialize()
		{

			var myCenter=new google.maps.LatLng(28.635308000000000000, 77.224960000000010000);
			var mapProp = {
			  center:myCenter,
			  zoom:5,
			  mapTypeId:google.maps.MapTypeId.ROADMAP
			};

			map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
			var infowindow = new google.maps.InfoWindow();
			var marker, i;

			for (i = 0; i < markers.length; i++) 
			{  
			  marker = new google.maps.Marker({
				position: new google.maps.LatLng(markers[i][0], markers[i][1]),
				map: map
			  });
			  
			   google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
				  infowindow.setContent(markers[i][2]);
				  infowindow.open(map, marker);
				}
			  })(marker, i));
			  
			}
		}
		google.maps.event.addDomListener(window, 'load', initialize);
			
</script>
<script>
function filterPage(page)
{
	var url = "<?php echo $this->html->url('/Users/view/')?>";
	url+=page;
	$('.filter').each(function(){
		var id = this.id;
		if(!this.value)
			url += '/all';
		else
			url += '/'+this.value;
	});	
	window.location.href = url;
}	
</script>
<?php 
if($permissions['perm_view'] != 1 || $this->Session->read('user.User.role_id') == 0){ ?>
	<article class="module width_full" style="width: 75%;float: right;margin: 0px;margin-top:10px;display:none;" id="filterBlock">
		<header>
			<h3 style="color: #1F1F20;float: left;text-transform: uppercase;text-shadow: 0 1px 0 #fff;font-size: 13px;margin-left: 10px;margin-top: 5px;">Filter By</h3>
		</header>
	<div class="module_content">
		<table id="table_format">
			<tr>
				<th style="background:none;"><input type="text" value="<?php echo $first_name!='all'?$first_name:'';?>" placeholder="Firstname" class="filter" id="first_name" style="width: 100px;"/></th>
				<th style="background:none;"><input type="text" value="<?php echo $last_name!='all'?$last_name:'';?>" placeholder="Lastname" class="filter" id="last_name" style="width: 100px;"/></th>
				<th style="background:none;"><input type="text" value="<?php echo $email!='all'?$email:'';?>" placeholder="Email" id="email" class="filter" style="width: 100px;"/></th>
				<th style="background:none;"><input type="text" value="" id="<?php echo $phone!='all'?$phone:'';?>" placeholder="Phone" class="filter" style="width: 100px;"/></th>
				<th style="background:none;"><input type="text" value="<?php echo $role!='all'?$role:'';?>" placeholder="Role" id="role" class="filter" style="width: 100px;"/></th>
				<th style="background:none;"><input type="text" value="<?php echo $city!='all'?$city:'';?>" id="city"  placeholder="City" class="filter" style="width: 100px;"/></th>
				<th style="background:none;"><input type="button" value="filter" onclick="filterPage('1')"></th>
			</tr>
		</table>
	
	</div>
	</article>
		<article class="module width_full" style="width: 75%;float: right;margin: 0px;margin-top:10px;display:none;" id="employeeList">
		<header>
			<h3 style="color: #1F1F20;float: left;text-transform: uppercase;text-shadow: 0 1px 0 #fff;font-size: 13px;margin-left: 10px;margin-top: 5px;">Employee Detail</h3>
			<div style="float:right;"><input type="button" value="Map" id="map" style="padding: 0px 8px;margin-right: 10px;margin-top: 5px;"/></div>
			<div style="margin-bottom:5px;display:<?php echo $totalPages>1?'block':'none'?>;">
				<span style="float:right;">	
					<input type="button" value="<<" style="display:<?php echo $page==1?'none':'block'?>;float:left" onclick="filterPage('1')" title="Move to first page">
					<input type="button" value="<" style="display:<?php echo $page==1?'none':'block'?>;float:left" onclick="filterPage(<?php echo $page-1;?>)" title="Move to previous page">	
					<select id="pageNumber" style="width:60px;;float:left;margin-top:0px;margin-top: 3px;" onchange="filterPage(this.value)">
					<?php for($i=1;$i<=$totalPages;$i++){ ?>
					<option <?php echo $i==$page?'selected':''?>><?php echo $i;?></option>
					<?php } ?>
					</select>
					<input type="button" value=">" style="display:<?php echo $page==$totalPages ?'none':'block'?>;float:left;" onclick="filterPage(<?php echo $page+1;?>)" title="Move to next page">	
					<input type="button" value=">>" style="display:<?php echo $page==$totalPages?'none':'block'?>;float:left;" onclick="filterPage(<?php echo $totalPages;?>)" title="Move to last page">		
					</span>
			</div>
		</header>
	<div class="module_content">
		<table id="table_format">
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Role</th>
				<th>City</th>
				<th>Actions</th>
			</tr>
			<?php foreach($employeeResults as $employeeResult){ ?>
			<tr>
				<td><?php echo $employeeResult['b']['first_name']; ?></td>
				<td><?php echo $employeeResult['b']['last_name']; ?></td>
				<td><?php echo $employeeResult['b']['email']; ?></td>
				<td><?php echo $employeeResult['b']['phone']; ?></td>
				<td><?php echo $employeeResult['d']['designation']; ?></td>
				<td><?php echo $employeeResult['b']['city']; ?></td>
				<td> <?php echo $this->html->link('Edit', array('action'=>'add', $employeeResult['a']['id'])); ?> | 
					 <?php echo $this->html->link('Delete', array('action'=>'delete', $employeeResult['a']['id']), NULL, 'Are you sure you want to delete this page?'); ?>
				</td>
			</tr>
		<?php } ?>
		</table>
	</div>
	</article>
	<article class="module width_full" style="width: 75%;float: right;height: 400px;margin: 0px;margin-top:10px;" id="mapShow">
		<header>
			<h3 style="color: #1F1F20;float: left;text-transform: uppercase;text-shadow: 0 1px 0 #fff;font-size: 13px;margin-left: 10px;margin-top: 5px;">Maps</h3>
			<div style="float:right;"><input type="radio" name="homeLocation" value=""  checked> Home  <input type="radio" name="currentLocation" value=""> Current <input type="button" value="List" id="list" style="padding: 0px 8px;margin-right: 10px;margin-top: 5px;margin-left: 20px;"/></div>
			<div id="googleMap" style="clear: both;height:365px;"></div>
		</header>
	</article>		
<?php } else { ?>
		<article class="module width_full" style="width: 75%;float: right;margin: 0px;margin-top:10px;">
		<header><h3 style="color: #1F1F20;text-transform: uppercase;text-shadow: 0 1px 0 #fff;font-size: 13px;margin-left: 10px;">Restricted This Page</h3></header>
			<div style="text-align:center">
				<img src="<?php echo $this->html->url('/img/restriction.jpg')?>" width="300"><br>Sorry, You are not autorized to access this page
			</div>
		</article>			
<?php } ?>