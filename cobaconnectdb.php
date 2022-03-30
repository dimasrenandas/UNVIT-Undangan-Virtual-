<html>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="font-awesome-4.5.0/css/font-awesome.css">
<body>



<?php 

    $link = mysqli_connect("localhost","unvit","undanganvirtual","test");

    //check connectionnya
    if ($link === false)
    {
        die("ERROR : Could not connect. ".mysqli_connect_error());
        
    }

?>

<script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.3.1.js"></script>



</body>

</html>