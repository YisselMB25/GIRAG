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

switch($reporteDetalle["rede_id"]){
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

?>
 
 <!-- card-content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
          
            <div class="card-header" >
              <div class="d-flex justify-content-between w-100">
              <h3 class="card-title"><?php echo $reporteDetalle["redo_titulo"]?></h3>
              <button class="btn <?php echo $claseBtnEstado?>" value="<?php echo $reporteDetalle["rede_id"]?>" disabled><?php echo $reporteDetalle["estado"]?></button>
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
              
                  <th>Fecha</th>
                  
                  <th></th>
       
               </tr>
            </thead>
            <tbody>
              <?php while($fila = mysql_fetch_assoc($reporteBitacoras)):?>
                <tr>
                    <td> <?php echo $fila["redb_id"]?></td> 
                  
                  <td> <?php echo $fila["redb_comentario"]?></td> 
                 
                  <td> 
                    <a href="manuales-uso/<?php echo $fila["redb_ref"]?>"><?php echo $fila["redb_ref"]?></a>
                  </td> 
               
                  <td> <?php echo $fila["redb_fecha"]?></td> 

                  <td>
                    <button class="btn btn-success btn-sm"><i class="fa-solid fa-check-to-slot"></i></button>
                    <button class="btn btn-danger btn-sm"><i class="fa-solid fa-circle-xmark"></i></button>
                  </td>
                </tr>
                  <?php endwhile?>
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





</script>
