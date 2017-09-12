<?php
	$extractfile=file_get_contents("iris.txt");
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
		$dataSet[$i]['a']=$keyData[1];
		$dataSet[$i]['b']=$keyData[2];
		$dataSet[$i]['c']=$keyData[3];
		$dataSet[$i]['d']=$keyData[4];
		$i++;
	}
?>