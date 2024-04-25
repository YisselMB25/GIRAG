<?php

if (!isset($_GET['mes']) || empty($_GET['mes'])) {

  $mes = date('Ym');
} else {

  $mes = $_GET['mes'];
}

if ($mes == '') $mes = date('Ym');

$cade_labels = "";
$cade_data = "";

// Casos por estado
$sql = "SELECT 
  COUNT(caes_id) casos_totales,
  COUNT(CASE WHEN caes_id = 1 THEN 1 END) casos_abiertos,
  COUNT(CASE WHEN caes_id = 2 THEN 1 END) casos_cerrados,
  COUNT(CASE WHEN caes_id = 3 THEN 1 END) casos_proceso
FROM casos";

$casos_estado = mysql_fetch_assoc(mysql_query($sql));

// Casos por departamentos
$sql = "SELECT 
  COUNT(caso_id) contador,
  (SELECT depa_nombre FROM departamentos WHERE depa_id = a.depa_id) depa_nombre 
  FROM casos a 
  GROUP BY depa_id";

$casos_departamentos = mysql_query($sql);

$cade_data = "[";
while ($fila = mysql_fetch_assoc($casos_departamentos)) {
  $cade_labels .= "'" . $fila["depa_nombre"] . "', ";
  $cade_data .= "'" . $fila["contador"] . "', ";
}
$cade_labels = substr($cade_labels, 0, -2);
$cade_data = substr($cade_data, 0, -2);
$cade_data .= "]";
?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <!-- CASOS POR DEPARTAMENTOS CHART -->
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Casos por Departamentos</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="casos_departamentos" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>

      <div class="col-md-6">

        <!-- CASOS POR ESTADO CHART -->
        <div class="card card-danger">
          <div class="card-header">
            <h3 class="card-title">Casos por estado</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body d-flex flex-wrap">
            <canvas id="mychart1" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            <!-- <div style="align-content: center">
              <h6 style="20px">Abiertos: <?php //echo $casos_estado["casos_abiertos"]?></h6>
              <h6 style="20px">Cerrados: <?php //echo $casos_estado["casos_cerrados"]?></h6>
              <h6 style="20px">En Proceso: <?php //echo $casos_estado["casos_proceso"]?></h6>
            </div> -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</section>

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const casos_estado = document.getElementById("mychart1")
  const casos_departamentos = document.getElementById("casos_departamentos")

  // const data = ;

  new Chart(casos_estado, {
    type: 'doughnut',
    data: {
    labels: [
      'Abiertos <?php echo $casos_estado["casos_abiertos"] ?>',
      'Cerrados <?php echo $casos_estado["casos_cerrados"] ?>',
      'En proceso <?php echo $casos_estado["casos_proceso"] ?>'
    ],
    datasets: [{
      data: [<?php echo !empty($casos_estado["casos_abiertos"])? $casos_estado["casos_abiertos"] : 0 ?>, <?php echo !empty($casos_estado["casos_cerrados"])? $casos_estado["casos_cerrados"] : 0  ?>, <?php echo !empty($casos_estado["casos_proceso"])? $casos_estado["casos_proceso"] : 0 ?>],
      backgroundColor: [
        'rgb(54, 162, 235)',
        'rgb(255, 99, 132)',
        'rgb(255, 205, 86)'
      ],
      hoverOffset: 4
    }]
  },
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Casos por departamentos'
      }
    }
  })

  // new Chart(casos_departamentos, {
  //   type: 'bar',
  //   data: {
  //     labels: [<?php echo !empty($cade_labels) ? $cade_labels : 0 ?>],
  //     datasets: [{
  //       label: "Cantidad de casos",
  //       data: <?php echo !empty($cade_data) ? $cade_data : 0 ?>
  //     }]
  //   },
  //   options: {
  //     responsive: true,
  //     plugins: {
  //       legend: {
  //         position: 'top',
  //       },
  //       title: {
  //         display: true,
  //         text: 'Casos por departamentos'
  //       }
  //     }
  //   },
  // })
</script>