<?php 

$json = array();
require_once "database/db_mysql.inc";	
if (isset($_POST["regId"]))
	{    
		
		$name = "Sukhpal";  
		$email = "sukhpal.m@gmail.com";    
		$gcm_regid = $_POST["regId"];
		$uid = $_POST["uid"];
		// GCM Registration ID    
		// Store user details in db        

		$query="update users set gcmid='$gcm_regid' where id=$uid";
		$db->query($query);

		
		
}?>