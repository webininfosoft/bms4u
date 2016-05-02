<?php 
	header('Access-Control-Allow-Origin: *');

	include "database/db_mysql.inc";
	
	$data = login();
	echo json_encode($data);
	exit;

	function login()
	{
		global $db;	
		$arrResults = array();
		
		$userName     = $_GET['username'];
		$password     = $_GET['password'];
		
		
		//$userName     = 'idea';
		//$password     = 'idea';
		
		$latitude     = $_GET['latitude'];
		$longitude    = $_GET['longitude'];
		$stringDevice = $_GET['stringdevice'];

		$sql = "SELECT u.id,u.parent_id,role_id,u.company_id,first_name,last_name,email FROM users as u inner join user_profiles as u_p on u.id=u_p.user_id WHERE u.user_name = '$userName' AND u.user_password = '$password'";
		$db->query($sql);
		
		 // response Array
	    $arrResults = array("tag" => $tag, "success" => 0, "error" => 0);
	
		
	   if($db->next_record())
	   {
		  $data=array("uid"=>$db->f("id"),"role"=>$db->f("role"),"role_id"=>$db->f("role_id"),"parent_id"=>$db->f("parent_id"),"company_id"=>$db->f("company_id"),"name"=>$db->f("first_name")." ".$db->f("last_name"),"email"=>$db->f("email"),"username"=>$db->f("user_name"),"created_at"=>$db->f('created_at'));
		  $arrResults=array("uid"=>$db->f("id"),"success"=>"1","msg"=>"Login success","user"=>$data);
		  
		  
	   }
	   else
	   {
			$arrResults=array("success"=>"0","error"=>"1","error_msg"=>"Invalid username or password","user"=>$_GET);
		
	   }

		return $arrResults;
	}

?>

