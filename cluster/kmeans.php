<?php
	
	include ('extract.php');

	$centroid = array();
	
	$k= 2;


	//membuat centroid awal

	for ($i=0; $i < $k ; $i++) { 
		
		$centroid[$i] = array(rand(0,150), rand(0,150));
		 echo "awal centroid ".($i+1)." : ".$centroid[$i][0].", ".$centroid[$i][1]."<br/>";

	}
	
	// untuk mendapatkan centroid dengan data 

	for ($i=0; $i <sizeof($dataset) ; $i++) { 

		$jarak= array();

		for ($j=0; $j <sizeof($centroid) ; $j++) {
			$hasiljarak = sqrt(pow($dataset[$i]['x']-$centroid[$j][0], 2) + pow($dataset[$i]['y']-$centroid[$j][1], 2));
			array_push($jarak, ceil($hasiljarak));
		}
		$tamp=1000000;
		for ($m=0 ; $m <= count($jarak)-1  ; $m++ ) {

			if ($tamp > $jarak[$m]) {
				$tamp=$jarak[$m];
				$dataset[$i]['cluster'] = $m+1;


				

			}
		}


	$centroidnew = array();
	$jumlahdatacent= array();

	for ($i=0; $i < sizeof($centroid); $i++) {
        $centroidnew[$i] = array(0,0);
        $jumlahdatacent[$i] = 0;
    }

    for ($i=0; $i < sizeof($dataset); $i++) {
        $cent = $dataset[$i][2]; 
        for ($j=0; $j < sizeof($centroid); $j++) { 
            if ($cent == $centroid[$j]) {
                $centroidnew[$j][0] += $dataset[$i][0];
                $centroidnew[$j][1] += $dataset[$i][1];

                $jumlahdatacent[$j]++;
            }
        }
    }

     for ($i=0; $i < sizeof($centroidnew); $i++) { 
        if ($jumlahdatacent[$i]>0) {
            $centroidnew[$i][0] = $centroidnew[$i][0] / $jumlahdatacent[$i];
            $centroidnew[$i][1] = $centroidnew[$i][1] / $jumlahdatacent[$i];
        }
    }


    for ($i=0; $i < sizeof($dataset); $i++) { 
        $cent = $dataset[$i][2];
        for ($j=0; $j < sizeof($centroid); $j++) { 
            if ($cent == $centroid[$j]) {
                $dataset[$i][2] = $centroidnew[$j];
            }
        }
    }

    $sama = true;
    for ($i=0; $i < $K; $i++) { 
        if ($newCentroid[$i][0] != $centroid[$i][0] || $newCentroid[$i][1] != $centroid[$i][1]) {
            $sama = false;
        }
    }

    $centroid = $newCentroid;






		// for ($i=0; $i < 2 ; $i++) { 
		// 	$n= 0;
		// 	$sumx=0;
		// 	$sumy=0;
		// 	foreach ($dataset as $key){
		// 		if ($key['cluster']==($i+1)) {
		// 			$sumy+=$key['y'];
		// 			$sumx+=$key['x'];
		// 			$n++;
		// 		}
		// 	}
		// 	$centroidnew[$i]['x']= ceil($sumx/$n);
		// 	$centroidnew[$i]['y']= ceil($sumy/$n);


		}




		






	
	
?>
