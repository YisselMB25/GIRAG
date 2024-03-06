<main class="container container-fluid">
   <section class="content">

      <!-- Default box -->
      <div class="card">
         <div class="card-header">
            <a href="index.php?p=caso_casos" class="btn" id="back">
               <i class="fa-solid fa-chevron-left" style="color: #000000;"></i>
            </a>
            <h1 style="font-weight: 700; font-size: 26px" class="card-title"><?php echo strtoupper($caso["caso_descripcion"]) ?> / <span class="text-primary"><?php echo $caso["caso_fecha"] ?></span></h1>
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
                  </div>
                  <div class="row">
                     <div class="col-12">
                        <span class="d-flex justify-content-between">
                           <h4>Tareas</h4>
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
                                             <label for="departamentos">Asignar departamento</label>
                                             <select class="form-control" id="departamentos" name="departamento">
                                                <option value="0">Seleccionar departamentos</option>
                                                <?php while ($fila = mysql_fetch_assoc($depas)) : ?>
                                                   <option value="<?php echo $fila["depa_id"] ?>"><?php echo $fila["depa_nombre"] ?></option>
                                                <?php endwhile ?>
                                             </select>
                                          </div>
                                          <div class="form-group">
                                             <label for="usuarios">Asignar usuario</label>
                                             <select class="form-control" id="usuarios" name="usuario">
                                                <option value="0">Seleccionar departamentos</option>
                                                <?php while ($fila = mysql_fetch_assoc($users)) : ?>
                                                   <option value="<?php echo $fila["usua_id"] ?>"><?php echo $fila["usua_nombre"] ?></option>
                                                <?php endwhile ?>
                                             </select>
                                          </div>
                                          <div class="form-group">
                                             <label for="descripcion" class="col-form-label">Descripción</label>
                                             <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
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

                                       <table class="table table-sm">
                                          <thead>
                                             <tr>
                                                <th>Nombre del archivo</th>
                                                <th></th>
                                             </tr>
                                          </thead>
                                          <tbody id='table_body_docs'>

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
                                    <div class="modal-footer justify-content-between">
                                       <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
               <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                  <h3 class="text-primary"><i class="fa-solid fa-circle-info"></i>Descripción</h3>
                  <p class="text-muted"><?php echo $caso["caso_nota"] ?></p>
                  <br>

                  <h5 class="mt-5 text-muted">Documentos</h5>
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
   function dnoneBackdrop(){
      let modalBackDrop = document.querySelectorAll(".modal-backdrop")

      modalBackDrop.forEach(e => {
         e.style.display = "none"
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

                  html += `
               <div class="post">
                  <div class="user-block">
                     <div class="username d-flex justify-content-between">
                        <div>
                           <span>${task.cate_nombre}</span>
                           <span class="mx-3 text-warning">Fecha de cierre: ${task.cate_fecha_cierre}</span>
                        </div>
                        <button class='dlt-btn btn' data-id=${task.cate_id}>
                           <i class="fa-solid fa-trash" style="color: #ff0000;"></i>
                        </button>
                     </div>
                     <span class="description">Asignado a: ${asignado}</span>
                  </div>
                  <p>
                     ${task.cate_descripcion}
                  </p>
                  <button class='btn' data-toggle="modal" data-target="#modal_detail_task" onclick='getDocsTask(${task.cate_id})'>
                     <ins>Ver documentos</ins>
                  </button>
                  
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
                        <button class="text-white btn btn-danger btn-doc-delete" onclick='deleteDocCaso(${e.cado_id})'>
                              <i class="fa-solid fa-trash"></i>
                              </button>
                        </div>
                  </td>
               </tr>`
               })
               caseDocSection.html(html)
            }else{
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
         url: "ajax/caso.php",
         contentType: "application/json",
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
   const taskIdInput = $("#tarea_id")

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

   function getDocsTask(tarea_id) {
      taskIdInput.val(tarea_id)
      html = ""
      let tableDocsBody = document.getElementById("table_body_docs")

      $.ajax({
         type: "GET",
         url: "ajax/tareas_docs.php",
         data: {
            tarea_id: tarea_id
         },
         success: (response) => {
            docs = JSON.parse(response)
            if (docs[0]) {
               docs.forEach(doc => {
                  html += `<tr class="d-flex justify-content-between">
                  <td>${doc.tado_nombre}</td>
                  <td>
                     <div class="text-white btn-group btn-group-sm">
                     <a target='_blank' class="btn btn-info" href="img/tareas_docs/${doc.tado_ref}">
                     <i class="fa-solid fa-eye"></i>
                     </a>
                     <button class="text-white btn btn-danger btn-doc-delete" onclick='deleteDocTask(${doc.tado_id})'>
                           <i class="fa-solid fa-trash"></i>
                           </button>
                     </div>
                     </td>
                     </tr>`
               })

               tableDocsBody.innerHTML = html
            } else {
               tableDocsBody.innerHTML = `<tr col=3 class='text-center'>No hay archivos para esta tarea</tr>`
            }
         }
      })
   }
</script>