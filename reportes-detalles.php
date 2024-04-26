<?php

$reporte_id = $_GET["id"];
$claseBtnEstado = "btn-primary";

/**
 *Me trae los datos generales del manuel de uso 
 *@var $claseBtnEstado -- Es la clase de bootsrap que vamos a verificiar segun el estado y asignar algun color
 */
$sql = "SELECT rd.*, 
(SELECT rede_nombre FROM reportes_documentos_estado WHERE rd.rede_id = rede_id) estado
FROM reportes_documentos rd WHERE redo_id = '$reporte_id'";
$reporteDetalle = mysql_fetch_assoc(mysql_query($sql));

switch ($reporteDetalle["rede_id"]) {
  case 1: //En proceso
    $claseBtnEstado = "btn-warning";
    break;
  case 2:
    $claseBtnEstado = "btn-danger";
    break;
  case 3:
    $claseBtnEstado = "btn-success";
  default:
    break;
}

/**
 * Query que me trae las bitacoras y la ejecucion se guarda en 
 * @var $reporteBitacoras -- Tiene que recorrerse de la siguien manera
 * 
 * while($fila = mysql_fetch_assoc($reporteBitacoras){
 *  --Implementar la logica
 *  --EJMPLO: Para acceder a un indice es de la siguiente manera => $fila["redb_id"]
 * }
 */
$sql = "SELECT * FROM reportes_documentos_bitacora WHERE redo_id = $reporte_id";
$reporteBitacoras = mysql_query($sql);

$sql = "SELECT * FROM
reportes_documentos_estado p, reportes_documentos_bitacora a
WHERE p.rede_id = a.rede_id;
";
$reporte_estado = mysql_query($sql)

?>
<!-- modal -->
<div id="comentarioModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Razón del rechazo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="comentarioForm">
        <div class="modal-body">
          <div class="form-group">
            <label for="comentario">Comentario:</label>
            <textarea class="form-control" id="comentario" name="comentario"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="guardarComentario(<?php echo $reporte_id; ?>)">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- card-content -->
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header">
          <div class="d-flex justify-content-between w-100">
            <h3 class="card-title"><?php echo $reporteDetalle["redo_titulo"] ?></h3>
            <button class="btn <?php echo $claseBtnEstado ?>" value="<?php echo $reporteDetalle["rede_id"] ?>" disabled><?php echo $reporteDetalle["estado"] ?></button>
          </div>

        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="table-responsive">

            <div class="table-responsive px-3">
              <table class="table table-bordered w-100 table-sm text-center">
                <thead class="bg-dark">
                  <tr>
                    <th>ID Bitacora</th>

                    <th>Comentario</th>

                    <th>Documento</th>

                    <th>Fecha de Creación</th>

                    <th> Estado</th>

                    <th></th>

                  </tr>
                </thead>
                <tbody>
                  <?php while ($fila = mysql_fetch_assoc($reporteBitacoras)) : ?>
                    <tr>
                      <td> <?php echo $fila["redb_id"] ?></td>

                      <td> <?php echo $fila["redb_comentario"] ?></td>

                      <td>
                        <a href="manuales-uso/<?php echo $fila["redb_ref"] ?>"><?php echo $fila["redb_ref"] ?></a>
                      </td>

                      <td> <?php echo $fila["redb_fecha"] ?></td>
                      <td> </td>
                      <td>
                        <?php
                        ?>
                        <button id="aceptar" data-estado="3"class="btn btn-success btn-sm btn-control-estado"><i class="fa-solid fa-check-to-slot"></i></button>
                        <button id="rechazado" data-estado="4" class="btn btn-danger btn-sm btn-control-estado"><i class="fa-solid fa-circle-xmark"></i></button>
                        <button id="comentario" class="btn btn-info btn-sm"><i class="fa-solid fa-comment"></i></button>

                      </td>
                    </tr>
                  <?php endwhile ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>
  //  Botones de aceptar o rechazar 
  $('.btn-control-estado').on('click', function() {
    let estado = $(this).data('estado');
    enviarRetro(estado, <?php echo $_GET["reporte_id"]?>)
  });

  function guardarComentario(reporte_id) {
    const datos = new FormData($("#comentarioForm")[0]);

    $.ajax({
      url: "ajax/reporte_documento_detalle.php?id=" + reporte_id,
      method: "POST",
      contentType: false,
      processData: false,
      data: datos,
      success: function(res) {
        alert("Mensaje enviado exitosamente");
      }
    });
  }

  function enviarRetro(estado_id, reporte_id){
    const datos = new FormData($("#comentarioForm")[0]);

    $.ajax({
      url: "ajax/reporte_documento_detalle.php?id=" + reporte_id + "&estado_id=" + estado_id,
      method: "POST",
      contentType: false,
      processData: false,
      data: datos,
      success: function(res) {

        alert("Mensaje enviado exitosamente");

      }
    })
  }
</script>