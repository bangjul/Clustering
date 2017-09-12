<html>

<head>
  <meta charset="UTF-8">
  <title>Ruspini</title>
      <link rel="stylesheet" href="css/style.css">
</head>
<body>

 <div class="container">  
  <form id="contact" action="proses.php" method="post">
    <h3>Hierarchical Clustering</h3>
    <h4>Single Linkage</h4>
    <fieldset>
      <input placeholder="Masukkan Jumlah cluster" type="text" tabindex="1" required name="K">
      <input type="radio" name="data" value="ruspini"> Ruspini<br>
      <input type="radio" name="data" value="iris"> Iris<br>
    </fieldset>

    <fieldset>
      <button name="submit" type="submit" value="Proses">Submit</button>
    </fieldset>
    
  </form>
</div>
  
</body>
</html>