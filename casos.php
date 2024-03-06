<?php
include('conexion.php');
include('funciones.php');
// include('seguridad.php');

$id_depa = $_GET["depa"];

$stmt = "SELECT * FROM departamentos WHERE depa_id = $id_depa";
$depa = mysql_query($stmt, $dbh);

$depa = mysql_fetch_assoc($depa)["depa_nombre"];

$stmt = "SELECT * FROM casos_frecuencia";
$frecuencia = mysql_query($stmt, $dbh);

$stmt = "SELECT * FROM casos_tipos";
$tipos = mysql_query($stmt, $dbh);

$stmt = "SELECT * FROM incidencia_seg_op";
$inc_seg_op = mysql_query($stmt, $dbh);

$stmt = "SELECT* FROM incidencia_procesos";
$inc_procesos = mysql_query($stmt, $dbh);

$stmt = "SELECT * FROM impacto_economico";
$imp_economico = mysql_query($stmt, $dbh);

$stmt = "SELECT * FROM impacto_personas";
$imp_personas = mysql_query($stmt, $dbh);

$stmt = "SELECT * FROM impacto_medio_ambiente";
$imp_ambiente = mysql_query($stmt, $dbh);

$stmt = "SELECT * FROM equipos";
$equipos = mysql_query($stmt, $dbh);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Casos</title>
  <script src="plugins/jQuery/jquery-3.4.1.min.js"></script>
  <script src="plugins/jQueryUI/jquery-ui.min.js"></script>
  <link href="plugins/jQueryUI/jquery-ui.min.css" rel="stylesheet" type="text/css" />
  <?php include 'index_links.php'; ?>
</head>

<!-- CUERPO PARA PASAR AL PROYECTO -->

