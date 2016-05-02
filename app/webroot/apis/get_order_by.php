<?php


require "database/db_mysql.inc";	
$strOrderBy=$_REQUEST['order_by'];	

if($strOrderBy == 'Retailers')
	{
		$sql = "SELECT shop_name, sync_id from retailers ORDER By shop_name ASC";
		$db->query($sql);
		$response = array();
		if($db->num_rows()>0)
			{
				while ($db->next_record())
				{
					$retailer = array();
					$retailer["id"] = $db->f("sync_id");
					$retailer["name"] = $db->f("shop_name");
					$response["orders_by"][]=$retailer;	
					$response["success"] = 1;
				}
			}
	}
else if($strOrderBy == 'Products')
	{
		$sql = "SELECT id,name FROM products ORDER By name ASC";
		$db->query($sql);
		$response = array();
		if($db->num_rows()>0)
			{
				while ($db->next_record())
				{
					$product = array();
					$product["id"] = $db->f("id");
					$product["name"] = $db->f("name");
					$response["orders_by"][]=$product;	
					$response["success"] = 1;
				}
			}
	}
else
	{
		$response["success"] = 0;	
		$response["message"] = "No Retailer/Products Found";	
	}
echo json_encode($response);exit;	
	
?>