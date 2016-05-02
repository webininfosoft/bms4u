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

function randomPassword($length=6) {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
      return substr(str_shuffle($alphabet),0,$length);
   
}
require_once('Rmail/Rmail.php');
require_once "database/db_mysql.inc";



if(isset($_POST)){
	
	 $allRetailerDatas=json_decode($_POST['retailersJSON'], true);
		//print_r($allRetailerDatas);exit;
		
		foreach($allRetailerDatas as $retl){
			 	$response = array();
				$lati=$retl['latitude'];
				$long=$retl['longitude'];
				$user_id=$retl['user_id'];
				$comp_id=$retl['company_id'];
				$retail_code=$retl['retailer_code'];
				$shop_name=$retl['shop_name'];
				$owner_name=$retl['owner_name'];
				$shop_image=$retl['shop_image'];
				$owner_image=$retl['owner_image'];
				$shop_image_phone=$retl['shop_image_phone'];
				$owner_image_phone=$retl['owner_image_phone'];
				$email=$retl['email'];
				$phone=$retl['phone'];
				$address=$retl['address'];
				$deal_in=$retl['deal_in'];
				$turn_over=$retl['turn_over'];
				$categories=$retl['categories'];
				$sync_status='true';
				$sync_id=$retl['sync_id'];
				$landmark=$retl['landmark'];
				$city=$retl['city'];
				$state=$retl['state'];
				
			$extReailerQuery ="select id from retailers where sync_id='".mysql_escape_string($sync_id)."'";
			$db->query($extReailerQuery);

		if($db->num_rows()==0)
		{
		        $sqlQuery="INSERT INTO retailers(latitude,longitude,user_id,company_id,retailer_code,shop_name,owner_name,shop_image,owner_image,shop_image_phone,	owner_image_phone,email,phone,address,deal_in,turn_over,categories,sync_status,sync_id,created_at,landmark,city,state) VALUES('$lati','$long','$user_id','$comp_id','".mysql_escape_string($retail_code)."','".mysql_escape_string($shop_name)."','".mysql_escape_string($owner_name)."','".mysql_escape_string($shop_image)."','".mysql_escape_string($owner_image)."','".mysql_escape_string($shop_image_phone)."','".mysql_escape_string($owner_image_phone)."','".mysql_escape_string($email)."','".mysql_escape_string($phone)."','".mysql_escape_string($address)."','".mysql_escape_string($deal_in)."','".mysql_escape_string($turn_over)."','".mysql_escape_string($categories)."','$sync_status','".mysql_escape_string($sync_id)."',NOW(),'".mysql_escape_string($landmark)."','".mysql_escape_string($city)."','".mysql_escape_string($state)."')";

	   			$result = $db->query($sqlQuery);
       			$retailerid=$db->insert_id();
				if($result){
					$pass=randomPassword(8);
					$db->query("INSERT INTO users(user_name,user_password,company_id,role,created_at) values('$phone','$pass','$comp_id','Retailer',NOW())");
					$u_id=$db->insert_id();
					$db->query("INSERT INTO user_retailers(retailer_id,user_id) values('$retailerid','".$user_id."')");

					if($u_id){
						   $msg='Dear '.$owner_name.'<br/>';
						   $msg.='Your login id is '.$phone.'<br/>';
						   $msg.='Your login password is '.$pass.'<br/>';
						   $mail = new Rmail();
						   $mail->setFrom('AvdhiCR <info@avadhicr.com>');
						   $mail->setSubject('Your Account Details');
						   $mail->setHTML();
						   $address = $email;
						   $result  = $mail->send(array($address));
					}


					$flagtrue=1;

					while($flagtrue)	
						{
							$sql="select parent_id from users where id=$user_id";
							$db->query($sql);
							if($db->next_record())
							{

								if($db->f('parent_id'))
								{
									$db->query("insert into user_retailers(retailer_id,user_id) values('$retailerid','".$db->f('parent_id')."')");
									$user_id=$db->f('parent_id'); 
								}
								else
								  $flagtrue=0;	
							}
							else
							 $flagtrue=0;
						}


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