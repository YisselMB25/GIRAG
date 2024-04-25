<?php include('conexion.php'); 
$id = $_GET['id'];
$qsql ="delete from usuarios_firmas where =$id";
mysql_query($qsql);
?>

