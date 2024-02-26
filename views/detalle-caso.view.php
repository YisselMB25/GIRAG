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
                                             <label for="fecha_cierre" class="col-form-label">Fecha de cierre</label>
                                             <input type="date" class="form-control" id="fecha_cierre" name="fecha_cierre" placeholder="Agregar fecha">
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
                        </span>
                        <hr>
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
                     <?php while ($fila = mysql_fetch_assoc($casos_documentos)) : ?>
                        <li>
                           <a target="_blank" href="img/casos_docs/<?php echo $fila['cado_ref'] ?>" class="btn-link text-secondary"><?php echo $fila['cado_nombre'] ?></a>
                        </li>
                     <?php endwhile ?>
                  </ul>
                  <div class="text-center mt-5 mb-3">
                     <a href="#" class="btn btn-sm btn-primary">Agregar Archivos</a>
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
   agregarTarea = () => {
      const taskData = new FormData($("#form_task")[0])

      $.ajax({
         type: "POST",
         url: "ajax/tareas.php",
         data: taskData,
         contentType: false,
         processData: false,
         success: data => {
            obtenerTareas()
         }
      })
   }

   obtenerTareas = () => {
      const taskSection = document.getElementById("task_section")
      const caso_id = $("#caso_id").val()
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
                     <span class="description">Asignado a: - ${task.usua_nombre}</span>
                  </div>
                  <p>
                     ${task.cate_descripcion}
                  </p>
                  <p>
                     <a class='text-underline' href='tarea-detalle.php?tarea=${task.cate_id}'>Detalle</a>
                  </p>
                  </div>
               `
               });

               taskSection.innerHTML = html
               let btnDlts = document.querySelectorAll(".dlt-btn")

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
                           obtenerTareas()
                        }
                     })
                  })
               })
            }else{
               taskSection.innerHTML = `<h2 class='text-center'>No hay tareas para este caso</h2>`
            }
         }
      })
   }
   obtenerTareas()
</script>