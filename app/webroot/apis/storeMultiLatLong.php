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

if(isset($_REQUEST)){
	
	 $allUserLocationsDatas=json_decode($_REQUEST['UserLocationsJSON'], true);
		//print_r($allRetailerDatas);exit;
		foreach($allUserLocationsDatas as $userlocation){
			 	$response = array();
				$uid=$userlocation['user_id'];				
				$lat = $userlocation['latitude'];
				$long = $userlocation['longitude'];
				$devid = $userlocation['device_id'];
				$accuracy= $userlocation['accuracy'];
				$provider = $userlocation['provider'];
				$sync_id = $userlocation['sync_id'];
				$sync_status= $userlocation['sync_status'];
				$time = date("Y-m-d H:i:s",strtotime($userlocation['created_at']));					
				
			$extUserLocationQuery ="select id from user_current_locations where sync_id='".mysql_escape_string($sync_id)."'";
			$result1=$db->query($extUserLocationQuery);

			if($db->num_rows()==0)
			{		

				$sqlQuery = "INSERT INTO user_current_locations(user_id,latitude,longitude,device_id,accuracy,provider,sync_id,sync_status,created_at) VALUES('$uid', '$lat', '$long', '$devid','$accuracy','$provider','$sync_id','$sync_status','$time')";

				$result = $db->query($sqlQuery);

				if ( $result ) {
				// user found
				// echo json with success = 1
					$response["sync_id"] = $sync_id;
					$response["resp_msg"] = 'success';
					$response["sync_status"] = 'yes';
				} else {
					$response["sync_id"] = $sync_id;
					$response["resp_msg"] = 'failed';
					$response["sync_status"] = 'no';
				}
			} 
		else {
				$response["success"] = 0;
				$response["error"] = 1;
				$response["sync_id"] = $sync_id;
				$response["sync_status"] = 'yes';
				$response["error_msg"] = "Record already exist.";

			}
		$allUserRes[]=$response; 
		}

		echo json_encode($allUserRes);
}
?>