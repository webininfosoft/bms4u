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
if(isset($_POST['from_email'])) 
{
		
		$str="data:image/png;base64,"; 
		$data=str_replace($str,"",$_POST['encodeimage']); 
		$data = base64_decode($data);
		$imagename=mktime().'.png';
		file_put_contents('uploads/merchant/'.$imagename, $data);

		// response Array
		$response = array("data" => $_POST, "success" => 0, "error" => 0);
        // check for user
       $strKeys='';
	   $strVals='';
	   while(list($key,$val)=each($_POST))
	   {
			if($key!='encodeimage')
			{
				$strKeys.=$key.",";
				$strVals.="'".$val."' ,";
			}
			
	   }
	   
	   $strVals=substr($strVals,0,-1);
	   $strKeys=substr($strKeys,0,-1);
	   

	        $url="https://maps.googleapis.com/maps/api/geocode/json?latlng=".$_POST['latitude'].",".$_POST['longitude']."&key=AIzaSyCPQAacV_4exfdD9qyLxxK0Ssypo0_odxs";
			$jsonData   = file_get_contents($url);
			$data = json_decode($jsonData);
			$address=$data->results[0]->formatted_address;

				
			$result = $db->query("INSERT INTO btl_promotions($strKeys,created_at,encodeimage,address) VALUES($strVals,NOW(),'$imagename','".mysql_escape_string($address)."')");
			
			$mail = new Rmail();
			$mail->setFrom($_POST['from_email']);
			$mail->setSubject('New Merchant');
			$mail->setCc('sukhpal.m@gmail.com');
			$mail->setText($_POST['remarks']);
			$file='uploads/merchant/'.$imagename;
			
			$mail->addAttachment(new FileAttachment($file));	
			$result  = $mail->send(array('sukhpal1988@gmail.com','satish.kumar@absasia.in'));
			
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