<?php
	include("index.php");
	include("extract.php");
	// print_r($dataSet);
	$n=0;
	for ($n; $n < count($dataSet); $n++) { 
		$dataSet[$n]['cluster']=$n+1;
		//print_r($dataSet);
	}

	if (isset($_POST['K'])) {
		echo "<p>Banyaknya kelas yang ingin di buat : ";
		echo $_POST['K'];
		echo "</p>";
		echo "<hr>";
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
			//echo 'Cluster : '.$temp1['cluster']."<br>Menjadi :".$temp['cluster']."<br/>Data Sebelum Diganti :<br>";

			foreach ($dataSet as $key) {
				//echo $key['cluster']." ";
			}

			for ($n=0; $n < count($dataSet); $n++) { 
				if($dataSet[$n]['cluster'] == $temp1['cluster']){
					$dataSet[$n]['cluster']=$temp['cluster'];
				}
			}
			//echo "<br/>Data setelah Diganti :<br>";
			foreach ($dataSet as $key) {
				//echo $key['cluster']." ";
			}
			// // print_r($dataSet);
			//echo "<hr>";
			$i--;
		}

		$idhasilcluster = array();
		for($x=0 ; $x < count($dataSet); $x++){
			if(!in_array($dataSet[$x]['cluster'], $idhasilcluster)){
				array_push($idhasilcluster,$dataSet[$x]['cluster']);
			}

		}
		//print_r($idhasilcluster);
		//echo "<br>";


		for($x=0; $x< count($idhasilcluster); $x++){
			$wo = $x +1;
			//echo "data cluster ke $wo ($idhasilcluster[$x]): ";
			echo "<p>Data cluster ke $wo : ";
			for($y=0 ; $y< count($dataSet); $y++){
				if($dataSet[$y]['cluster']==$idhasilcluster[$x])
					echo $dataSet[$y]['id'] . "  ";					
			}
			echo "</p>";
		}

		echo "<hr>";


		$dis=10000;
		//$temp3=array();
		//$temp4=array();
		for($a=0 ; $a < count($idhasilcluster) ; $a++){
			for($b=$a+1 ; $b < count($idhasilcluster) ; $b++){

				for($x=0 ; $x < count($dataSet); $x++){
					for($y=$x+1 ; $y < count($dataSet); $y++){
						//if($dataSet[$x]['cluster']!=$dataSet[$y]['cluster']){
								$selisihX=$dataSet[$x]['x']-$dataSet[$y]['x'];
								$selisihY=$dataSet[$x]['y']-$dataSet[$y]['y'];
								$jarak=ceil(sqrt(($selisihX*$selisihX)+($selisihY*$selisihY)));
								if($dataSet[$x]['cluster']==$idhasilcluster[$a]){
									// echo $dataSet[$x]['cluster'];
									// echo "<br>";
									if($dataSet[$y]['cluster']==$idhasilcluster[$b]){
											if($dis > $jarak && $dataSet[$x]['cluster'] != $dataSet[$y]['cluster'] ){
										
										$dis=$jarak;
										
										// echo $dataSet[$x]['id'];
										// echo ";";
										// echo $dataSet[$y]['id'];
										// echo ";";
										// echo "$dis <br>";	
										}
									}
								}
							
							}
						}
					echo "<p>Jarak terdekat kelas ";
					echo $a+1;
					echo " ke ";
					echo $b+1;
					echo " : ";		
					echo " $dis <br></p>";
					$dis = 100000;
			}
		}
		
	}
	
?>
<!-- <!DOCTYPE html>
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
</html> -->