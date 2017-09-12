<?php

 	$file = file_get_contents('data.csv');
	$datafile = explode ("\n", $file);
	$dataset = array();

	// print_r($datafile);

	$i=0;

	foreach ($datafile as $key => $row) {

		$row_data = explode(",", $row);

		$dataset[$i]['x'] =  $row_data[0];
		$dataset[$i]['y'] =  $row_data[1];
		
		// print_r($row_data);
		$i++;

	 }

	// print_r($dataset); 


?>