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
require_once('Rmail/Rmail.php');
if(isset($_REQUEST['user_id'])) 
{
		

		// response Array
		$response = array("data" => $_REQUEST, "success" => 0, "error" => 0);
        // check for user
       $strKeys='';
	   $strVals='';
	   while(list($key,$val)=each($_REQUEST))
	   {
			if(strpos($key,'model_'))
			{
				$str="data:image/png;base64,"; 
				$data=str_replace($str,"",$_REQUEST[$key]); 
				$data = base64_decode($data);
				$imagename=$key."_".mktime().'.png';
				file_put_contents('uploads/merchant/'.$imagename, $data);
				$strKeys.=$key.",";
				$strVals.="'".$imagename."' ,";
			}
			else
		    {
				$strKeys.=$key.",";
				$strVals.="'".$val."' ,";
		    }
			
	   }
	   
	   $strVals=substr($strVals,0,-1);
	   $strKeys=substr($strKeys,0,-1);
	   
			$result = $db->query("INSERT INTO feedbacks($strKeys) VALUES($strVals)");
			
			
			if ( $result ) {
				$response["success"] = 1;
				echo json_encode($response);
			} else {
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