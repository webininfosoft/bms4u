<?php
/**
 * File to handle all API requests
 * Accepts GET and POST
 * 
 * Each request will be identified by TAG
 * Response will be JSON data
 
  /**
 * check for POST request 
 */

require_once "database/db_mysql.inc";
if(isset($_GET['latitude']) && isset($_GET['longitude'])) 
{
		
		$uid=isset($_GET['uid'])?$_GET['uid']:1;
		$lat = $_GET['latitude'];
		$long = $_GET['longitude'];
		$devid = $_GET['stringdevice'];	
		
		
		// response Array
		$response = array( "success" => 0, "error" => 0);
        // check for user
       
	   
        $result = $db->query("INSERT INTO user_current_locations(user_id,latitude,longitude,device_id,date_time) VALUES('$uuid', '$lat', '$long', '$devid',NOW())");
        
		
        if ( $result ) {
            // user found
            // echo json with success = 1
            $response["success"] = 1;
            echo json_encode($response);
        } else {
           
            $response["error"] = 1;
            $response["error_msg"] = "Sql Error!";
            echo json_encode($response);
        }
 
} 
else {

   echo "Access Denied";
}
?>