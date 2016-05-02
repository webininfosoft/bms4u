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


require_once('Rmail/Rmail.php');
require_once "database/db_mysql.inc";



if(isset($_REQUEST)){
	
	 $allUserChekinsData=json_decode($_REQUEST['usercheckinsJSON'], true);

		
		foreach($allUserChekinsData as $checkin){
			 	$response = array();
				$user_id=$checkin['uid'];
				$company_id=$checkin['company_id'];
				$latitude=$checkin['latitude'];
				$longitude=$checkin['longitude'];				
				$user_image=$checkin['user_image'];
				$user_image_path=$checkin['user_image_path'];
				$time=$checkin['time'];
				$status=$checkin['status'];
				$sync_status="yes";				
				$sync_id=$checkin['sync_id'];
				
			
			$extUsercheckinQuery ="select id from user_attendance where sync_id='".mysql_escape_string($sync_id)."'";
			$existuserchekin=$db->query($extUsercheckinQuery);
			
			
		if($db->num_rows()==0)
		{
				$sqlQuery="INSERT INTO	user_attendance(user_id,company_id,latitude,longitude,user_image,user_image_path, time, status, sync_status, sync_id) VALUES('$user_id','$company_id','$latitude','$longitude','$user_image','$user_image_path','$time','$status','$sync_status','$sync_id')";
				
				if(strcmp($status,"checkin") == 0 )
				{
					$sqlQuery1="UPDATE users SET checkin_status =1 where id=$user_id";
					
				}
				else
				{
					$sqlQuery1="UPDATE users SET checkin_status =0 where id=$user_id";
				}
				
				$result = $db->query($sqlQuery1);
	   			$result = $db->query($sqlQuery);       			
				if($result){
					
					$response["sync_id"] = $sync_id;
					$response["resp_msg"] = 'success';
					$response["sync_status"] = 'yes';
				} else {
					$response["sync_id"] = $sync_id;
					$response["resp_msg"] = 'failed';
					$response["sync_status"] = 'no';
				}
		}
		else
		{
					$response["sync_id"] = $sync_id;
					$response["resp_msg"] = 'allready exist';
					$response["sync_status"] = 'yes';
		}
		$allUserRes[]=$response;
	}

	echo json_encode($allUserRes);
}

?>