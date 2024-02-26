<?php include('conexion.php');
$id=$_GET['id'];
$qsql ="select * from casos
where caso_id='$id'";
$rs=mysql_query($qsql);
$i=0;
echo mysql_result($rs,$i,'caso_id') . '||';
echo mysql_result($rs,$i,'caso_descripcion') . '||';
echo mysql_result($rs,$i,'usua_id_abierto') . '||';
echo mysql_result($rs,$i,'caso_estado') . '||';
echo mysql_result($rs,$i,'depa_id') . '||';
echo mysql_result($rs,$i,'cati_id') . '||';
echo mysql_result($rs,$i,'inso_id') . '||';
echo mysql_result($rs,$i,'inpr_id') . '||';
echo mysql_result($rs,$i,'imec_id') . '||';
echo mysql_result($rs,$i,'impe_id') . '||';
echo mysql_result($rs,$i,'imma_id') . '||';
echo mysql_result($rs,$i,'equi_id') . '||';
echo mysql_result($rs,$i,'caso_fecha') . '||';
echo mysql_result($rs,$i,'caso_nota') . '||';
echo mysql_result($rs,$i,'usua_id_aprobado') . '||';
echo mysql_result($rs,$i,'usua_id_asignado') . '||';
?>
