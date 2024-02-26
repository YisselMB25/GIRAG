<?php include('conexion.php');
$i_depa_nombre=$_POST['i_depa_nombre'];
$qsql = "insert into departamentos 
(
depa_nombre
) 
values (
'$i_depa_nombre')";
mysql_query($qsql);
?>

