<?php
//ambil data
include ('extract.php');

//tentukan K
$K = 4;
$centroid = array();
$newCentroid = array();

//bangkitkan K random centroid
for ($i=0; $i < $K; $i++) { 
    $centroid[$i] = array(rand(0,160),rand(0,160));
    echo "awal centroid ".($i+1)." : ".$centroid[$i][0].", ".$centroid[$i][1]."<br/>";
}
echo "<hr/>";
$jmlLooping = 0;
do {
    $jmlLooping++;
    //looping cari tiap data pada masing-masing centroid  
    for ($i=0; $i < sizeof($dataset); $i++) { 
        $minDist = 1000; //init minDist

        //looping cari jarak dataset[$i] ke tiap centroid
        for ($j=0; $j < sizeof($centroid); $j++) { 
            //distance antara dataset[$i] dan centroid[$j]
            $dist = sqrt(pow($dataset[$i]['x'] - $centroid[$j][0], 2) + pow($dataset[$i]['y'] - $centroid[$j][1], 2));

            //jika minDist lebih besar dari dist
            if ($minDist > $dist) {
                //ganti minDist dengan dist terbaru
                $minDist = $dist;

                //$dataset[$i][2] adalah centroid pada $dataset[$i]
                $dataset[$i][2] = $centroid[$j];
            }
        }
    }

    //inisialisasi newCentroid dengan nilai 0
    $jmlDataCent = array();
    for ($i=0; $i < sizeof($centroid); $i++) {
        $newCentroid[$i] = array(0,0);
        $jmlDataCent[$i] = 0;
    }

    //jumlah x dan y dari data disimpan di newCentroid
    for ($i=0; $i < sizeof($dataset); $i++) {
        $cent = $dataset[$i][2];
        for ($j=0; $j < sizeof($centroid); $j++) { 
            if ($cent == $centroid[$j]) {
                $newCentroid[$j][0] += $dataset[$i]['x'];
                $newCentroid[$j][1] += $dataset[$i]['y'];

                $jmlDataCent[$j]++;
            }
        }
    }

    //x dan y newCentroid dirata-rata
    for ($i=0; $i < sizeof($newCentroid); $i++) { 
        if ($jmlDataCent[$i]>0) {
            $newCentroid[$i][0] = $newCentroid[$i][0] / $jmlDataCent[$i];
            $newCentroid[$i][1] = $newCentroid[$i][1] / $jmlDataCent[$i];
        } else {
            $newCentroid[$i][0] = $centroid[$i][0];
            $newCentroid[$i][1] = $centroid[$i][1];
        }
    }

    //ganti centroid yang ada di data dengan centroid baru
    for ($i=0; $i < sizeof($dataset); $i++) { 
        $cent = $dataset[$i][2];
        for ($j=0; $j < sizeof($centroid); $j++) { 
            if ($cent == $centroid[$j]) {
                $dataset[$i][2] = $newCentroid[$j];
            }
        }
    }

    //pengecekan apakah centroid ada pergeseran lagi
    $sama = true;
    for ($i=0; $i < $K; $i++) { 
        if ($newCentroid[$i][0] != $centroid[$i][0] || $newCentroid[$i][1] != $centroid[$i][1]) {
            $sama = false;
        }
    }

    $centroid = $newCentroid;

    echo "Looping ke ".$jmlLooping."<br/>";
    for ($i=0; $i < sizeof($centroid); $i++) { 
        echo "centroid ".($i+1)." : ".$centroid[$i][0].", ".$centroid[$i][1]."<br/>";
    }
    echo "<hr/>";

} while (!$sama);

//echo "Jumlah Looping Reposition Centroid = ".$jmlLooping."<br/><br/>";

for ($i=0; $i < sizeof($dataset); $i++) { 
    $cent = $dataset[$i][2];
    for ($j=0; $j < sizeof($centroid); $j++) { 
        if ($cent == $centroid[$j]) {
            echo "data : ".$dataset[$i]['x'].", ".$dataset[$i]['y']." -> cluster : ".($j+1)."<br/>";
        }
    }
}
?>