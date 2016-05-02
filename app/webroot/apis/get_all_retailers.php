<?php	

require "database/db_mysql.inc";	
$intUserId=$_REQUEST['user_id'];	
$retailer_per_page=$_REQUEST['retailer_per_page'];	
$search=$_REQUEST['search'];	
if(!$retailer_per_page)
$retailer_per_page=20;

$current_page=$_REQUEST['current_page'];	
if(!$current_page)
$current_page=1;

$limit=($current_page-1)*$retailer_per_page;

if($search!='null' && $search )
$searchquery=" and shop_name like '%$search%' ";
else
$searchquery="";
$sql = "SELECT * from retailers,user_retailers where user_retailers.retailer_id=retailers.id and user_retailers.user_id=$intUserId $searchquery order by shop_name asc limit $limit,$retailer_per_page";	
$db->query($sql);		

	$response = array();
	if($db->num_rows()>0)
	{
		while ($db->next_record())
		{
			$product = array();
			$product["id"] = $db->f("id");
			$product["shop_name"] = $db->f("shop_name");
			$product["owner_name"] = $db->f("owner_name");
			
			if($db->f("latitude"))
			{
				$product["latitude"] = $db->f("latitude");
				$product["longitude"] = $db->f("longitude");
			}
			else
			{
				$product["latitude"] = $db->f("web_latitude");
				$product["longitude"] = $db->f("web_longitude");
			}
			
			
			$product["email"] = $db->f("email");
			$product["phone"] = $db->f("phone");	

			$product["sync_id"] = $db->f("sync_id");	
			$product["sync_status"] = $db->f("sync_status");	

			$product["address"] = $db->f("address");	
			$product["owner_image"] = "http://".$_SERVER['SERVER_NAME']."/apis/uploads/retailers/thumbnails/".$db->f("owner_image");		
			$product["shop_image"] = "http://".$_SERVER['SERVER_NAME']."/apis/uploads/retailers/thumbnails/".$db->f("shop_image");			
			$product["owner_image_phone"] = $db->f("owner_image_phone");		
			$product["shop_image_phone"] = $db->f("shop_image_phone");			

			$product["created_at"] = $db->f("created_at");			

 

			$product["deal_in"] = $db->f("deal_in");				
			$product["turn_over"] = $db->f("turn_over");					
			$product["categories"] = $db->f("categories");
            $product["credit"] = $db->f("credit");			
			$product["retailer_code"] = $db->f("retailer_code");
			$product["landmark"] = $db->f("landmark");
			$product["city"] = $db->f("city");
			$product["state"] = $db->f("state");
			
			$sql="select first_name,last_name from user_profiles where user_id=".$db->f("user_id");
			$db1->query($sql);
			$db1->next_record();
			$product["fos_name"] = $db1->f("first_name")." ".$db1->f("last_name");				
			
			$response["products"][]=$product;			
			$response["success"] = 1;
			}					
		}
		else{
				$response["success"] = 0;	
				$response["message"] = "No retailer found";	
		}
		echo json_encode($response);exit;
?>