<?php	

require "database/db_mysql.inc";
$intCompanyId=$_REQUEST['company_id'];	
$intRoleId=$_REQUEST['role_id'];	
$Currentuserid=$_REQUEST['user_id'];	


if(isset($intRoleId))
{

	$query="select * from designations where company_id='$intCompanyId'";
	$db->query($query);

	while ($db->next_record())
	{
		$arrDesgn[$db->f("id")]=$db->f("designation");
		
	}
		
 $sql= "select * from users as User join user_profiles as UserProfile on User.id=UserProfile.user_id join users_parent as d on User.id=d.user_id where  User.id != $Currentuserid and d.parent_id=$Currentuserid and d.company_id=".$intCompanyId." and User.role_id='".$intRoleId."' order by UserProfile.first_name asc";

// $sql = "SELECT * from users join user_profiles on users.id = user_profiles.user_id where users.company_id='$intCompanyId' and role_id=$intRoleId order by first_name asc";	
	$xyz=$db->query($sql);
		

		$response = array();
		if($db->num_rows()>0)
		{
			while ($db->next_record())
			{
				$product = array();
				$product["id"] = $db->f("user_id");
				$product["role_id"]=$db->f("role_id");
				$product["designation"]=$arrDesgn[$db->f("role_id")];
				$product["email"] = $db->f("email");
				$product["phone"] = $db->f("phone");	
				$product["address"] = $db->f("address");
				$product["first_name"] = $db->f("first_name");
				$product["last_name"] = $db->f("last_name");
				$product["checkin_status"] = $db->f("checkin_status");				
				$response["users"][]=$product;			
				$response["success"] = 1;
				}					
			}
			else{
					$response["success"] = 0;	
					$response["message"] = "No User Found";	
			}
			echo json_encode($response);exit;
}
else
{
	echo "Access Denied";
}
	

?>