<body class="container mt-3">

  <div id="info">

  </div>

  <div class="col-11 col-md-6 container mb-4">
    <img src="https://giraglogic.girag.aero/img/Girag.png" alt="Girag logo" class="mb-3">
    <h4>Reporte de incidentes y accidentes (FT-SMS-01)</h4>
    <hr>
    <form id="formulario" enctype="multipart/form-data">
      <!-- Descripcion -->
      <div class="form-group">
        <label for="descripcion">Descripcion</label>
        <input type="text" class="form-control" id="descripcion" placeholder="Descripcion..." name="descripcion">
      </div>
      <!-- Departamento -->
      <div class="form-group">
        <label for="departamento">Departamento</label>
        <select class="form-control" id="departamento" disabled>
          <option value="<?php echo $id_depa ?>"  selected> <?php echo $depa ?></option>
        </select>
      </div>
      <div class="form-group">
        <input type="hidden" class="form-control" name="departamento" value="<?php echo $id_depa ?>">
      </div>
      <!-- Tipo de caso -->
      <div class="form-group">
        <label for="tipo">Tipo de caso</label>
        <select class="form-control" id="tipo" name="tipo">
          <option selected>Escoger tipo</option>
          <?php while ($fila = mysql_fetch_assoc($tipos)) : ?>
            <option value="<?php echo $fila["cati_id"] ?>"><?php echo $fila["cati_nombre"] ?></option>
          <?php endwhile ?>
        </select>
      </div>
      <!-- Ubicacion -->
      <div class="form-group">
        <label for="ubicacion">Ubicacion</label>
        <input type="text" class="form-control" id="ubicacion" placeholder="Ubicacion donde sucedio?..." name="ubicacion">
      </div>
      <!-- Frecuencia -->
      <div class="form-group">
        <label for="frecuencia">Frecuencia</label>
        <select class="form-control" id="frecuencia" name="frecuencia">
          <option selected>Escoger frecuencia</option>
          <?php while ($fila = mysql_fetch_assoc($frecuencia)) : ?>
            <option value="<?php echo $fila["cafr_id"] ?>"><?php echo $fila["cafr_nombre"] ?></option>
          <?php endwhile ?>
        </select>
      </div>
      <!-- Seguridad operacional -->
      <div class="form-group">
        <label for="seg_op">Incidencia en la Seguridad Operacional</label>
        <select class="form-control" id="seg_op" name="seg_op">
          <option selected>Escoger Incidencia en la Seguridad Operacional</option>
          <?php while ($fila = mysql_fetch_assoc($inc_seg_op)) : ?>
            <option value="<?php echo $fila["inso_id"] ?>"><?php echo $fila["inso_nombre"] ?></option>
          <?php endwhile ?>
        </select>
      </div>
      <!-- Inicidencia de procesos -->
      <div class="form-group">
        <label for="procesos">Incidencia en los procesos</label>
        <select class="form-control" id="procesos" name="procesos">
          <option selected>Escoger Incidencia de procesos</option>
          <?php while ($fila = mysql_fetch_assoc($inc_procesos)) : ?>
            <option value="<?php echo $fila["inpr_id"] ?>"><?php echo $fila["inpr_nombre"] ?></option>
          <?php endwhile ?>
        </select>
      </div>
      <!-- Impacto economico -->
      <div class="form-group">
        <label for="imp_eco">Impacto economico</label>
        <select class="form-control" id="imp_eco" name="imp_eco">
          <option selected>Escoger Impacto economico</option>
          <?php while ($fila = mysql_fetch_assoc($imp_economico)) : ?>
            <option value="<?php echo $fila["imec_id"] ?>"><?php echo $fila["imec_nombre"] ?></option>
          <?php endwhile ?>
        </select>
      </div>
      <!-- Impacto en las personas -->
      <div class="form-group">
        <label for="imp_per">Impacto en las personas</label>
        <select class="form-control" id="imp_per" name="imp_per">
          <option selected>Escoger Impacto en las personas</option>
          <?php while ($fila = mysql_fetch_assoc($imp_personas)) : ?>
            <option value="<?php echo $fila["impe_id"] ?>"><?php echo $fila["impe_nombre"] ?></option>
          <?php endwhile ?>
        </select>
      </div>
      <!-- Impacto al medio ambiente -->
      <div class="form-group">
        <label for="imp_med_amb">Impacto al medio ambiente</label>
        <select class="form-control" id="imp_med_amb" name="imp_med_amb">
          <option selected>Escoger Impacto en el medio ambiente</option>
          <?php while ($fila = mysql_fetch_assoc($imp_ambiente)) : ?>
            <option value="<?php echo $fila["imma_id"] ?>"><?php echo $fila["imma_nombre"] ?></option>
          <?php endwhile ?>
        </select>
      </div>
      <!-- Equipos -->
      <div class="form-group">
        <label for="equipos">Equipos</label>
        <select class="form-control" id="equipos" name="equipos">
          <option selected>Escoger equpos</option>
          <?php while ($fila = mysql_fetch_assoc($equipos)) : ?>
            <option value="<?php echo $fila["equi_id"] ?>"><?php echo $fila["equi_nombre"] ?></option>
          <?php endwhile ?>
        </select>
      </div>
      <!-- Fecha de incidencia -->
      <div class="form-group">
        <label for="fecha_incidencia">Fecha de incidencia</label>
        <input type="date" class="form-control" id="fecha_incidencia" name="fecha_incidencia">
      </div>
      <!-- Nota -->
      <div class="form-group">
        <label for="nota">Nota</label>
        <textarea class="form-control" id="nota" rows="3" placeholder="Que / Como / Cuando sucedio?" name="nota"></textarea>
      </div>
      <!-- Archivos -->
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="archivos">Cargar</span>
        </div>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="archivos" aria-describedby="archivos" name="archivos[]" multiple>
          <label class="custom-file-label" for="archivos">Buscar</label>
        </div>
      </div>

      <button type="button" class="btn btn-primary mt-3" onclick="registrarCaso()">Registrar caso</button>
    </form>

  </div>

  <script>
    registrarCaso = () => {

      let datos = new FormData($("#formulario")[0])
      
      $.ajax({
          method: "POST",
          url: "ajax/registrarCaso.php",
          data: datos,
          contentType: false,         
          processData: false,
          beforeSend: () => {

          },
          success: (msg) => {
            alert(msg)
          }
        })
    }
  </script>

</body>

<!-- FIN DEL CUERPO DEL PROYECTO -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.world.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- Toastr -->
<link href="jquery/toastr.css" rel="stylesheet" />
<script src="jquery/toastr.js"></script>

</html>