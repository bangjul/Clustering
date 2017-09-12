<html>
  <head> 
  <title>Save Excel file details to the database</title>
  </head>
  <body>
	<?php
		include 'db_connection.php';
		include 'truncate.php';
    	$excel = new Spreadsheet_Excel_Reader();
	?>
	    <table border="1">
		<?php
            $excel->read('sample.xls');    
			$x=2;
			while($x<=$excel->sheets[0]['numRows']) {
				$name = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
				$job = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
				$email = isset($excel->sheets[0]['cells'][$x][3]) ? $excel->sheets[0]['cells'][$x][3] : '';
				
				// Save details
				$sql_insert="INSERT INTO sheet1 (id,name,job,email) VALUES ('','$name','$job','$email')";
				$result_insert = mysql_query($sql_insert) or die(mysql_error()); 
				 
			  $x++;
			}
			 $excel->read('sample.xls');    
			$x=2;
			while($x<=$excel->sheets[1]['numRows']) {
				$nama = isset($excel->sheets[1]['cells'][$x][1]) ? $excel->sheets[1]['cells'][$x][1] : '';
				$negara = isset($excel->sheets[1]['cells'][$x][2]) ? $excel->sheets[1]['cells'][$x][2] : '';
				$umur = isset($excel->sheets[1]['cells'][$x][3]) ? $excel->sheets[1]['cells'][$x][3] : '';
				
				
				// Save details
				$sql_insert="INSERT INTO sheet2 (id,nama,negara,umur) VALUES ('','$nama','$negara','$umur')";
				$result_insert = mysql_query($sql_insert) or die(mysql_error()); 
				 
			  $x++;
			}
echo '<br>(Data telah masuk ke dalam databse secara otomatis)';
        ?>    
    </table>

  </body>
</html>
