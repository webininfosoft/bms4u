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
require_once "database/db_mysql.inc";
if(isset($_POST['retailer_id'])) 
{
		
		// response Array
	   $response = array( "success" => 0, "error" => 0);
        // check for user
       $strKeys='';
	   $strVals='';
	   $netCredit = $_POST['net_amount'];
	   $rid = $_POST['retailer_id'];
	   $oldCredit = $_POST['credit'];
	   $cid = $_POST['company_id'];
	   $uid = $_POST['user_id'];
	   $date = $_POST['date_time'];
	   while(list($key,$val)=each($_POST))
	   {
			$strKeys.=$key.",";
				$strVals.="'".$val."' ,";
			
	   }
	   $strVals=substr($strVals,0,-1);
	   $strKeys=substr($strKeys,0,-1);
	   $result = $db->query("INSERT INTO orders($strKeys) VALUES($strVals)");
       $orderid=$db->insert_id();
	   
	   $sql = $db->query("insert into retailer_accounts(retailer_id,company_id,old_credit,new_credit,date_time,user_id) values('$rid','$cid','$oldCredit','$netCredit','$date','$uid')");
	   
	   
	   
	   
       $update_result = $db->query("Update retailers set credit='$netCredit' where id='$rid'");
		
        if ( $result) {
            // user found
            // echo json with success = 1
			$response["query"] = $sql;
            $response["oid"] = $orderid;
			$response["success"] = 1;
            echo json_encode($response);
        } else {
		$response["query"] = $sql;
            $response["success"] = 0;
            $response["error"] = 1;
            $response["error_msg"] = "Sql Error!";
            echo json_encode($response);
        }
 
} 
else {
			$response["success"] = 0;
			$response["error"] = 1;
            $response["error_msg"] = "Access Denied!";
            echo json_encode($response);
}
?>