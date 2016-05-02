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
if(isset($_POST['shop_name']) && isset($_POST['email'])) 
{
		$uid=$_POST['user_id'];

		/*$uploadpath="uploads/retailers/";
		$str="data:image/png;base64,"; 
		$data=str_replace($str,"",$_POST['shopimage']); 
		$data = base64_decode($data);
		$shopimage='shop_'.mktime().'.png';
		file_put_contents($uploadpath.$shopimage, $data);
		
		$str="data:image/png;base64,"; 
		$data=str_replace($str,"",$_POST['ownerimage']); 
		$data = base64_decode($data);
		$ownerimage='owner_'.mktime().'.png';
		file_put_contents($uploadpath.$ownerimage, $data);
		*/

		// response Array
	   $response = array( "success" => 0, "error" => 0);
        // check for user
       $strKeys='';
	   $strVals='';
	   while(list($key,$val)=each($_POST))
	   {
		//	if($key!='ownerimage' & $key!='shopimage')
	//		{
				$strKeys.=$key.",";
				$strVals.="'".$val."' ,";
	//		}
	   }
	   $strVals=substr($strVals,0,-1);
	   $strKeys=substr($strKeys,0,-1);

	   $result = $db->query("INSERT INTO retailers($strKeys,created_at) VALUES($strVals,NOW())");
       $retailerid=$db->insert_id();
	 
	   $db->query("insert into user_retailers(retailer_id,user_id) values('$retailerid','$uid')");
      $flagtrue=1;
	   while($flagtrue)	
	   {
			$sql="select parent_id from users where id=$uid";
			$db->query($sql);
			if($db->next_record())
			{
				if($db->f('parent_id'))
				{
					$db->query("insert into user_retailers(retailer_id,user_id) values('$retailerid','".$db->f('parent_id')."')");
					$uid=$db->f('parent_id'); 
									$flagtrue=1;	
				}
				else
				$flagtrue=0;	
			}
			else
			 $flagtrue=0;
			
	   }
		
        if ( $result ) {
            // user found
            // echo json with success = 1
            $response["rid"] = $retailerid;
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