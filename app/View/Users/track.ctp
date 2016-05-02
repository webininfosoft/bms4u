<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCX1SGbjQbXFBLjBa-6BQtE6TWZ-Vi6oGI&sensor=false"></script>
<script type="text/javascript">
//<![CDATA[

    var rootpath='';
	var latcenter="<?php echo $latcenter;?>";
    var longcenter="<?php echo $longcenter;?>";
	
    var customIcons = {
      Categories1: {
        icon: rootpath + '/img/icon1.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      },
      bar: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      }
    };

    function load(roleid) {
      var map = new google.maps.Map(document.getElementById("map"), {
        zoom: 9,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;
     
      // Change this depending on the name of your PHP file
       downloadUrl(strRoot+"/users/getuserbyroleid/"+roleid, function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
		
		var bound = new google.maps.LatLngBounds();
		
        for (var i = 0; i < markers.length; i++) {
        
		if(markers[i].getAttribute("lng"))
		{
		var name = markers[i].getAttribute("name");
          var address = markers[i].getAttribute("lng");
          var type = markers[i].getAttribute("lat");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<b>" + name + "</b> <br/>" + address;
          var icon = customIcons[type] || {icon: rootpath + '/img/user_icon.png',
          shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
		  
		  bound.extend( new google.maps.LatLng(markers[i].getAttribute("lat"), markers[i].getAttribute("lng")) );
		  
          bindInfoWindow(marker, map, infoWindow, html);
		  }
        }
		map.setCenter(bound.getCenter());
		map.fitBounds(bound);
		
		 
      });
    
    }
	
function loadmapbyuser(user_id,date) {
      
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(0,0),
        zoom: 10,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;
      var path = [];
      var bound = new google.maps.LatLngBounds();
      
  downloadUrl(strRoot+"/users/getUserRetailers/"+user_id, function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var time = markers[i].getAttribute("time"); 
         var name = markers[i].getAttribute("name");
          var address = markers[i].getAttribute("address");
          var type = markers[i].getAttribute("lat");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<b>" + name + "</b> <br/>Time:"+time+"<br/>Phone:" + address;
          var icon = customIcons[type] || {icon: rootpath +'/img/retailer_icon.png',
       	 shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
	  bound.extend( new google.maps.LatLng(markers[i].getAttribute("lat"), markers[i].getAttribute("lng")) );
		  
          bindInfoWindow(marker, map, infoWindow, html);
	
        }

	
		map.setCenter(bound.getCenter());
			map.fitBounds(bound);
	
      });

      // Change this depending on the name of your PHP file
       downloadUrl(strRoot+"/users/getUserCurrentLocations/"+user_id+"/"+date, function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var time = markers[i].getAttribute("time"); 
         var name = markers[i].getAttribute("name");
          var address = markers[i].getAttribute("address");
	  var provider=markers[i].getAttribute("provider");
          var type = markers[i].getAttribute("lat");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<b>" + name + "</b>- Provider:"+ provider +" <br/>Time:"+time+"<br/>Phone:" + address;
          var icon = customIcons[type] || {icon: rootpath +'/img/lcoation_icon.png',
       	 shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
		   bound.extend( new google.maps.LatLng(markers[i].getAttribute("lat"), markers[i].getAttribute("lng")) );
		  
          bindInfoWindow(marker, map, infoWindow, html);
	  path.push(point);
        }

	var mySymbol = {
	    path: google.maps.SymbolPath.CIRCLE,
	    scale: 25,
	    strokeWeight: 5,
	    fillOpacity: .2
	};

	var lineSymbol = {
		    path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
	  };

  
	var polyline = new google.maps.Polyline({
			  path: path,
			  icons: [{
				  icon: mySymbol,
				  offset: '100%'
				}],
			  strokeColor: "#005826",
			  strokeOpacity: 1.0,
			  strokeWeight: 5

			});
			polyline.setMap(map);
			map.setCenter(bound.getCenter());
			map.fitBounds(bound);
      });


      

		
     
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);

	map.setZoom(17);
	map.panTo(marker.position);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}


//]]>
</script>
<script>
	
