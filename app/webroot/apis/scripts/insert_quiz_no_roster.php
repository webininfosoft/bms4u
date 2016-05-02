<?php
error_reporting(0);
require_once "../database/db_mysql.inc";

$getdata=$_POST['data'];

if($getdata)
{
	$rowData=explode("||",$getdata);

	while(list($key,$val)=each($rowData))
	{
		$row=explode('&&',$val);

		if($row[5])
		{
			$timestamp=$row[5];
		}
		else
			$timestamp=date('Y-m-d H:i:s');


		$query="INSERT INTO quiz_no_roster(activity_id,question_id,answer,correct,score,date_added,first_name,last_name,email,group_id) VALUES('".$row[4]."','".mysql_escape_string($row[6])."','".mysql_escape_string($row[7])."','".mysql_escape_string($row[8])."',$row[9],'$timestamp','$row[1]','$row[0]','$row[2]','$row[3]')";
		$db->query($query);
	}
}
exit;
?>