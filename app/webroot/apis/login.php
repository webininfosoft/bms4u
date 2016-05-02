<?php 
	header('Access-Control-Allow-Origin: *');
	error_reporting(2);
	include "database/db_mysql.inc";
	
	$data = login(urldecode($_REQUEST['data']));
	echo json_encode($data);
	exit;

	function login()
	{
		global $db,$db1;	
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

		   if($db->f("login_status")=='1')
		   {
			  $arrResults=array("success"=>"0","login_status"=>$db->f("login_status"),"error"=>"1","error_msg"=>"User already loggedin on another mobile.","user"=>$_REQUEST);
		   }
		   else
		   {
			   $uid = $db->f("user_id");
			   $companyid = $db->f("company_id");
   			   $roleid = $db->f("role_id");
			   
			   //Authentications

			   
			   $db1->query("select * from authentications where auth_type='MOBILE' and user_type_id=$roleid and company_id=$companyid");
			
			   while($db1->next_record())
			   {
					$arrUserAuth[$db1->f("module_id")] = array("perm_view"=>$db1->f("perm_view"),
						"perm_add"=>$db1->f("perm_add"),						
						"perm_designation"=>$db1->f("perm_designation")
						);

			   }

			   // General Settings
			
			$query="select * from company_settings where company_id=$companyid";
			   $db1->query($query);
			   if($db1->next_record())
			   {
					$arrGeneralSettings=array("retailer_per_page"=>$db1->f("retailer_per_page"),"tracking_start_time"=>$db1->f("tracking_start_time"),"tracking_end_time"=>$db1->f("tracking_end_time"),"retailer_radius_check"=>$db1->f("retailer_radius_check"),"retailer_radius_enable"=>$db1->f("retailer_radius_enable"),"tracking_interval"=>$db1->f("tracking_interval"));

			   }

			  $data=array("uid"=>$db->f("user_id"),"role"=>$db->f("role"),"role_id"=>$db->f("role_id"),"parent_id"=>$db->f("parent_id"),"company_id"=>$db->f("company_id"),"name"=>$db->f("first_name")." ".$db->f("last_name"),"email"=>$db->f("email"),"username"=>$db->f("user_name"),"created_at"=>$db->f('created_at'));
			  
			  $arrDealsin=array("0"=>array("dealin"=>"Select"),"1"=>array("dealin"=>"Java"),"2"=>array("dealin"=>"Sales"),"3"=>array("dealin"=>"Market"),"4"=>array("dealin"=>"Design"),"5"=>array("dealin"=>"PHP"),"6"=>array("dealin"=>"WordPress"),"7"=>array("dealin"=>"Sql"),"8"=>array("dealin"=>"Android"));
			  $arrCategories=array("0"=>array("category"=>"Select"),"1"=>array("category"=>"A"),"2"=>array("category"=>"B"),"3"=>array("category"=>"C"));

			  $arrResults=array("auth"=>$arrUserAuth,'settings'=>$arrGeneralSettings,"uid"=>$db->f("user_id"),"success"=>"1","msg"=>"Login success","user"=>$data,"dealsin"=>$arrDealsin,"categories"=>$arrCategories);

			  
			  
			 // $result = $db->query("INSERT INTO user_attendance VALUES(null,'".$db->f("user_id")."', '$latitude', '$longitude', //'$time','login')");

			  $result = $db->query("INSERT INTO user_current_locations(user_id,latitude,longitude,device_id,created_at,accuracy,provider) VALUES('$uid', '$latitude', '$longitude', '$stringDevice','$time','$accuracy','$provider')");

			 // $db->query("update users set login_status=1 where user_name='".$db->f("user_name")."'");
		   }
	   }
	   else
	   {
			$arrResults=array("success"=>"0","error"=>"1","error_msg"=>"Invalid username/password","user"=>$_REQUEST);
		
	   }

		return $arrResults;
	}

?>