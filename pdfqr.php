<?php
include('conexion.php');
include('funciones.php');

$depa_id = $_GET["depa"];

$stmt = "SELECT * FROM departamentos WHERE depa_id = $depa_id";
$res = mysql_query($stmt, $dbh);
$depa_nombre = mysql_fetch_assoc($res)["depa_nombre"];

$url = "https://giraglogic.girag.aero/casos.php?depa=".$depa_id; 

$qr_code = file_get_contents("https://api.e-integracion.com/a-qr.php?url=".$url);

$plantilla = "

<div class='content'>
<h1 class='pdf_h1' style='text-align:center'>GIRAG</h1>
<h2 class='depa' style='text-align:center; font-size: 16px'>Departamento: $depa_nombre</h2>
<figure class='qr_class'>
$qr_code
</figure>
</div>
";

ob_start(); 

echo $plantilla;

$output0 = ob_get_clean();

ob_start();
$styles = "table
	.pdf_h1, .depa{
		font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
		text-align: center;
		font-size: 45px;
	}
	
	img{
		margin: 0 auto 0 auto;
		width: 1000px;
	}
	
	.qr_class img{
		margin: 0 auto 0 auto;
		width: 1000px;
	}"
?>
<page>
<?php echo $output0 ?>
</page>

<?php
$content = ob_get_clean();

require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/temp']);
$mpdf->WriteHTML($styles, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);
// $mpdf->Output("qr/qr_" .$depa_id . ".pdf",'F');
$mpdf->Output();
exit;
?>
