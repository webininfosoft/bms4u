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

    function load(roleid,latcenter,longcenter) {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(latcenter, longcenter),
        zoom: 10,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;

      // Change this depending on the name of your PHP file
       downloadUrl(strRoot+"/users/getuserbyroleid/"+roleid, function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
          var address = markers[i].getAttribute("lng");
          var type = markers[i].getAttribute("lat");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<b>" + name + "</b> <br/>" + address;
          var icon = customIcons[type] || {icon: rootpath + '/img/icon1.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
	  
     
    }
	
	function loadmapbyuser(user_id,latcenter,longcenter) {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(latcenter, longcenter),
        zoom: 10,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;

      // Change this depending on the name of your PHP file
       downloadUrl(strRoot+"/users/getUserCurrentLocations/"+user_id, function(data) {
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
          var icon = customIcons[type] || {icon: rootpath +'/img/icon1.png',
       	 shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
		
      });
     
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
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
	
	function loadUser(data)
	{
	
		var arrDesignation = data.split('&&');
		//alert(arrDesignation[0]);
		if(arrDesignation[0]!=0)
		{	
			var selectedUser = '<?php echo $selectedUser;?>';		
	
		   $.post(rootpath+"/users/getcenterbyroleid/"+arrDesignation[0],{},function(result){

			   load(arrDesignation[0],result.lat,result.long);
			  
			},"json");
		   
			
			
			 $.post(rootpath+"/users/loadUserByroleid",{'designation_id':arrDesignation[0]},function(result){
				$('.designationTD').html('<label class="small">Select User</label>'+result).show();
			 });
		}	
		else
			$('.designationTD').html('').hide();
	}
	
	function loadUserMap(userid)
	{
		if(userid!=0)
		{	
			   $.post(rootpath+"/users/getUserCurrentLocationsCenter/"+userid,{},function(result){

				    loadmapbyuser(userid,result.lat,result.long);
			},"json");
		}	
	}
	function loadDirectionMap()
	{
			var directionsDisplay;
			var directionsService = new google.maps.DirectionsService();
			var map;

			var locations = [
				['Bondi Beach', -33.890542, 151.274856, 4],
				['Coogee Beach', -33.923036, 151.259052, 5],
				['Cronulla Beach', -34.028249, 151.157507, 3],
				['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
				['Maroubra Beach', -33.950198, 151.259302, 1]
			];


			var infowindow = new google.maps.InfoWindow();

			var marker, i;

			map = new google.maps.Map(document.getElementById('map'), {
				zoom: 10,
				center: new google.maps.LatLng(-33.92, 151.25),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});

			for (i = 0; i < locations.length; i++) {
				marker = new google.maps.Marker({
					position: new google.maps.LatLng(locations[i][1], locations[i][2]),
					map: map
				});

				google.maps.event.addListener(marker, 'click', (function (marker, i) {
					return function () {
						infowindow.setContent(locations[i][0]);
						infowindow.open(map, marker);
					}
				})(marker, i));
			}

			directionsDisplay = new google.maps.DirectionsRenderer();

			directionsDisplay.setMap(map);

			var start = new google.maps.LatLng(-33.890542, 151.274856);
			var end = new google.maps.LatLng(-34.028249, 151.157507);
			var request = {
				origin: start,
				destination: end,
				travelMode: google.maps.DirectionsTravelMode.DRIVING
			};
			directionsService.route(request, function (response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(response);
				}
			});
	}
</script>

<div class="col-xs-12">
	<div class="table-header">
		Results for "Map View"
	</div>
</div>
<div class="form-ct" id="ct-form-ct">
                <form method="post" action="" class="form-m">
                <ol>
                <li>
					<label class="small">Designation</label>
					<select class="small-full" name='data[User][parent_role_id]'   onchange = 'loadUser(this.value);' id="parentDesignation">
							<option value='' >----Select Designation----</option>
                           
							<?php while(list($key,$val)=each($arrData)){ ?>
								<option value="<?php echo $val['Designation']['id'];?>"><?php echo $val['Designation']['designation'];?></option>
							<?php } ?>
						</select>
				</li>
				<li class="designationTD"></li>
                </ol>				
                </form>
</div>	
<div id="addDesgnForm" style="margin-top:70px;">
	    <div id="map" style=" height: 500px"></div>
</div>