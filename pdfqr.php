<?php
include('conexion.php');
include('funciones.php');

$depa_id = $_GET["depa"];
$tipo_contrato = $_GET["tipo"];

$stmt = "SELECT cont_detalle FROM contratos WHERE cont_id = 39";
$contenido = mysql_query($stmt);
$contenido = mysql_fetch_assoc($contenido)["cont_detalle"];

$stmt = "SELECT * FROM departamentos WHERE depa_id = $depa_id";
$res = mysql_query($stmt, $dbh);
$depa_nombre = mysql_fetch_assoc($res)["depa_nombre"];

$url = "https://giraglogic.girag.aero/casos.php?depa=".$depa_id; 

$qr_code = file_get_contents("https://api.e-integracion.com/a-qr.php?url=".$url);

$contenido = str_replace("[QR]", $qr_code, $contenido);

ob_start(); 

$output0 = ob_get_clean();

ob_start();
	?>
<?php echo $output0 ?>

<?php
$content = ob_get_clean();

require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf([
	'tempDir' => __DIR__ . '/temp',
	'format' => [200, 300]
]);
$mpdf->WriteHTML($contenido, \Mpdf\HTMLParserMode::HTML_BODY);
// $mpdf->Output("qr/qr_" .$depa_id . ".pdf",'F');
$mpdf->Output();
exit;
?>