function refreshUser()
{
	var userid=$('#userslist').val();

	if(userid!='0')
		loadUserMap(userid);
	else
	{
		var roleid=$('#parentDesignation').val();
		

		if(roleid)
		loadUser(roleid)
	}
}
	function loadUser(data)
	{
	
		var arrDesignation = data.split('&&');



		if(arrDesignation[0]!=0)
		{	
			var selectedUser = '<?php echo $selectedUser;?>';		
			load(arrDesignation[0]);
			 $.post(rootpath+"/users/loadUserByroleid",{'designation_id':arrDesignation[0]},function(result){
				$('.designationTD').html(result).show();
			 });
		}	
		else
			$('.designationTD').html('').hide();
	}
	
	function loadUserMap(userid)
	{
		if(userid!=0)
		{	
			var date=$('.date-picker').val();
			loadmapbyuser(userid,date);
			
		}	
	}
	
</script>




<script>
function  useridonchange()
{
 var userid=$('#userslist').val();
 var date=$('.date-picker').val();
  window.location = "http://cr.webininfosoft.com/Users/exportUserCurrentLocations/"+userid;
}
</script>

<div class="col-xs-12">
	<div class="col-sm-12">
		<div class="widget-box widget-color-blue">
			<div class="widget-header">
				<h4 class="widget-title">Track Users</h4>

				<span class="widget-toolbar">
					
					<a href="#" data-action="collapse">
						<i class="ace-icon fa fa-chevron-up"></i>
					</a>

					<a href="#" data-action="close">
						<i class="ace-icon fa fa-times"></i>
					</a>
				</span>
			</div>

			<div class="widget-body">
				<div class="widget-main">
						<div class="row">
							<div class="col-xs-8 col-sm-3">
								<label for="id-date-picker-1">Designation</label>
							</div>
							<div class="col-xs-8 col-sm-3">
								<label for="id-date-picker-2">Select User</label>
							</div>
							<div class="col-xs-8 col-sm-3">
								<label for="id-date-picker-2">Date</label>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-8 col-sm-3">
								<!-- #section:plugins/date-time.datepicker -->
								<div class="input-group">
									<select class="form-control" name='data[User][parent_role_id]'  onchange = 'loadUser(this.value);' id="parentDesignation">
										<option value='' >----Select Designation----</option>
											<?php while(list($key,$val)=each($arrData)){ ?>
											<option value="<?php echo $val['Designation']['id'];?>"><?php echo $val['Designation']['designation'];?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-xs-8 col-sm-3">
								<!-- #section:plugins/date-time.datepicker -->
								<div class="input-group designationTD">
									<select class="form-control" id="userid" onchange='useridonchange();'>
										<option value='' >----Select User----</option>										
									</select>
								</div>
							</div>
							<div class="col-xs-8 col-sm-3">
								<!-- #section:plugins/date-time.datepicker -->
								<div class="input-group">
									<input class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy">
									<span class="input-group-addon">
										<i class="fa fa-calendar bigger-110"></i>
									</span>
								</div>
							</div>
			                       <div class="col-xs-8 col-sm-3">
								<!-- #section:plugins/date-time.datepicker -->
								<div class="input-group">

									<button class="btn btn-info" onclick="refreshUser();return false;">
											Search
											<i class="ace-icon fa fa-search  align-top bigger-125 icon-on-right"></i>
									</button>

									 <button class="btn btn-info" onclick="useridonchange();">
											Export
											<i class="ace-icon fa fa-print  align-top bigger-125 icon-on-right"></i>
										</button>

								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-8 col-sm-12">
								<div id="map" style=" height: 500px">
								<div class="alert alert-block alert-success">
										<button type="button" class="close" data-dismiss="alert">
											<i class="ace-icon fa fa-times"></i>
										</button>
										<p>
											Please Select Designation To get current locations of the users.
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
			jQuery(function($) {

				//link
				$('.date-picker').datepicker({
					autoclose: true,
					todayHighlight: true
				})
				//show datepicker when clicking on the icon
				.next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
			
				//or change it into a date range picker
				$('.input-daterange').datepicker({autoclose:true});

});
</script>