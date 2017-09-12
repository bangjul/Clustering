<!DOCTYPE html>
<html>
<head>

	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style>
	hr { 
	    display: block;
	    margin-top: 0.5em;
	    margin-bottom: 0.5em;
	    margin-left: auto;
	    margin-right: auto;
	    border-style: inset;
	    border-width: 10px;
	} 
</style>
</head>
<body style="padding: 10px">
<?php

include("extract.php");

// print_r($dataSet);
$cek=false;
$centroid=array(array());
$minX=99999;
$minY=99999;
$maxX=0;
$maxY=0;
foreach ($dataSet as $key) {
	if($minX > $key['x']){
		$minX=$key['x'];
	}
	if($minY > $key['y']){
		$minY=$key['y'];
	}
	if($maxX < $key['x']){
		$maxX=$key['x'];
	}
	if($maxY < $key['y']){
		$maxY=$key['y'];
	}
}

for ($j=0;$j <3;$j++) {
	$centroid[$j]['x']=rand((int) $minX,(int)$maxX);
	$centroid[$j]['y']=rand((int)$minY,(int)$maxY);
}

do{
	if(isset($centroid2)){
		for ($j=0;$j <3;$j++) {
			$centroid[$j]['x']=$centroid2[$j]['x'];
			$centroid[$j]['y']=$centroid2[$j]['y'];
		}
	}

	for ($i=0 ; $i<count($dataSet);$i++) {
		$jarak=array();
		foreach ($centroid as $keyCentroid) {
			$selisihX=$dataSet[$i]['x']-$keyCentroid['x'];
			$selisihY=$dataSet[$i]['y']-$keyCentroid['y'];
			array_push($jarak, ceil(sqrt(($selisihX*$selisihX)+($selisihY*$selisihY))));
		}
		$hasil=9999;
		for ($j=0; $j < sizeof($jarak); $j++) { 
			if($hasil > $jarak[$j]){
				$hasil=$jarak[$j];
				// echo "$hasil ";
				$dataSet[$i]['cluster']=$j+1;
			}
		}
	}

	$jum=array();
	$centroid2=array();
	for ($j=0;$j <3;$j++) {
		$n=0;
		$sumX=0;//5
		$sumY=0;//10
		foreach ($dataSet as $key) {
			if ($key['cluster']==($j+1)) {
				$sumY=$sumY+$key['y'];
				$sumX+=$key['x'];
				$n++;
				// $jum[$j]=$n;
			}
		}
		$centroid2[$j]['x']=ceil($sumX/$n);
		$centroid2[$j]['y']=ceil($sumY/$n);
	}
	
echo "<div class='row'>
		<div class='col-md-2 table-responsive'>
		<strong> centroid 1</strong>
			<table class='table table-striped' border='1'>
				<thead>
					<tr class='success'>
						<th style='text-align: center;'>centroid</th>
						<th style='text-align: center;'>x</th>
						<th style='text-align: center;'>y</th>
					</tr>
				</thead>
				<tbody>";
					$x=1;
				foreach ($centroid as $key) {
				echo "<tr>
						<td>$x</td>
						<td>".$key['x']."</td>
						<td>".$key['y']."</td>
					</tr>
					<tr>";
					$x++;
				}
				echo "</tbody>
			</table>
		</div>
		<div class='col-md-2 table-responsive'>
		<strong> centroid 2</strong>
			<table class='table table-striped' border='1'>
				<thead>
					<tr class='success'>
						<th style='text-align: center;'>centroid</th>
						<th style='text-align: center;'>x</th>
						<th style='text-align: center;'>y</th>
					</tr>
				</thead>
				<tbody>";
					$x=1;
				foreach ($centroid2 as $key) {
				echo "<tr>
						<td>$x</td>
						<td>".$key['x']."</td>
						<td>".$key['y']."</td>
					</tr>
					<tr>";
					$x++;
				}
				echo "</tbody>
			</table>
		</div>";
	
echo "<div class='col-md-12 table-responsive'>
		<strong> Data Set</strong>
			<table id='example' class='table table-striped' border='1'>
				<thead>
					<tr class='success'>
						<th style='text-align: center;'>Data</th>
						<th style='text-align: center;'>x</th>
						<th style='text-align: center;'>y</th>
						<th style='text-align: center;'>CLUSTER</th>

					</tr>
				</thead>
				<tbody>";
					$x=1;
				foreach ($dataSet as $key) {
				echo "<tr>
						<td>$x</td>
						<td>".$key['x']."</td>
						<td>".$key['y']."</td>
						<td>".$key['cluster']."</td>
					</tr>
					<tr>";
					$x++;
				}
				echo "</tbody>
			</table>
		</div>
	</div>";
// print_r($dataSet);	
echo "<hr>";
}while(($centroid[0]!=$centroid2[0]) && ($centroid[1]!=$centroid2[1]) && ($centroid[2]!=$centroid2[2]));

// print_r($dataSet);	
?>
</body>
</html>
