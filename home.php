<?php
if (!isset($_GET['mes']) || empty($_GET['mes']))
{
    $mes=date('Ym');
}
else
{
	$mes = $_GET['mes'];
}

if($mes=='') $mes=date('Ym');

//echo "EL MES ES $mes";
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<!-- GUIAS DEL MES -->
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          <?php include("data_dashboard.php");?>
        ]);

        var options = {
          title: 'Guias del mes <?php echo $mes?> por Cliente / Barco',
          pieHole: 0.4,
		  legend: 'bottom',
		  animation:{
        duration: 1000,
        easing: 'out',
		startup: true
			},
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart2'));
        chart.draw(data, options);
      }
</script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          <?php include("data_dashboard_por_cliente.php");?>
        ]);

        var options = {
          title: 'Guias del mes <?php echo $mes?> por Cliente',
          pieHole: 0.4,
		  legend: 'bottom',
		  animation:{
        duration: 1000,
        easing: 'out',
		startup: true
			},
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
</script>
<script>
$(function () {
        $("#mes").datepicker({ dateFormat: 'yymm' });
		});

function mes()
{
	window.location.href = "index.php?p=home&mes=" + $('#mes').val();
}
</script>
<div id="columna6">
<?php $i=0;?>

<table class=filtros>
<tr>
<td><span class="etiquetas">Mes:</span></td><td><input type=text id=mes style="height:20px" value="<?php echo $mes?>"></td>
<td><a href="javascript:mes()" class=botones>Refrescar</a></td>
</tr>
</table>

<div class=filtros_recuadro>
		<div class=recuadro>
			<div id="donutchart" style="width: 385px; height: 400px;border: 0px solid #101010"></div></TD>
		</div>
		
		<div class=recuadro>
			<div id="donutchart2" style="width: 385px; height: 400px;border: 0px solid #101010"></div></TD>
		</div>
</div>

</div>
<div id=result></div>