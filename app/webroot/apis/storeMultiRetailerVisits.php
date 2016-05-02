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
	
	 $allRetailerDatas=json_decode($_REQUEST['retailersMarkVisitJSON'], true);

		
		foreach($allRetailerDatas as $retl){
			 	$response = array();
				$lati=$retl['latitude'];
				$long=$retl['longitude'];
				$user_id=$retl['user_id'];
				$comp_id=$retl['company_id'];
				$retail_code=$retl['retailer_id'];
				$retailer_visit_image=$retl['retailer_visit_image'];
				$shop_image_phone=$retl['retailer_image_path'];
				$sync_status="yes";
				$sync_id=$retl['sync_id'];
				$created_at=$retl['created_at'];
				
			$extReailerQuery ="select id from retailer_daily_visits where sync_id=$sync_id";
			$existRetailer = $db->query($extReailerQuery);

		if($db->num_rows()==0)
		{
				$sqlQuery="INSERT INTO	retailer_daily_visits(latitude,longitude,user_id,company_id,retailer_id,retailer_visit_image,retailer_visit_image_path,sync_status,sync_id,created_at) VALUES('$lati','$long','$user_id','$comp_id','$retail_code','$retailer_visit_image','$shop_image_phone','$sync_status','$sync_id','$created_at')";

	   			$result = $db->query($sqlQuery);
       			$retailerid=$db->insert_id();
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