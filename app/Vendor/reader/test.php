<?php

	include ('oleread.inc');
	//print parseExcel("../tempUploadData/userdata.xls");
	$file = new OLERead;
	$x = $file->read("../tempUploadData/userdata.xls");
	print $x;
	if(!$x){
		print "not a file";
	}
?>

