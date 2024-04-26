<?php include('conexion.php'); ?> 

<table class=nicetable>
<tr>
<td class=tabla_datos_titulo>Usuario</td>
<td class=tabla_datos_titulo>Tipo</td>
<td class=tabla_datos_titulo>Password</td>
<td class=tabla_datos_titulo>Nombre Completo</td>
<td class=tabla_datos_titulo>E-mail</td>
<td class=tabla_datos_titulo_icono>&nbsp;</td>
<td class=tabla_datos_titulo_icono>&nbsp;</td>
</tr>
<?php
$nombre=$_GET['nombre'];

$qsql ='select * from usuarios';

$rs = mysql_query($qsql);
$num = mysql_num_rows($rs);
$i=0;
while ($i<$num)
{
?>
<tr class='tabla_datos_tr'>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'usua_nombre'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'usti_id'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'usua_password'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'usua_nombre_completo'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'usua_mail'); ?></td>
<td class=tabla_datos_iconos><a href='javascript:editar(<?php echo mysql_result($rs, $i, 'usua_id'); ?>)';><img src='imagenes/modificar.png' border=0></a></td>
<td class=tabla_datos_iconos><a href='javascript:borrar(<?php echo mysql_result($rs, $i, 'usua_id'); ?>)';><img src='imagenes/trash.png' border=0></a></td>
</tr>
<?php
$i++;
}
?>
</table>

