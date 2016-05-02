<?php	

require "database/db_mysql.inc";

$intUserId=$_REQUEST['user_id'];	
$flagsinglelocation=$_REQUEST['flaglocation'];	


if(isset($intUserId))
{

		$startdate=date("Y-m-d 00:00:00");
		$enddate=date("Y-m-d 23:59:59");
		/*
		if($flagsinglelocation==2)
					ECHO $query = "select * from users as a,user_profiles as up, user_current_locations as b where  a.id=up.user_id and a.id=b.user_id and a.id='".$intUserId."' and b.created_at>='$startdate' and b.created_at<='$enddate' order by b.created_at DESC limit 0,1";
		else
					$query = "select * from users as a,user_profiles as up, user_current_locations as b where  a.id=up.user_id and a.id=b.user_id and a.id='".$intUserId."' and b.created_at>='$startdate' and b.created_at<='$enddate' order by b.created_at asc ";
					*/
		if($flagsinglelocation==2)
				$query = "select * from  user_current_locations as b where  b.user_id='".$intUserId."' and b.created_at>='$startdate' and b.created_at<='$enddate' order by b.created_at DESC limit 0,1";
		else
					$query = "select * from user_current_locations as b where b.user_id='".$intUserId."' and b.created_at>='$startdate' and b.created_at<='$enddate' order by b.created_at asc ";
		$db->query($query);

		$arrPrevousLoation=array();

		$Miles= 0.05;
		$response = array();
		// Iterate through the rows, printing XML nodes for each
		while($db->next_record())
		{

				$flagSame="NO";

				if($arrPrevousLoation['lat'])
				{
					$Latitude=$arrPrevousLoation['lat'];
					$Longitude=$arrPrevousLoation['long'];
					$arrLocation=RadiusCheck($Latitude, $Longitude, $Miles);

					if(($db->f('latitude') >= $arrLocation['minLat'] && $db->f('latitude')<= $arrLocation['maxLat']) && ($db->f('longitude') >= $arrLocation['minLong'] && $db->f('longitude')<= $arrLocation['maxLong']))
					{

							$flagSame="YES";
					}
					else
					{
							$flagSame="NO";
						  $arrPrevousLoation['lat']=$db->f('latitude');
						  $arrPrevousLoation['long']=$db->f('longitude');

					}
			
				}
				else
				{
					  $arrPrevousLoation['lat']=$db->f('latitude');
					  $arrPrevousLoation['long']=$db->f('longitude');
	  			}

				if($flagSame=='NO')
				{
					$result = array();

					$result["latitude"]=$db->f('latitude');
					$result["longitude"]=$db->f('longitude');
					$response["users"][]=$result;			
					$response["success"] = 1;

				}
				
		
		}

		if(count($response)==0)
				$response["success"] = 0;

		echo json_encode($response);exit;
		

}
else
{
	echo "Access Denied";
}
	
function RadiusCheck($Latitude, $Longitude, $Miles) 
	{
		$EQUATOR_LAT_MILE = 69.172;
		$maxLat = $Latitude + $Miles / $EQUATOR_LAT_MILE;
		$minLat = $Latitude - ($maxLat - $Latitude);
		$maxLong = $Longitude + $Miles / (cos($minLat * M_PI / 180) * $EQUATOR_LAT_MILE);
		$minLong = $Longitude - ($maxLong - $Longitude);
		return(array("minLat"=>$minLat,"maxLat"=>$maxLat,"minLong"=>$minLong,"maxLong"=>$maxLong));
	}
?>