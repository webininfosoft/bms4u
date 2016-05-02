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
if(isset($_REQUEST['uid'])) 
{

		$user_id=$_REQUEST['uid'];
		$latitude=$_REQUEST['latitude'];
		$longitude=$_REQUEST['longitude'];				
		$user_image=$_REQUEST['user_image'];
		$user_image_path=$_REQUEST['user_image_path'];
		$time=$_REQUEST['time'];
		$status=$_REQUEST['status'];
		$sync_status="yes";				
		$sync_id=$_REQUEST['sync_id'];

		// response Array
		$response = array("lat" => $latitude, "type"=>$status,"success" => 0, "error" => 0);
        // check for user
        $sqlQuery="INSERT INTO	user_attendance(user_id,latitude,longitude,user_image,user_image_path, time, status, sync_status, sync_id) VALUES('$user_id','$latitude','$longitude','$user_image','$user_image_path','$time','$status','$sync_status','$sync_id')";        
		
        $result = $db->query($sqlQuery); 
		
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
else
{

   echo "Access Denied";
}
?>