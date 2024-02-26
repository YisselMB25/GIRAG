<?php include('conexion.php');
$id=$_GET['id'];
$m_depa_nombre=$_POST['m_depa_nombre'];
$qsql = "update departamentos set 
depa_nombre='$m_depa_nombre'
where depa_id='$id'";
mysql_query($qsql);
?>

