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

/*$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
        "Attempt: "."LatLong".PHP_EOL.
        "User: ".$_REQUEST['uid'].PHP_EOL.
        "-------------------------".PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('./log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
*/
require_once "database/db_mysql.inc";

if(isset($_REQUEST['lat']) && isset($_REQUEST['long'])) 
{

		$uid=$_REQUEST['uid'];		
		$lat = $_REQUEST['lat'];
		$long = $_REQUEST['long'];
		$devid = $_REQUEST['devid'];
		$accuracy= $_REQUEST['accuracy'];
		$provider = $_REQUEST['provider'];
		$sync_id = $_REQUEST['sync_id'];
		$sync_status= $_REQUEST['sync_status'];
		$time = date("Y-m-d H:i:s",strtotime($_REQUEST['created_at']));	
 
		// response Array
		$response = array("lat" => $lat, "success" => 0, "error" => 0);
        // check for user
       
	   if($uid)
		{
		  
			$result = $db->query("INSERT INTO user_current_locations(user_id,latitude,longitude,device_id,accuracy,provider,sync_id,sync_status,created_at) VALUES('$uid', '$lat', '$long', '$devid','$accuracy','$provider','".mysql_escape_string($sync_id)."','".mysql_escape_string($sync_status)."','$time')");
			
			
			if ( $result ) {
				// user found
				// echo json with success = 1
				$response["success"] = 1;
				echo json_encode($response);
			} else {
				 $response["success"] = 0;
				$response["error"] = 1;
				$response["error_msg"] = "Sql Error!";
				echo json_encode($response);
			}
		} 
		else {
				 $response["success"] = 0;
				$response["error"] = 1;
				$response["error_msg"] = "User Id missing";
				echo json_encode($response);
			}

} 
else {

   echo "Access Denied";
}
?>