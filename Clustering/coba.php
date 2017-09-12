<?php
if(isset($_POST['test']))
{
	// echo $_POST['age'];
// $sale_price = $_POST['age']; // posted value
// $title_insurance = ($sale_price * 0.00575) + 200;

?>
<script type="text/javascript">
		// document.getElementById("title_insurance").value='<? echo $_POST['age'] ; ?>'; 
</script>
<?php     }     ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="POST">
		Name: <input id="title_insurance" type="text" name="name" value="<?=isset($_POST['age'])? $_POST['age'] : null?>">
		Age: <input type="text" name="age">
		<input type="submit" name="test">
	</form>
</body>
</html>