<?php 

$sName = "localhost";
$uName = "grislandru";
$pass = "33VCStMMR#K7Y8T8";
$db_name = "grislandru";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", 
                    $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo "Connection failed : ". $e->getMessage();
}

 // $link = mysqli_connect("localhost", "grislandru", "33VCStMMR#K7Y8T8");