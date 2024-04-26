<?php include('conexion.php');
$id=$_GET['id'];
$m_usua_nombre=$_POST['m_usua_nombre'];
$m_usti_id=$_POST['m_usti_id'];
$m_usua_password=$_POST['m_usua_password'];
$m_usua_nombre_completo=$_POST['m_usua_nombre_completo'];
$m_usua_mail=$_POST['m_usua_mail'];
$qsql = "update usuarios set 
usua_nombre='$m_usua_nombre', 
usti_id='$m_usti_id', 
usua_password='$m_usua_password', 
usua_nombre_completo='$m_usua_nombre_completo', 
usua_mail='$m_usua_mail'
where usua_id='$id'";
mysql_query($qsql);
?>

