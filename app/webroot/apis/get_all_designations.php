<?php	

	require "database/db_mysql.inc";	
	$intCompanyId=$_REQUEST['company_id'];	
	$intRoleId=$_REQUEST['role_id'];	

	if(isset($intRoleId))
	{


		   $flagtrue=1;
		   $arrDesignationIDs=array();
		   $parentid=$intRoleId;
//		   while($flagtrue)	
//		   {
				$sql="select designation_id from designations_parents where parent_id=$parentid";
				$db->query($sql);
				while($db->next_record())
				{
					$parentid=$db->f('designation_id'); 
					if($parentid)
					{
						$arrDesignationIDs[]=$parentid;
					}
				}
//				else
//				 $flagtrue=0;
			
//		   }
		$strDesigIDs=implode(",",$arrDesignationIDs);
		

		$query="select * from designations where designation!='Retailer' and id in($strDesigIDs)";
		
		$db->query($query);
			



		$response = array();
		if($db->num_rows()>0)
		{
			while ($db->next_record())
			{
				$desg = array();
				$desg["id"] = $db->f("id");

				$desg["designation"]=$db->f("designation");
				$response["designations"][]=$desg;			
				$response["success"] = 1;
				}					
			}
			else{
					$response["success"] = 0;	
					$response["message"] = "No designation found";	
			}
			echo json_encode($response);exit;
	}else
	{
		echo "Access Denied";
	}
?>