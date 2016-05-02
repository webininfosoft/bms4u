<?php


require "database/db_mysql.inc";	
$intCompanyId=$_REQUEST['company_id'];	

$orders_per_page=$_REQUEST['orders_per_page'];	
if(!$orders_per_page)
$orders_per_page=20;
$rid=$_REQUEST['retailer_id'];
$pid=$_REQUEST['product_id'];


$current_page=$_REQUEST['current_page'];	
if(!$current_page)
	$current_page=1;

	$limit=($current_page-1)*$orders_per_page;
		if($rid!='null')
		{			
			$sql = "SELECT orders.company_id, orders.product_ids, orders.qty, orders.prices, orders.order_amount, orders.cheque_paid, orders.cash_paid, orders.date_time, orders.discount,orders.taxes,orders.net_amount,user_profiles.first_name, user_profiles.last_name, retailers.shop_name, retailers.address, retailers.credit,retailers.email,retailers.phone from orders,user_profiles,retailers where user_profiles.user_id=orders.user_id and orders.company_id='$intCompanyId' and orders.retailer_id=retailers.sync_id and orders.retailer_id='$rid' order by date_time desc limit  $limit,$orders_per_page ";
			
		}
		else if($pid!='null')
		{				
			$sql = "SELECT orders.company_id, orders.product_ids, orders.qty, orders.prices, orders.order_amount, orders.cheque_paid, orders.cash_paid, orders.date_time, orders.discount,orders.taxes,orders.net_amount,user_profiles.first_name, user_profiles.last_name, retailers.shop_name, retailers.address, retailers.credit,retailers.email,retailers.phone from orders,user_profiles,retailers where user_profiles.user_id=orders.user_id and orders.company_id='$intCompanyId' and orders.retailer_id=retailers.sync_id and orders.product_ids LIKE '%#".$pid."#%' order by date_time desc limit  $limit,$orders_per_page ";
			
		}
		else
		{
			$sql = "SELECT orders.company_id, orders.product_ids, orders.qty, orders.prices, orders.order_amount, orders.cheque_paid, orders.cash_paid, 		orders.date_time, orders.discount,orders.taxes,orders.net_amount,user_profiles.first_name, user_profiles.last_name, retailers.shop_name, retailers.address, retailers.credit,retailers.email,retailers.phone from orders,user_profiles,retailers where user_profiles.user_id=orders.user_id and orders.company_id='$intCompanyId' and orders.retailer_id=retailers.sync_id order by date_time desc limit  $limit,$orders_per_page ";
		}
		
		$db->query($sql);
		$response = array();
		if($db->num_rows()>0)
		{
			while ($db->next_record())
			{
				$orders = array();
				$pid=substr(str_replace("#","",$db->f("product_ids")),0,-1);				
				$sqlproduct= "select name from products where id IN(".$pid.")";
				$db1->query($sqlproduct);
				 if($db1->num_rows()>0)
					{
						$strProductname="";
						while($db1->next_record())
							{
								$strProductname=$strProductname.$db1->f("name").",";
							}
					}
				else
					{
						$strProductname="";
					}
				
				 $orders["company_id"] = $db->f("company_id");
				 $orders["product_names"] = $strProductname;				
				 $orders["qty"] = $db->f("qty");
				 $orders["prices"] = $db->f("prices");
				 $orders["order_amount"] = $db->f("order_amount");	
				 $orders["cheque_paid"] = $db->f("cheque_paid");				
				 $orders["cash_paid"] = $db->f("cash_paid");
				 $orders["credit"] = $db->f("credit");
				 $orders["fosname"] = $db->f("first_name")." ".$db->f("last_name");
				 $orders["date_time"] = $db->f("date_time");
				 $orders["discount"] = $db->f("discount");
				 $orders["shop_name"] = $db->f("shop_name");
				 $orders["address"] = $db->f("address");
				 $orders["phone"] = $db->f("phone");
				 $orders["email"] = $db->f("email");
				 $orders["taxes"] = $db->f("taxes");
				 $orders["net_amount"] = $db->f("net_amount");
				
				$response["orders"][]=$orders;			
				$response["success"] = 1;
				}					
			}
			else{
					$response["success"] = 0;	
					$response["message"] = "No Orders Found.";	
		}

		echo json_encode($response);exit;
?>