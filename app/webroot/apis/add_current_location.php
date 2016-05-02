<?php 

	header('Access-Control-Allow-Origin: *');
	error_reporting(0);
	require_once("db_mysql.inc");
	
	$userid = $_POST['userid'];
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];
	$stringtime = $_POST['time'];
	$type = $_POST['type'];
	
	
	$query = "INSERT INTO user_current_locations  (user_id, latitude, longitude, date_time,type) VALUES ('$userid','$latitude','$longitude','$stringtime','$type')";
	if($db->query($query))
	{
			$arrResults=array("response"=>"success","msg"=>"Insert success","data"=>array());
	)
	else
	{
		$arrResults=array("response"=>"error","msg"=>"Some sql error","data"=>array());
	}
	
	echo json_encode($arrResults);
	exit;
}

?>

