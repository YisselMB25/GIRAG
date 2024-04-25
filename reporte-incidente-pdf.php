<?php

include "conexion.php";

require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . "/temp"]);

$caso_id = $_GET["caso"];

$stmt = "SELECT cont_detalle FROM contratos WHERE cont_nombre = 'REPORTE-INCIDENTES'";
$plantilla = mysql_fetch_assoc(mysql_query($stmt))["cont_detalle"];

// print_r(mysql_fetch_assoc($res));

// $plantilla = mysql_fetch_assoc($res)["cont_detalle"];

// print_r($plantilla);

$stmt = "SELECT caso_id, caso_nombre_abierto_por, caso_fecha, caso_descripcion, caso_nota,
(SELECT impe_nombre FROM impacto_personas impe WHERE impe.impe_id = a.impe_id) lesionados,
(SELECT cacl_nombre FROM casos_clasificacion cacl WHERE cacl.cacl_id = a.cacl_id) reporte_asociado,
(SELECT cati_nombre FROM casos_tipos ct WHERE ct.cati_id = a.cati_id) tipo_reporte,
(SELECT depa_nombre FROM departamentos dp WHERE dp.depa_id = a.depa_id) departamento
FROM casos a WHERE caso_id = $caso_id ";

$res = mysql_query($stmt);

$caso_detalles = mysql_fetch_assoc($res);
// print_r($caso_detalles);

$plantilla = str_replace("[NO.REPORTE]", $caso_detalles["caso_id"], $plantilla);
$plantilla = str_replace("[NOMBRE_QUIEN_REPORTA]", $caso_detalles["caso_nombre_abierto_por"], $plantilla);
$plantilla = str_replace("[AREA_DEPARTAMENTO]", $caso_detalles["departamento"], $plantilla);
$plantilla = str_replace("[FECHA_HORA_EVENTO]", $caso_detalles["caso_fecha"], $plantilla);
$plantilla = str_replace("[TIPO_REPORTE]", $caso_detalles["tipo_reporte"], $plantilla);
$plantilla = str_replace("[REPORTE_CLASIFICACION]", $caso_detalles["reporte_asociado"], $plantilla);
$plantilla = str_replace("[TITULO_EVENTO]", $caso_detalles["caso_descripcion"], $plantilla);
$plantilla = str_replace("[PERSONAS_LESIONADAS]", $caso_detalles["lesionados"], $plantilla);
$plantilla = str_replace("[DESCRIPCION_EVENTO]", $caso_detalles["caso_nota"], $plantilla);

// print_r($plantilla);

ob_start(); 

$output0 = ob_get_clean();

ob_start();
$content = ob_get_clean();

$mpdf->WriteHTML($plantilla);
$mpdf->Output();

?>