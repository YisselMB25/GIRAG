<?php include('conexion.php');
$i_carg_id=$_POST['i_carg_id'];
$i_cati_id=$_POST['i_cati_id'];
$i_carg_guia=$_POST['i_carg_guia'];
$i_vuel_id=$_POST['i_vuel_id'];
$i_aeco_id_destino_final=$_POST['i_aeco_id_destino_final'];
$i_usua_id_creador=$_POST['i_usua_id_creador'];
$i_carg_fecha_registro=$_POST['i_carg_fecha_registro'];
$i_carg_recepcion_real=$_POST['i_carg_recepcion_real'];
$i_liae_id=$_POST['i_liae_id'];
$i_caes_id=$_POST['i_caes_id'];
$qsql = "insert into carga 
(
carg_id
, 
cati_id
, 
carg_guia
, 
vuel_id
, 
aeco_id_destino_final
, 
usua_id_creador
, 
carg_fecha_registro
, 
carg_recepcion_real
, 
liae_id
, 
caes_id
) 
values (
'$i_carg_id', 
'$i_cati_id', 
'$i_carg_guia', 
'$i_vuel_id', 
'$i_aeco_id_destino_final', 
'$i_usua_id_creador', 
'$i_carg_fecha_registro', 
'$i_carg_recepcion_real', 
'$i_liae_id', 
'$i_caes_id')";
mysql_query($qsql);
?>

