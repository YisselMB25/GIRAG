<?php include('conexion.php'); 
$id = $_GET['id'];
$qsql ="delete from carga where =$id";
mysql_query($qsql);
?>

