<?php
//Tomar el id del caso
$caso_id = $_GET["caso"];

//Pedir toda la info
$stmt = "SELECT caso_id, caso_descripcion, cati_nombre, inso_nombre, inpr_nombre, depa_nombre,
imec_nombre, imma_nombre, equi_nombre, caso_fecha, caso_nota, impe_nombre,
(SELECT usua_nombre FROM usuarios WHERE  usua_id=usua_id_aprobado) aprobado,
(SELECT usua_nombre FROM usuarios WHERE usua_id=usua_id_asignado) usua_asignado,
(SELECT depa_nombre FROM departamentos WHERE depa_id=depa_id_asignado) depa_asignado,
(SELECT caes_nombre FROM casos_estado WHERE caes_id=a.caes_id) caso_estado
FROM casos a, casos_tipos b, departamentos c, equipos d, impacto_economico e, impacto_medio_ambiente f, impacto_personas g, incidencia_procesos h, incidencia_seg_op i 
WHERE a.cati_id=b.cati_id
AND a.depa_id=c.depa_id 
AND a.equi_id=d.equi_id 
AND a.imec_id=e.imec_id 
AND a.imma_id=f.imma_id 
AND a.impe_id=g.impe_id 
AND a.inpr_id=h.inpr_id
AND a.inso_id=i.inso_id
AND a.caso_id = $caso_id";


$caso = mysql_query($stmt, $dbh);
$caso = mysql_fetch_assoc($caso);
$caso_id = $caso["caso_id"];

$stmt = "SELECT ct.cate_id, ct.cate_nombre, ct.cate_descripcion, ct.cate_fecha_cierre, cate_estado, dep.depa_nombre, us.usua_nombre FROM casos_tareas ct
INNER JOIN usuarios us ON ct.usua_id = us.usua_id
INNER JOIN departamentos dep ON ct.depa_id = dep.depa_id
WHERE ct.caso_id = '$caso_id'";
$casos_tareas = mysql_query($stmt);

$stmt = "SELECT * FROM casos_documentos WHERE caso_id = $caso_id";
$casos_documentos = mysql_query($stmt);

$stmt = "SELECT * FROM departamentos";
$depas = mysql_query($stmt, $dbh);

$stmt = "SELECT * FROM usuarios";
$users = mysql_query($stmt, $dbh);
include "views/detalle-caso.view.php";
?>