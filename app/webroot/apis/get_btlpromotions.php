<?php	

require "database/db_mysql.inc";	
$intCompanyId=$_REQUEST['company_id'];	
$btl_per_page=$_REQUEST['btl_per_page'];	
$intUserId=$_REQUEST['user_id'];


if(!$btl_per_page)
$btl_per_page=20;

$current_page=$_REQUEST['current_page'];	
if(!$current_page)
	$current_page=1;

	$limit=($current_page-1)*$btl_per_page;


	 $sql = "SELECT btl_promotions.user_id,btl_promotions.latitude,btl_promotions.longitude,btl_promotions.address,btl_promotions.id,btl_promotions.remarks,btl_promotions.btl_image,btl_promotions.created_at from btl_promotions,btl_parents where btl_parents.btl_id=btl_promotions.id and btl_parents.user_id=$intUserId and company_id='$intCompanyId' order by 	created_at desc limit  $limit,$btl_per_page ";

	$db->query($sql);		

	$response = array();
	if($db->num_rows()>0)
	{
		while ($db->next_record())
		{
			$sql1="SELECT * from user_profiles where user_id= '".$db->f("user_id")."'";
			
			$db1->query($sql1);
			$db1->next_record();
			$btlpromotion = array();
			$btlpromotion["id"] = $db->f("id");
			$btlpromotion["fosname"] = $db1->f("first_name")." ".$db1->f("last_name");
			$btlpromotion["address"] = $db->f("address");			
			$btlpromotion["remarks"] = $db->f("remarks");
			$btlpromotion["btl_image"] = "http://".$_SERVER['SERVER_NAME']."/apis/uploads/merchant/thumbnails/".$db->f("btl_image");			
			$btlpromotion["created_at"] = $db->f("created_at");
		
			$btlpromotion["latitude"] = $db->f("latitude");
			$btlpromotion["longitude"] = $db->f("longitude");
		

				
			$response["btlprmotions"][]=$btlpromotion;			
			$response["success"] = 1;
			}					
		}
		else{
				$response["success"] = 0;	
				$response["message"] = "No  BTL Promotions Found.";	
		}
		
		echo json_encode($response);exit;
?>