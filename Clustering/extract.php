<?php
	$extractfile=file_get_contents("data.txt");
	// echo $extractfile;
	$dataFile = explode("\n", $extractfile);
	// print_r($dataFile);
	// echo "<hr>";
	$i=0;
	$dataSet=array();
	foreach ($dataFile as $key) {
		$keyData = explode(";", $key);
		// print_r($keyData);
		$dataSet[$i]['id']=$keyData[0];
		$dataSet[$i]['x']=$keyData[1];
		$dataSet[$i]['y']=$keyData[2];
		$i++;
	}
?>