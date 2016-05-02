<?php
require_once 'reader.php';

function parseExcel($excel_file_name_with_path)
{

	$data = new Spreadsheet_Excel_Reader();
	// Set output Encoding.
	$data->setOutputEncoding('CP1251');
	$data->read($excel_file_name_with_path);


	for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
		for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
		
			$product[$i-1][$j-1]=$data->sheets[0]['cells'][$i][$j];

		}
	}

	return $product;
}