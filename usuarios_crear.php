<?php include('conexion.php');
$i_usua_nombre=$_POST['i_usua_nombre'];
$i_usti_id=$_POST['i_usti_id'];
$i_usua_password=$_POST['i_usua_password'];
$i_usua_nombre_completo=$_POST['i_usua_nombre_completo'];
$i_usua_mail=$_POST['i_usua_mail'];
$qsql = "insert into usuarios 
(
usua_nombre
, 
usti_id
, 
usua_password
, 
usua_nombre_completo
, 
usua_mail
) 
values (
'$i_usua_nombre', 
'$i_usti_id', 
'$i_usua_password', 
'$i_usua_nombre_completo', 
'$i_usua_mail')";
mysql_query($qsql);
?>

