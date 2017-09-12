<html>
  <head> 
  <title>Truncate</title>
  </head>
  <body>
	<?php
		include 'db_connection.php';
		?>
	    <?php
        		
				// Truncate Table
				$sql_truncate="TRUNCATE TABLE sheet1";
				$result_truncate = mysql_query($sql_truncate) or die(mysql_error()); 
				// Truncate Table user_details
				$sql_truncate="TRUNCATE TABLE sheet2";
				$result_truncate = mysql_query($sql_truncate) or die(mysql_error()); 
?>    
    
  </body>
</html>
