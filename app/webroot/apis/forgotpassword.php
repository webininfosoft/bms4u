<?php 
	header('Access-Control-Allow-Origin: *');

	include "database/db_mysql.inc";
	
	$data = login(urldecode($_REQUEST['data']));
	echo json_encode($data);
	exit;

	function login()
	{
		global $db;	
		$arrResults = array();
		
		$userName     = $_REQUEST['email'];
		$password     = $_REQUEST['password'];
		
		$latitude     = $_REQUEST['lat'];
		$longitude    = $_REQUEST['long'];
		$stringDevice = $_REQUEST['devid'];
		$time=$_REQUEST['login_time'];
		$accuracy=$_REQUEST['accuracy'];
		$provider=$_REQUEST['provider'];
		

		$sql = "SELECT * FROM users as u inner join user_profiles as u_p on u.id=u_p.user_id WHERE u.user_name = '$userName' AND u.user_password = '$password'";
		$db->query($sql);
		
		 // response Array
	    $arrResults = array("tag" => $tag, "success" => 0, "error" => 0);
	
		
	   if($db->next_record())
	   {
		   $uid=$db->f("user_id");
				  
		  $data=array("uid"=>$db->f("user_id"),"role"=>$db->f("role"),"role_id"=>$db->f("role_id"),"parent_id"=>$db->f("parent_id"),"company_id"=>$db->f("company_id"),"name"=>$db->f("first_name")." ".$db->f("last_name"),"email"=>$db->f("email"),"username"=>$db->f("user_name"),"created_at"=>$db->f('created_at'));
		  $arrResults=array("uid"=>$db->f("user_id"),"success"=>"1","msg"=>"Login success","user"=>$data);

		  $result = $db->query("INSERT INTO user_attendance VALUES(null,'".$db->f("user_id")."', '$latitude', '$longitude', '$time','login')");

		  $result = $db->query("INSERT INTO user_current_locations(user_id,latitude,longitude,device_id,date_time,type,accuracy,provider) VALUES('$uid', '$latitude', '$longitude', '$stringDevice','$time','login','$accuracy','$provider')");

	   }
	   else
	   {
			$arrResults=array("success"=>"0","error"=>"1","error_msg"=>"Invalid username or password","user"=>$_REQUEST);
		
	   }

		return $arrResults;
	}

?>