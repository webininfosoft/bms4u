<?php	

require "database/db_mysql.inc";	
$intCompanyId=$_REQUEST['company_id'];	
$retailer_per_page=$_REQUEST['retailer_per_page'];	
$intRetailerId=$_REQUEST['retailer_id'];	
if(!$retailer_per_page)
$retailer_per_page=20;

$current_page=$_REQUEST['current_page'];	
if(!$current_page)
	$current_page=1;

	$limit=($current_page-1)*$retailer_per_page;


	 $sql = "SELECT * from retailer_daily_visits,user_profiles where user_profiles.user_id=retailer_daily_visits.user_id and retailer_id='$intRetailerId' and company_id='$intCompanyId' order by created_at desc limit  $limit,$retailer_per_page ";

	$db->query($sql);		

	$response = array();
	if($db->num_rows()>0)
	{
		while ($db->next_record())
		{
			$retailerdailyvisit = array();
			$retailerdailyvisit["id"] = $db->f("id");
			$retailerdailyvisit["retailer_visit_image_path"] = $db->f("retailer_visit_image_path");
			$retailerdailyvisit["fosname"] = $db->f("first_name")." ".$db->f("last_name");
			$retailerdailyvisit["latitude"] = $db->f("latitude");
			$retailerdailyvisit["longitude"] = $db->f("longitude");
			$retailerdailyvisit["sync_id"] = $db->f("sync_id");	
			$retailerdailyvisit["sync_status"] = $db->f("sync_status");				
			$retailerdailyvisit["retailer_visit_image"] = "http://".$_SERVER['SERVER_NAME']."/apis/uploads/retailers/thumbnails/".$db->f("retailer_visit_image");	$retailerdailyvisit["created_at"] = $db->f("created_at");
			
			$response["retailerdailyvisits"][]=$retailerdailyvisit;			
			$response["success"] = 1;
			}					
		}
		else{
				$response["success"] = 0;	
				$response["message"] = "No Daily Visits Found.";	
		}
		echo json_encode($response);exit;
?>