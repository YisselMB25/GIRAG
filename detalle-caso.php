<?php
//Tomar el id del caso
$caso_id = $_GET["caso"];

/*
* Este mide el avance total de las tareas del caso
**/
$stmt = "SELECT 
AVG(catb_avance) AS promedio_avance
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

$promedio_total = (int) mysql_fetch_assoc(mysql_query($stmt))["promedio_avance"];

//Pedir toda la info
$stmt = "SELECT caso_id, caso_descripcion, cati_nombre, inso_nombre, inpr_nombre, depa_nombre, caso_fecha_analisis, imec_nombre, imma_nombre, equi_nombre, caso_fecha, caso_nota, impe_nombre, caso_observaciones, caes_id,
(SELECT usua_nombre FROM usuarios WHERE  usua_id=usua_id_revisado) revisado,
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
?>

<main class="container container-fluid">
   <section class="content">

      <!-- Default box -->
      <div class="card">
         <div class="card-header">
            <a href="index.php?p=caso_casos" class="btn" id="back">
               <i class="fa-solid fa-chevron-left" style="color: #000000;"></i>
            </a>
            <div class="d-flex flex-column col-12 col-md-4">
               <h4>Programa de Gestión / FT-GAC-04</h4>
               <?php if (!empty($promedio_total) and $promedio_total > 0) : ?>
                  <h6 class="text-primary">Avance de solución general de tareas <b><?php echo $promedio_total ?>%</b></h6>

                  <?php if ($promedio_total >= 100 and $caso["caes_id"] == 3) ://Es igual a 'EN PROCESO' ?>
                     <span onclick="cerrarCaso()" class="btn btn-danger mb-3"><i class="fa-solid fa-xmark"></i> Cerrar el caso</span>
                  <?php endif ?>
               <?php endif ?>


               <?php if (empty($caso["caso_fecha_analisis"])) : ?>
                  <button class="btn btn-secondary mb-3" data-toggle="modal" data-target="#modal-fecha-revision"><i class="fa-solid fa-newspaper"></i> Fecha de Análisis</button>
               <?php else : ?>
                  <a class="btn btn-warning mb-3" href="programa-gestion-pdf.php?caso=<?php echo $_GET["caso"] ?>" target="_blank"><i class="fa-solid fa-file-pdf"></i> Programa de gestión</a>
               <?php endif ?>
               <a class="btn btn-primary text-white mb-3" href="reporte-incidente-pdf.php?caso=<?php echo $_GET["caso"] ?>" target="_blank"><i class="fa-solid fa-file-pdf"></i> Reporte de incidente</a>
            </div>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                  <div class="row">
                     <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                           <div class="info-box-content">
                              <span class="info-box-text text-center text-muted">Estado</span>
                              <span class="info-box-number text-center text-muted mb-0"><?php echo strtoupper($caso["caso_estado"]) ?></span>
                           </div>
                        </div>
                     </div>
                     <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                           <div class="info-box-content">
                              <span class="info-box-text text-center text-muted">Revisado por</span>
                              <span class="info-box-number text-center text-muted mb-0"><?php echo strtoupper($caso["revisado"]) ?></span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-12">
                        <span class="d-flex justify-content-between">
                           <span class="mb-3">
                              <h6 style="font-size: 19px" class="card-title">Asociado a: Reporte # <?php echo strtoupper($caso["caso_id"]) ?>, <?php echo strtoupper($caso["caso_descripcion"]) ?></h6>
                              <span class="text-success d-block">Fecha de incidencia-><?php echo $caso["caso_fecha"] ?></span>
                              <span class="text-primary d-block">Fecha de análisis->
                                 <span id="fecha_revision_span"><?php echo $caso["caso_fecha_analisis"] ?></span>
                              </span>
                           </span>
                           <!-- Button trigger modal -->
                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form_nueva_tarea">
                              <i class="fa-solid fa-plus"></i> Nueva tarea
                           </button>

                           <div class="modal fade" id="form_nueva_tarea">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h4 class="modal-title">Agregar tarea</h4>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form id="form_task" enctype="multipart/form-data">
                                          <input type="hidden" value="<?php echo $_GET["caso"] ?>" name="caso_id" id="caso_id">
                                          <div class="form-group">
                                             <label for="nombre" class="col-form-label">Tarea</label>
                                             <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                                          </div>
                                          <div class="form-group">
                                             <label for="usuarios">Asignar usuario</label>
                                             <select class="form-control" id="usuarios" name="usuario">
                                                <option value="0">Seleccionar usuario</option>
                                                <?php while ($fila = mysql_fetch_assoc($users)) : ?>
                                                   <option value="<?php echo $fila["usua_id"] ?>"><?php echo $fila["usua_nombre"] ?></option>
                                                <?php endwhile ?>
                                             </select>
                                          </div>
                                          <div class="form-group">
                                             <label for="fecha_inicio" class="col-form-label">Fecha de inicio</label>
                                             <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" placeholder="Fecha de inicio">
                                          </div>

                                          <div class="form-group">
                                             <label for="fecha_fin" class="col-form-label">Fecha de cierre</label>
                                             <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" placeholder="Fecha de fin">
                                          </div>
                                          <div class="form-group">
                                             <label for="descripcion" class="col-form-label">Descripción</label>
                                             <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion de la actividad"></textarea>
                                          </div>
                                          <div class="form-group">
                                             <label for="equipos" class="col-form-label">Recursos</label>
                                             <textarea class="form-control" id="recursos" name="recursos"></textarea>
                                          </div>
                                          <div class="form-group">
                                             <label for="observaciones" class="col-form-label">Observaciones</label>
                                             <textarea class="form-control" id="observaciones" name="observaciones"></textarea>
                                          </div>
                                          <div class="custom-file">
                                             <input type="file" class="custom-file-input" id="archivos" placeholder="Buscar documentos" name="archivos[]" multiple>
                                             <label class="custom-file-label" for="archivos">Buscar documentos</label>
                                          </div>
                                       </form>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                       <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                       <button type="button" class="btn btn-primary" onclick="agregarTarea()">Guardar</button>
                                    </div>
                                 </div>
                                 <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                           </div>
                           <!-- /.modal -->

                           <!-- Modal fecha de revision del programa de gestion-->
                           <div class="modal fade" id="modal-fecha-revision" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="exampleModalLabel">Fecha de análisis del caso</h5>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form id="form-fecha-revision">
                                          <input type="hidden" name="caso_id" value="<?php echo $_GET["caso"] ?>">
                                          <div class="input-group mb-3">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Fecha</span>
                                             </div>
                                             <input type="date" class="form-control" placeholder="Fecha de análisis" aria-label="Fecha de revisión" aria-describedby="basic-addon1" name="fecha_revision" id="fecha-revision">
                                          </div>
                                       </form>
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-primary" onclick="actualizarFechaAnalisis()">Guardar cambios</button>

                                    </div>
                                 </div>
                              </div>
                           </div>


                           <!-- Modal detalles de cada tarea como los documentos -->
                           <div class="modal fade" id="modal_detail_task">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h4 class="modal-title">Detalles de tarea</h4>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body" id="modal-body">
                                       <form id="form-nuevo-avance" enctype="multipart/form-data">
                                          <b>Avance o retraso de tarea</b>
                                          <hr>

                                          <div class="input-group mb-3">
                                             <input type="number" class="form-control" placeholder="Avance representativo" name="avance_tarea">
                                          </div>

                                          <div class="input-group mb-3">
                                             <textarea class="form-control" placeholder="Agregar comentario" name="observaciones"></textarea>
                                          </div>

                                          <div class="input-group mb-3">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text">Upload</span>
                                             </div>
                                             <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="evidencias[]" multiple>
                                                <label class="custom-file-label">Choose file</label>
                                             </div>
                                          </div>
                                          <span class="btn btn-primary" onclick="subirAvance()">Enviar</span>
                                       </form>
                                       <hr>
                                       <table class="table table-sm">
                                          <thead>
                                             <tr>
                                                <th colspan="2">Bitácora de tarea</th>
                                             </tr>
                                          </thead>
                                          <tbody id='table_body_docs'>
                                          </tbody>
                                       </table>

                                       <table class="table table-sm">
                                          <thead>
                                             <tr>
                                                <th scope="col">Documento</th>
                                                <th scope="col">Acciones</th>
                                             </tr>
                                          </thead>
                                          <tbody id='table_body_task_docs'>
                                          </tbody>
                                       </table>

                                       <form id="form_new_doc" class="my-3">
                                          <input type="hidden" id="tarea_id" name="tarea_id">
                                          <div class="custom-file">
                                             <input type="file" class="custom-file-input" id="archivos" placeholder="Buscar documentos" name="new_docs[]" multiple>
                                             <label class="custom-file-label" for="archivos">Agregar archivos</label>
                                          </div>
                                       </form>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                       <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                       <button type="button" class="btn btn-primary" onclick="agregarDoc()">Guardar</button>
                                    </div>
                                 </div>
                                 <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                           </div>
                           <!-- /.modal -->

                           <!-- Modal agregar archivos al caso -->
                           <div class="modal fade" id="modal_caso_docs">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h4 class="modal-title">Agregar archivos</h4>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body" id="modal-body">

                                       <form id="form_caso_doc" class="my-3" enctype="mul">
                                          <input type="hidden" id="caso_id" name="caso_id" value="<?php echo $_GET["caso"] ?>">
                                          <div class="custom-file">
                                             <input type="file" class="custom-file-input" id="archivos" placeholder="Buscar documentos" name="new_docs[]" multiple>
                                             <label class="custom-file-label" for="archivos">Agregar archivos</label>
                                          </div>
                                       </form>
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-primary" onclick="casoNewDoc()">Guardar documentos</button>
                                    </div>
                                 </div>
                                 <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                           </div>
                           <!-- /.modal -->
                        </span>
                        <hr>

                        <!-- Task section -->
                        <div id="task_section">

                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2 mt-4">
                  <hr class="d-block d-md-none">
                  <h6 class="text-danger">OBJETIVO/META/PROBLEMA/NO CONFORMIDAD</h6>
                  <p class="text-muted"><?php echo $caso["caso_nota"] ?></p>
                  <br>

                  <h6 class="text-danger">Observaciones del revisado</h6>
                  <p class="text-muted"><?php echo $caso["caso_observaciones"] ?></p>

                  <h5 class="mt-5 text-muted">Evidencias/Documentos</h5>
                  <ul class="list-unstyled">

                  </ul>

                  <table class="table table-sm table-borderless">
                     <tbody id="case_doc_task">

                     </tbody>
                  </table>
                  <div class="text-center mt-5 mb-3">
                     <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_caso_docs">
                        <i class="fa-solid fa-plus"></i> Agregar documento
                     </button>
                  </div>
               </div>
            </div>
         </div>
         <!-- /.card-body -->
      </div>
      <!-- /.card -->

   </section>
   <!-- /.content -->

