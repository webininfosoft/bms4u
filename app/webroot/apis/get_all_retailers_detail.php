<?php	

require "database/db_mysql.inc";	
$intCompanyId='275';
$intRetailerId=$_POST['RetailerId'];	
$sql = "SELECT * from retailers where id=$intRetailerId" ;	
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
			$product["phone"] = "Rs.".$db->f("phone");	
			$product["address"] = $db->f("address");	
			$product["profile_image"] = "http://cr.webininfosoft.com/images/".$db->f("profile_image");		
			$product["shop_photo"] = "http://cr.webininfosoft.com/images/".$db->f("shop_photo");			
			$product["deals_in"] = $db->f("deals_in");				
			$product["Turn_over"] = $db->f("Turn_over");					
			$product["categories"] = $db->f("Categories");					
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