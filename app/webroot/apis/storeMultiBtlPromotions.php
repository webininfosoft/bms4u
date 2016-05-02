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
	
	 $allBTLPromotionDatas=json_decode($_REQUEST['BTLPromotionJSON'], true);
		
		foreach($allBTLPromotionDatas as $btl){
			 	$response = array();
				$user_id=$btl['user_id'];
				$company_id=$btl['company_id'];
				$latitude=$btl['latitude'];
				$longitude=$btl['longitude'];				
				$remarks=$btl['remarks'];
				$email=$btl['email'];
				$devid=$btl['devid'];
				$btl_image=$btl['btl_image'];
				$btl_image_path=$btl['btl_image_path'];
				$btl_image_status=$btl['btl_image_status'];
				$sync_status="yes";
				$sync_id=$btl['sync_id'];
				$created_at=$btl['created_at'];
				
				$url="https://maps.googleapis.com/maps/api/geocode/json?latlng=".$_POST['latitude'].",".$_POST['longitude']."&key=AIzaSyCPQAacV_4exfdD9qyLxxK0Ssypo0_odxs";
			//	$jsonData   = file_get_contents($url);
			//	$data = json_decode($jsonData);								
			//	$address=$data->results[0]->formatted_address;
				$address="";
				
			$extBTLQuery ="select id from btl_promotions where sync_id=$sync_id";
			$existBTL = $db->query($extBTLQuery);

		if($db->num_rows()==0)
		{
				$sqlQuery="INSERT INTO	btl_promotions(user_id, company_id, address,email,remarks,latitude,longitude, btl_image, 			btl_image_path, btl_image_status, sync_status, sync_id, devid, created_at) VALUES('$user_id','$company_id','$address','$email','$remarks','$latitude','$longitude','$btl_image','$btl_image_path',
				'$btl_image_status','$sync_status','$sync_id','$devid','$created_at')";
				$result = $db->query($sqlQuery);			
	   			$btl_id=$db->insert_id();

				$flagtrue=1;

				   while($flagtrue)	
				   {
						$sql="select parent_id from users where id=$user_id";						
						$db->query($sql);
						if($db->next_record())
						{
							if($db->f('parent_id'))
							{
								$db->query("insert into btl_parents(btl_id,user_id) values('$btl_id','".$db->f('parent_id')."')");
								$user_id=$db->f('parent_id'); 
							}
							else
							  $flagtrue=0;	
						}
						else
						 $flagtrue=0;
					
				   }
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