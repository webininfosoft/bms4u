<?php 

header('Access-Control-Allow-Origin: *');
error_reporting(2);


	include 'config.php';
	switch($_POST['get_result'])
	{
		case 'user_login':
		$data = login($_POST);
		break;
		case 'add_retailer':
		$data = addRetailer($_POST);
		break;
		case 'list_retailer':
		$data = listRetailer($_POST);
		break;
		default:
		$data = login($_POST);
	}
	
	echo json_encode($data);
	exit;

function login()
{
	/*$userName     = $_POST['username'];
	$password     = $_POST['password'];
	*/
	$userName     = "demo";
	$password     = "demo";
	
	$latitude     = $_POST['Latitude'];
	$longitude    = $_POST['Longitude'];
	$stringDevice = $_POST['stringDevice'];

	$query = "SELECT u.id,u.parent_id,u.company_id,first_name,last_name,email FROM users as u inner join user_profiles as u_p on u.id=u_p.user_id WHERE u.user_name = '$userName' AND u.user_password = '$password'";
	
    $sql= mysql_query($query);
	$rows= mysql_fetch_assoc($sql);
	
	$userId = $rows['user_id'];
	if($rows)
   {
	  $update = "Update user_profiles set latitude = '$latitude', longitude = '$longitude', device_info ='" . mysql_escape_string($stringDevice)."' WHERE user_id = '$userId'";
	  $sqlupdate = mysql_query($update);
	  $arrResults=array("response"=>"success","msg"=>"Login success","data"=>$rows);
   }
   else
   {
		$arrResults=array("response"=>"error","msg"=>"Invalid username or password","data"=>array());
	
   }

	return $arrResults;
}

function addRetailer()
{
	$dsrId = $_POST['currentUserID'];
	$companyId = $_POST['companyId'];
	$firstname = $_POST['fname'];
	$lastname = $_POST['lname'];
	$email = $_POST['remail'];
	$phone = $_POST['rphone'];
	$city = $_POST['rcity'];
	$address = $_POST['raddress'];
	$latitude = $_POST['Latitude'];
	$longitude = $_POST['Longitude'];
	$stringDevice = $_POST['stringDevice'];
	$checkDup = "SELECT * FROM retailers WHERE first_name = '$firstname' OR city = '$city'";
	$sqlcheck = mysql_query($checkDup);
	if(mysql_num_rows($sqlcheck) > 0)
	{
		echo 'error';exit;
	}
	else
	{
		$query = "INSERT INTO retailers (id, dsr_id, company_id, first_name, last_name, email, phone, city, address, latitude, longitude, device_info) VALUES ('', '$dsrId', '$companyId', '$firstname','$lastname','$email','$phone','$city','$address','$latitude','$longitude','$stringDevice')";
		$sql = mysql_query($query);
	}
}

function listRetailer()
{
	$dsrId = $_POST['currentUserID'];
	$query = "SELECT * FROM retailers WHERE dsr_id = '$dsrId'";
	$sql = mysql_query($query);
	while($rows = mysql_fetch_assoc($sql))
	{
		$results[] = $rows;	
	}	
	
     return $results;
}

?>

