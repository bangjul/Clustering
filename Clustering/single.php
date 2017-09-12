<?php
	include("extract.php");
	// print_r($dataSet);
	$n=0;
	for ($n; $n < count($dataSet); $n++) { 
		$dataSet[$n]['cluster']=$n+1;
		//print_r($dataSet);
	}

	if (isset($_POST['K'])) {
	$i=count($dataSet);
		// echo $_POST['K'];
		while ($i>$_POST['K']) {
		//while ($i>$_POST['3']) {
		// $z=0;

			$dis=10000;
			$temp=array();
			$temp1=array();		
			for ($j=0; $j < count($dataSet); $j++) {
				for ($k=$j+1; $k < count($dataSet); $k++) {
					$selisihX=$dataSet[$j]['x']-$dataSet[$k]['x'];
					$selisihY=$dataSet[$j]['y']-$dataSet[$k]['y'];
					$jarak=ceil(sqrt(($selisihX*$selisihX)+($selisihY*$selisihY)));
					if($dis > $jarak && $dataSet[$j]['cluster']!=$dataSet[$k]['cluster']){
						$dis=$jarak;
						$temp=$dataSet[$j];
						$temp1=$dataSet[$k];
					}
				}
			}
			echo 'Cluster : '.$temp1['cluster']."<br>Menjadi :".$temp['cluster']."<br/>Data Sebelum Diganti :<br>";

			foreach ($dataSet as $key) {
				echo $key['cluster']." ";
			}

			for ($n=0; $n < count($dataSet); $n++) { 
				if($dataSet[$n]['cluster'] == $temp1['cluster']){
					$dataSet[$n]['cluster']=$temp['cluster'];
				}
			}
			echo "<br/>Data setelah Diganti :<br>";
			foreach ($dataSet as $key) {
				echo $key['cluster']." ";
			}
			// // print_r($dataSet);
			echo "<hr>";
			$i--;
		}

		$idhasilcluster = array();
		for($x=0 ; $x < count($dataSet); $x++){
			if(!in_array($dataSet[$x]['cluster'], $idhasilcluster)){
				array_push($idhasilcluster,$dataSet[$x]['cluster']);
			}

		}
		print_r($idhasilcluster);
		echo "<br>";


		for($x=0; $x< count($idhasilcluster); $x++){
			$wo = $x +1;
			echo "data cluster ke $wo : ";
			for($y=0 ; $y< count($dataSet); $y++){
				if($dataSet[$y]['cluster']==$idhasilcluster[$x])
					echo $dataSet[$y]['id'] . "  ";					
			}
			echo "<br>";
		}
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="POST">
		Name: <input type="text" name="K">
		<input type="submit" name="test">
	</form>
</body>
</html>