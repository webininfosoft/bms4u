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
	
	 $allUserFeedbacksData=json_decode($_REQUEST['userfeedbackJSON'], true);

		
		foreach($allUserFeedbacksData as $feedback){
			 	$response = array();
				$user_id=$feedback['user_id'];
				$company_id=$feedback['company_id'];
				$name=addslashes($feedback['name']);				
				$phone=$feedback['phone'];
				$email=addslashes($feedback['email']);
				$message=addslashes($feedback['message']);		
				$sync_id=$feedback['sync_id'];				
				$sync_status="yes";				
				$created_at=$feedback['created_at'];	

		$extUserfeedbackQuery ="select id from feedbacks where sync_id='".mysql_escape_string($sync_id)."'";
		$existuserfeedback=$db->query($extUserfeedbackQuery);
			
			
		if($db->num_rows()==0)
		{
				$sqlQuery="INSERT INTO	feedbacks(user_id,company_id,name,phone,email, message, sync_id, sync_status, created_at) VALUES('$user_id','$company_id','$name','$phone','$email','$message','$sync_id','$sync_status','$created_at')";
				
				$result = $db->query($sqlQuery);       			
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