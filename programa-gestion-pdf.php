<?php

include "conexion.php";

require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ ."/temp"]);
$mpdf->AddPage("L");

$caso_id = $_GET["caso"];

$stmt = "SELECT cont_detalle FROM contratos WHERE cont_nombre = 'PROGRAMA-GESTION'";
$plantilla = mysql_fetch_assoc(mysql_query($stmt))["cont_detalle"];

// print_r($plantilla);

$stmt = "SELECT a.caso_id, caso_fecha, caso_descripcion, caso_nota, caso_fecha_analisis, caso_beneficio,
(SELECT usua_nombre FROM usuarios WHERE usua_id = usua_id_aprobado) responsable_programa,
(SELECT depa_nombre FROM departamentos dp WHERE dp.depa_id = a.depa_id) departamento
FROM casos a 
WHERE caso_id = $caso_id";

$caso_detalles = mysql_fetch_assoc(mysql_query($stmt));
// print_r($caso_detalles);

// Query que me trae todas las tareas de manera detallada
$stmt = "SELECT 
a.*, 
b.catb_avance,
(SELECT usua_nombre FROM usuarios WHERE usua_id = a.usua_id) AS responsable_tarea
FROM casos_tareas a
INNER JOIN (
SELECT 
    cate_id,
    MAX(catb_id) AS ultimo_catb_id
FROM casos_tareas_bitacora
GROUP BY cate_id
) ultimos_avances ON a.cate_id = ultimos_avances.cate_id
INNER JOIN casos_tareas_bitacora b ON ultimos_avances.cate_id = b.cate_id AND ultimos_avances.ultimo_catb_id = b.catb_id
WHERE a.caso_id = $caso_id";
$res = mysql_query($stmt);

// echo "Tareas";
$i = 0;
$descri_html = "";
$promedio = 0;
while ($row = mysql_fetch_assoc($res)) {
   $i++;
   $descri_html .= "<tr>
      <td>$i</td>
      <td>" . $row["cate_nombre"] . "</td>
      <td>" . $row["cate_fecha_inicio"] . "</td>
      <td>" . $row["cate_fecha_cierre"] . "</td>
      <td>" . $row["responsable_tarea"] . "</td>
      <td>" . $row["catb_avance"] . "%</td>
      <td>" . $row["cate_recursos"] . "</td>
      <td>" . $row["cate_observaciones"] . "</td>
   </tr>";

   $promedio += (int)$row["catb_avance"];
}

// Cambiar el encabezado
$plantilla = str_replace("[FECHA_ANALISIS]", $caso_detalles["caso_fecha_analisis"], $plantilla);
$plantilla = str_replace("[NO_CONFORMIDAD]", $caso_detalles["caso_nota"], $plantilla);
$plantilla = str_replace("[CASO_ID]", $caso_detalles["caso_id"], $plantilla);
$plantilla = str_replace("[REPORTE_ANALISIS]", $caso_detalles["caso_descripcion"], $plantilla);
$plantilla = str_replace("[FECHA_CASO]", $caso_detalles["caso_fecha"], $plantilla);
$plantilla = str_replace("[AREA]", $caso_detalles["departamento"], $plantilla);
$plantilla = str_replace("[RESPONSABLE]", $caso_detalles["responsable_programa"], $plantilla);
$plantilla = str_replace("[BENEFICIO]", $caso_detalles["caso_beneficio"], $plantilla);
$plantilla = str_replace("[CASO_ID]", $caso_detalles["caso_id"], $plantilla);
$plantilla = str_replace("[REPORTE_ANALISIS]", $caso_detalles["caso_descripcion"], $plantilla);
$plantilla = str_replace("[RESPONSABLE]", $caso_detalles["responsable_programa"], $plantilla);
$plantilla = str_replace("[TABLA_TAREAS]", $descri_html, $plantilla);

// Promedio de avances
$total = $i > 0 ? (($promedio/ ($i*100)) * 100) : 0;
$plantilla = str_replace("[AVANCE_TOTAL_TAREAS]", $total, $plantilla);

// print_r($plantilla);

ob_start(); 

$output0 = ob_get_clean();

ob_start();
$content = ob_get_clean();


$mpdf->WriteHTML($plantilla);
$mpdf->Output();
