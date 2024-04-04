<?php include('conexion.php');
$m_carg_id=$_POST['m_carg_id'];
$m_cati_id=$_POST['m_cati_id'];
$m_carg_guia=$_POST['m_carg_guia'];
$m_vuel_id=$_POST['m_vuel_id'];
$m_aeco_id_destino_final=$_POST['m_aeco_id_destino_final'];
$m_usua_id_creador=$_POST['m_usua_id_creador'];
$m_carg_fecha_registro=$_POST['m_carg_fecha_registro'];
$m_carg_recepcion_real=$_POST['m_carg_recepcion_real'];
$m_liae_id=$_POST['m_liae_id'];
$m_caes_id=$_POST['m_caes_id'];
$qsql = "update carga set 
carg_id='$m_carg_id', 
cati_id='$m_cati_id', 
carg_guia='$m_carg_guia', 
vuel_id='$m_vuel_id', 
aeco_id_destino_final='$m_aeco_id_destino_final', 
usua_id_creador='$m_usua_id_creador', 
carg_fecha_registro='$m_carg_fecha_registro', 
carg_recepcion_real='$m_carg_recepcion_real', 
liae_id='$m_liae_id', 
caes_id='$m_caes_id'
where ='$id'";
mysql_query($qsql);
?>