</main>

<script>
   

   function dnoneBackdrop() {
      let modalBackDrop = document.querySelectorAll(".modal-backdrop")

      modalBackDrop.forEach(e => {
         e.style.display = "none"
      })
   }

   /**
    * Funcion que me va a modificar el avance de la tarea y la observacion
    */
   function subirAvance() {
      const datos = new FormData($("#form-nuevo-avance")[0])
      datos.append("cate_id", taskIdInput.val())

      $.ajax({
         url: "ajax/tareas-avance.php",
         method: "POST",
         contentType: false,
         processData: false,
         data: datos,
         success: res => {
            console.log(res);
            getDocsTask(taskIdInput.val())
         }
      })
   }

   // Funcion que actualiza la fecha de revision del caso ------------------------------
   function actualizarFechaAnalisis() {
      let datos = new FormData($("#form-fecha-revision")[0])

      $.ajax({
         method: "POST",
         url: "ajax/caso.php",
         processData: false,
         contentType: false,
         data: datos,
         success: res => {
            let datos = JSON.parse(res)
            $("#fecha_revision_span").text(datos.fecha)
            alert(datos.msg)
            location.reload()
         }
      })

   }

   //Funcion que me agrega una tarea---------------------------------------
   function agregarTarea() {
      let formTask = document.getElementById("form_nueva_tarea")
      const taskData = new FormData($("#form_task")[0])

      $.ajax({
         type: "POST",
         url: "ajax/tareas.php",
         data: taskData,
         contentType: false,
         processData: false,
         success: data => {
            obtenerTareas()
            formTask.style.display = "none"
            // modalBackDrop.style.display = "none"
            dnoneBackdrop()
            // alert(data)
         },
         error: (xhr, status, thrown) => {
            console.log(xhr.statusText);
         }
      })
   }

   //Funcion que me trae todas las tareas
   function obtenerTareas() {
      const taskSection = document.getElementById("task_section")
      let caso_id = $("#caso_id").val()
      let html = ""

      $.ajax({
         type: "GET",
         url: "ajax/tareas.php",
         data: {
            caso_id: caso_id
         },
         success: data => {
            const tasks = JSON.parse(data)

            if (tasks[0]) {
               tasks.forEach(task => {
                  let asignado = task.usua_nombre ? `Usuario -> ${task.usua_nombre}` : `Departamento -> ${task.depa_nombre}`;

                  if (task.ultimo_avance == null) {
                     task.ultimo_avance = 0
                  }

                  html += `
               <div class="post">
                  <div class="user-block">
                     <div class="username d-flex justify-content-between">
                        <div>
                           <span>${task.cate_nombre}</span>
                        </div>
                        <button class='dlt-btn btn' data-id=${task.cate_id}>
                           <i class="fa-solid fa-trash" style="color: #ff0000;"></i>
                        </button>
                     </div>
                     <div class="description">
                        <span class="text-success d-block">Fecha de cierre: ${task.cate_fecha_inicio}</span>
                        <span class="text-danger d-block">Fecha de cierre: ${task.cate_fecha_cierre}</span>
                        <span class="d-block">Asignado a: ${asignado}</span>
                     </div>
                  </div>
                  <p class="mb-1">
                     <b>Descripcion:</b> ${task.cate_descripcion}
                  </p>
                  <p class="mb-1">
                     <b>Observaciones: </b>${task.cate_observaciones}
                  </p>
                  <p class="mb-1">
                     <b>Recursos</b>: ${task.cate_recursos}
                  </p>
                  <div class="d-flex justify-content-between w-100">
                  <button class='btn btn-primary' data-toggle="modal" data-target="#modal_detail_task" onclick="ejecutarOpenTaskDetails(${task.cate_id})">Evidencias/Documentos</button>
                  <span>Avance total: ${task.ultimo_avance}%</span>
                  </div>
                  </div>
               `
               });

               taskSection.innerHTML = html
               html = ""

            } else {
               taskSection.innerHTML = `<h2 class='text-center'>No hay tareas para este caso</h2>`
            }
         },
         complete: () => {
            let btnDlts = document.querySelectorAll(".dlt-btn")

            //Funcion que elimina la tarea por completo----------------------------------
            btnDlts.forEach(btn => {
               btn.addEventListener("click", () => {
                  $.ajax({
                     type: "DELETE",
                     url: "ajax/tareas.php",
                     contentType: "application/json",
                     data: JSON.stringify({
                        tarea_id: btn.dataset.id
                     }),
                     success: (response) => {
                        console.log(response)
                     },
                     complete: () => {
                        obtenerTareas()
                     }
                  })
               })
            })
         }
      })
   }
   obtenerTareas()

   function ejecutarOpenTaskDetails(id) {
      getDocTaskGenerals(id)
      getDocsTask(id)
   }

   // Funcion para agregar nuevo documento al caso -------------------------------
   function casoNewDoc() {
      const modalCasoDocs = document.getElementById("modal_caso_docs")
      let modalBackDrop = document.querySelectorAll(".modal-backdrop")
      const casoNewDocForm = $("#form_caso_doc")
      const datos = new FormData(casoNewDocForm[0])

      $.ajax({
         type: "POST",
         url: "ajax/caso.php",
         contentType: false,
         processData: false,
         data: datos,
         success: (res) => {
            console.log(res);
            getDocCaso()
            modalCasoDocs.style.display = "none"
            dnoneBackdrop()
         }
      })
   }

   //Funcion que me trae los documentos del caso ----------------------------------
   function getDocCaso() {
      let caso_id = $("#caso_id").val()
      const caseDocSection = $("#case_doc_task")
      html = ''


      $.ajax({
         type: "GET",
         url: "ajax/caso.php",
         data: {
            caso_id: caso_id
         },
         success: (res) => {
            datos = JSON.parse(res)
            if (datos[0]) {
               datos.forEach(e => {
                  html += `
               <tr class="d-flex justify-content-between">
                  <td>
                     <a target="_blank" href="img/casos_docs/${e.cado_ref}" class="btn-link text-secondary">${e.cado_nombre}</a>
                  </td>
                  <td>
                  <div class="text-white btn-group btn-group-sm">
                        <a target='_blank' class="btn btn-info" href="img/casos_docs/${e.cado_ref}"">
                        <i class="fa-solid fa-eye"></i>
                        </a>
                        <button class="text-white btn btn-danger btn-doc-delete" onclick='deleteDocTask(${e.cado_id})'>
                              <i class="fa-solid fa-trash"></i>
                              </button>
                        </div>
                  </td>
               </tr>`
               })
               caseDocSection.html(html)
            } else {
               html += `
               <tr class="d-flex justify-content-between">
                  <td>No hay documentos</td>
               </tr>`
               caseDocSection.html(html)
            }

         }
      })
   }

   getDocCaso()

   //Funcion que eliminar cada documento del caso ---------------------------------
   function deleteDocCaso(doc_id) {

      $.ajax({
         type: "DELETE",
         contentType: "application/json",
         url: "ajax/caso.php",
         data: JSON.stringify({
            cado_id: doc_id
         }),
         success: (e) => {
            console.log(e);
            getDocCaso()
         }
      })
   }

   //Funcion que me agrega un documento a la tarea ---------------------------------
   const taskIdInput = $("#tarea_id") //Controla el id de la tarea

   function agregarDoc() {
      const formDocTask = $("#form_new_doc")
      const docData = new FormData(formDocTask[0])

      $.ajax({
         type: "POST",
         url: "ajax/tareas_docs.php",
         data: docData,
         contentType: false,
         processData: false,
         success: (res) => {
            console.log(res)
         },
         complete: () => {
            getDocsTask(taskIdInput.val())
         }
      })
   }

   // Funcion que elimina un doc especifico mediante parametro-----------------------------------
   function deleteDocTask(doc_id) {
      $.ajax({
         type: "DELETE",
         url: "ajax/tareas_docs.php",
         contentType: "application/json",
         data: JSON.stringify({
            doc_id: doc_id
         }),
         success: (response) => {
            console.log(response)
         },
         complete: () => {
            getDocsTask(taskIdInput.val())
         }
      })
   }

   // Funcion que trae los documentos generales de la tarea
   function getDocTaskGenerals(doc_id) {
      let html2 = ""

      $.get("ajax/tareas_docs.php", {
            tarea_id: doc_id
         },
         function(data) {
            let datos = JSON.parse(data);

            datos.forEach(e => {
               html2 += `<tr>
                  <td>
                     <a target="_blank" href="img/casos_docs/${e.tado_ref}" class="btn-link text-secondary">${e.tado_nombre}</a>
                  </td>
                  <td>
                  <div class="text-white btn-group btn-group-sm">
                        <a target='_blank' class="btn btn-info" href="img/casos_docs/${e.tado_ref}"">
                        <i class="fa-solid fa-eye"></i>
                        </a>
                        <button class="text-white btn btn-danger btn-doc-delete" onclick='deleteDocTask(${e.tado_id})'>
                              <i class="fa-solid fa-trash"></i>
                              </button>
                        </div>
                  </td>
               </tr>`
            })

            $("#table_body_task_docs").html(html2);
            // getDocTaskGenerals(taskIdInput.val())
         })
   }

   // Funcion que me trae los documentos de la tarea y la bitacora de la tarea
   function getDocsTask(tarea_id) {
      taskIdInput.val(tarea_id)
      html = ""
      let html2 = ""
      let tableDocsBody = document.getElementById("table_body_docs")

      $.ajax({
         type: "GET",
         url: "ajax/tareas-avance.php",
         data: {
            tarea_id: tarea_id
         },
         success: res => {
            let avances = JSON.parse(res)
            avances.forEach(e => {

               if (e.documentos != null) {
                  html2 = ""
                  let docus = e.documentos
                  docus = docus.split(",")
                  console.log(docus)
                  docus.forEach(doc => {
                     html2 += `<p>
                           <a href="img/tareas_docs/${doc}" target="_blank" class="link-black text-sm"><i class="fas fa-link mr-1"></i>${doc}</a>
                          </p>`
                  })
               }
               html += `
               <div class="user-block">
                        <span class="">
                          <b class="text-success">Avance representativo: ${e.catb_avance}</b>
                        </span>
                        <span class="description">Fecha - ${e.catb_fecha}</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        ${e.catb_descripcion}
                      </p>
                      ${html2}
                    </div><hr>`
            });
            // $("#bitacora-section").html(html)
            $("#table_body_docs").html(html)
         }
      })
   }

   function cerrarCaso() {
      console.log("Hla");

      $.ajax({
         type: "PATCH",
         url: "ajax/caso.php",
         contentType: "application/json",
         data: JSON.stringify({
            id: <?php echo $_GET["caso"] ?>
         }),
         success: res => {
            res = JSON.parse(res).success
            console.log(res);

            if (res == true) {
               location.reload()
            }
         }
      })
   }
</script>