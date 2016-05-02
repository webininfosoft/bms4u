<?php	require "database/db_mysql.inc";	


	$intCompanyId=$_REQUEST['company_id'];	
	IF(isset($intCompanyId))
	{
		$sql = "SELECT * from products where company_id=$intCompanyId order by name asc";
		$db->query($sql);
		$response = array();	
		if($db->num_rows()>0)	{	
			while ($db->next_record())		{			
			$product = array();			
			$product["pid"] = $db->f("id");			
			$product["name"] = $db->f("name");	
			$product["qty_in_stock"] = $db->f("qty_in_stock");	
			$product["sku"] = $db->f("sku");
			$product["product_image"] = "http://cr.webininfosoft.com//images/upload/product/".$db->f("product_image");				$product["description"] = $db->f("description");				$product["price"] = $db->f("price");						$response["products"][]=$product;			$response["success"] = 1;		}					}	else	{		$response["success"] = 0;		$response["message"] = "No products found";	}			echo json_encode($response);exit;
	}
	else
	echo "Access Denied";
?>