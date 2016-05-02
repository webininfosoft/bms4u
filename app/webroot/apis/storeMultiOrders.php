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
	
	 $allOrdersData=json_decode($_REQUEST['OrdersJSON'], true);
				 
				 
		foreach($allOrdersData as $order){
			 	$response = array();
				$user_id=$order['user_id'];
				$company_id=$order['company_id'];
				$retailer_id=$order['retailer_id'];
				$latitude=$order['latitude'];
				$longitude=$order['longitude'];
				$product_ids=$order['product_ids'];
				$qty=$order['qty'];
				$prices=$order['prices'];
				$order_amount=$order['order_amount'];
				$cheque_paid=$order['cheque_paid'];
				$cash_paid=$order['cash_paid'];
				$credit=$order['net_amount'];
				$date_time=$order['created_at'];
				$net_amount=$order['net_amount'];
				$discount=$order['discount'];
				$remarks=addslashes($order['remarks']);
				$taxes=$order['taxes'];
				$order_source=$order['user_id'];
				$sync_id=$order['sync_id'];				
				$sync_status="yes";					

		$extUserfeedbackQuery ="select id from orders where sync_id='".mysql_escape_string($sync_id)."'";
		$existuserfeedback=$db->query($extUserfeedbackQuery);
			
			
		if($db->num_rows()==0)
		{
				$sqlQuery="INSERT INTO	orders(company_id, user_id, retailer_id, product_ids, qty, prices, order_amount, cheque_paid, cash_paid, credit, latitude, longitude, date_time, net_amount, discount, remarks, taxes, order_source, sync_id, sync_status) VALUES('$company_id','$user_id','$retailer_id','$product_ids','$qty','$prices','$order_amount','$cheque_paid','$cash_paid','$credit','$latitude','$longitude','$date_time','$net_amount','$discount','$remarks','$taxes','$order_source','$sync_id','$sync_status')";
				
				$result = $db->query($sqlQuery); 

				$sql = $db->query("insert into retailer_accounts(retailer_id, company_id, user_id,old_credit, new_credit, date_time) values('$retailer_id','$company_id','$user_id','$credit','$net_amount','$date_time')");
				
     			$update_result = $db->query("Update retailers set credit='$net_amount' where sync_id='$retailer_id'");
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