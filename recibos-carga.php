<?php

$sql = "SELECT * FROM transportes";
$transporte = mysql_query($sql);

$sql = "SELECT * FROM carga_tipos";
$carga_tipos = mysql_query($sql);

$sql = "SELECT * FROM carga_tipos";
$carga_tipo = mysql_query($sql);

// $nombre = "";
// switch($carga_tipos["cati_id"]){
//   case 1: //En proceso
//    $nombre= "Entrega";
//     break;
//   case 2:
//    $nombre = "Recibo";
//     break;
//   case 3:
//    $nombre = "Retiro";
//    break;
//    case 4:
//    $nombre = "Entrega";
//     default:
//     break;
// }

$sql = "SELECT * FROM vuelos";
$vuelos = mysql_query($sql);

$sql = "SELECT * FROM lineas_aereas";
$lineas_areas = mysql_query($sql);

$sql = "SELECT * FROM aereopuertos_codigos";
$aero_cod = mysql_query($sql);

$sql = "SELECT
vuelos.vuel_id,
vuelos.liae_id,
lineas_aereas.liae_nombre,
paises_origen.pais_bandera AS pais_origen,
paises_destino.pais_bandera AS pais_destino,
vuelos.vuel_fecha,
vuelos.vuel_codigo
FROM vuelos
INNER JOIN lineas_aereas ON vuelos.liae_id = lineas_aereas.liae_id
INNER JOIN paises AS paises_origen ON vuelos.aeco_id_origen = paises_origen.pais_id
INNER JOIN paises AS paises_destino ON vuelos.aeco_id_destino = paises_destino.pais_id";

$vuelo = mysql_query($sql);

$sql = "SELECT * FROM
         paises p, aereopuertos_codigos a
         WHERE p.`pais_id` = a.`pais_id`";
$paises = mysql_query($sql);

$sql = "SELECT * FROM
         paises p, lineas_aereas a
         WHERE p.`pais_id` = a.`pais_id`";
$lineas_aereas = mysql_query($sql);

$sql = "SELECT * FROM carga_estado";
$carga_estado = mysql_query($sql);

$usuaID = $_SESSION['login_user'];

$sql = "SELECT usua_nombre FROM usuarios WHERE usua_id = $usuaID ";
$usuarios = mysql_fetch_assoc(mysql_query($sql));

$sql = "SELECT * FROM codigo_interlineal";
$codigoint = mysql_query($sql);

$sql = "SELECT * FROM carga";
$cargas_id = mysql_query($sql);



$usuarioID = $_SESSION['login_user'];
$sql = "SELECT usua_nombre  FROM usuarios WHERE usua_id = $usuarioID ";
$usuario = mysql_query($sql);

$sql = "SELECT * FROM carga a, carga_detalles b WHERE a.carg_id = b.carg_id";
$cargadetalle = mysql_query($sql);

$labelestado = "";

?>

<section class="content">
   <div class="card border">
      <div class="card-header">
         <div class="row">
            <div class="col-6">

               <!-- Boton del modal Formulario carga detalle -->
               <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-detalle-carga">
                  Agregar Carga
               </button>
            </div>
         </div>
      </div>
      <form class="card-body" id="form-nueva-carga">
         <button type="submit" class="btn btn-success">ENTREGAR</button>
         <button type="reset" class="btn btn-success">ANULAR</button>
         <div class="row">
            <!-- Columna 1 -->
            <div class="col-md-6">
               <div class="">
                  <!-- Form Recibos de carga -->
                  <div class="">
                     <!-- Estado -->

                     <div class="form-group">
                        <label for="inputVuelo">Estado</label>
                        <select id="<?php echo $fila["caes_nombre"] ?>" class="form-control custom-select" name="caes_id" value="<?php echo $fila["caes_id"] ?>">
                           <option selected disabled>Seleccione una opción</option>
                           <?php while ($fila = mysql_fetch_assoc($carga_estado)) : ?>
                              <option value="<?php echo $fila["caes_id"] ?>"><?php echo $fila["caes_nombre"] ?></option>
                           <?php endwhile ?>

                        </select>
                     </div>
                     <!-- Numero de recibo -->
                     <div class="form-group">
                        <label for="inputName">Número <span id="nombre-carga"></span></label>
                        <input type="text" id="inputName" class="form-control" name="no_recibo">
                     </div>
                     <!-- Número de guía -->
                     <div class="form-group">
                        <label for="inputGuia">Número de Guía</label>
                        <input type="text" id="inputGuia" class="form-control" name="guia">
                     </div>
                     <!-- Shipper -->
                     <div class="form-group">
                        <label for="inputShipper">Shipper</label>
                        <select id="inputShipper" class="form-control custom-select" name="shipper">
                           <option selected disabled>Seleccione una opción</option>
                           <option></option>
                        </select>
                     </div>

                     <!-- Consignee -->
                     <div class="form-group">
                        <label for="inputConsignee">Consignee</label>
                        <select id="inputConsignee" class="form-control custom-select" name="consignee">
                           <option selected disabled>Seleccione una opción</option>
                           <option></option>
                        </select>
                     </div>

                     <!-- Agencia -->
                     <div class="form-group">
                        <label for="inputAgencia">Agencia</label>
                        <select id="inputAgencia" class="form-control custom-select" name="agencia">
                           <option selected disabled>Seleccione una opción</option>
                           <?php while ($fila = mysql_fetch_assoc($lineas_aereas)) : ?>
                              <option value="<?php echo $fila["liae_id"] ?>"><?php echo $fila["pais_nombre"] . "/" . $fila["liae_nombre"] ?></option>
                           <?php endwhile ?>
                        </select>
                     </div>
                     <!-- Escoja el vuelo-->
                     <div class="form-group">
                        <label for="inputVuelo">Escoja el Vuelo</label>
                        <select id="inputVuelo" class="form-control custom-select" name="vuelo">
                           <option selected disabled>Seleccione una opción</option>
                           <?php while ($fila = mysql_fetch_assoc($vuelo)) : ?>
                              <option value="<?php echo $fila["vuel_id"] ?>"> <?php echo $fila["liae_nombre"] . "/" . $fila["pais_origen"] . "-" . $fila["pais_destino"] . "/" . $fila["vuel_fecha"] . "/" . $fila["vuel_codigo"] ?></option>
                           <?php endwhile ?>

                        </select>
                     </div>
                     <!-- Destino Final-->
                     <div class="form-group">
                        <label for="inputDestinoF">Destino Final</label>
                        <select id="inputDestinoF" class="form-control custom-select" name="destino_final">
                           <option selected disabled>Seleccione una opción</option>
                           <?php while ($fila = mysql_fetch_assoc($paises)) : ?>
                              <option value="<?php echo $fila["aeco_id"] ?>"><?php echo $fila["pais_nombre"] . "/" . $fila["aeco_codigo"] ?></option>
                           <?php endwhile ?>

                        </select>
                     </div>
                     <!-- Recepción Real de Carga-->
                     <div class="form-group">
                        <label for="InputRecepcion">Recepción Real de Carga</label>
                        <input type="date" id="InputRecepcion" class="form-control" name="recepcion_real">
                     </div>


                  </div>

               </div>
            </div>

            <!-- Columna 2 -->
            <div class="col-md-6">
               <div class="">
                  <div class="">
                     <!-- Contenido de la tarjeta -->
                     <!-- Creado Por -->
                     <div class="form-group">
                        <?php while ($fila = mysql_fetch_assoc($usuario)) : ?>
                           <label for="creador">Creado por </label>
                           <input type="" id="creador" class="form-control" value="<?php echo $fila["usua_nombre"]; ?>" readonly>
                        <?php endwhile ?>
                     </div>
                     <!-- Creado El -->
                     <div class="form-group">
                        <label for="creado">Creado El </label>
                        <input type="date" id="creado" class="form-control" name="fecha_creacion">
                     </div>
                     <!-- Dirección o tipo de carga-->
                     <fieldset class="form-group row">
                        <legend class="col-form-label col-sm-2 float-sm-left pt-0">Dirección</legend>
                        <div class="col-sm-10">
                           <?php while ($fila = mysql_fetch_assoc($carga_tipos)) : ?>
                              <div class="form-check">
                                 <input class="form-check-input" type="radio" name="direccion" id="<?php echo $fila["cati_nombre"] ?>" value="<?php echo $fila["cati_id"] ?>">
                                 <label class="form-check-label" for="<?php echo $fila["cati_nombre"] ?>">
                                    <?php echo $fila["cati_nombre"] ?>
                                 </label>
                              </div>
                           <?php endwhile ?>
                           <div id="direccion-error"></div>
                        </div>
                     </fieldset>



                     <!-- Transportista -->
                     <div id="mostrar">
                        <div class="ocultar">
                           <div class="form-group">
                              <label for="InputTransport">Transportista</label>
                              <input type="text" id="InputTransport" class="form-control disabled" name="trans_nombre">
                           </div>
                           <!-- Cédula -->
                           <div class="form-group">
                              <label for="InputCedula">Cédula </label>
                              <input type="text" id="InputCedula" class="form-control disabled" name="trans_cedula">
                           </div>
                           <!-- Matricula-->
                           <div class="form-group">
                              <label for="InputMatricula">Matrícula </label>
                              <input type="text" id="InputMatricula" class="form-control disabled" name="trans_matricula">
                           </div>
                           <!-- Tipo de transporte-->
                           <div class="form-group">
                              <label for="transporte_id">Transporte</label>
                              <select id="transporte_id" class="form-control custom-select" name="transporte_id">
                                 <option selected disabled>Seleccione una opción</option>
                                 <?php while ($fila = mysql_fetch_assoc($transporte)) : ?>
                                    <option value="<?php echo $fila["tran_id"] ?>"><?php echo $fila["tran_nombre"] ?></option>
                                 <?php endwhile ?>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </form>
      <div class="table-responsive px-3">
         <table class="table table-bordered w-100 table-sm text-center">
            <thead class="bg-dark">
               <tr>
                  <th>Item</th>
                  <th>Piezas</th>
                  <th>Peso</th>
                  <th>Largo</th>
                  <th>Ancho</th>
                  <th>Alto</th>
                  <th>Volumen</th>
                  <th>Descripcion</th>
                  <th>    </th>
               
               </tr>
            </thead>
            <tbody id="tbody-carga-detalles">
               <tr>
                  <td colspan="10"><b>NO HAY PRODUCTOS</b></td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
</section>



<!-- modal Formulario carga detalle -->
<!-- Formulaio-modal de detalle de carga-->
<div class="modal fade" id="modal-detalle-carga" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Agregar Carga Detalle</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <!-- Formulario detalle carga -->
            <form action="" id="formulariocargadetalle">


               <div class="container text-center">
                  <div class="row justify-content-between">
                     <!-- Primera columna -->
                     <div class="col-6 col-md-4">
                        <!-- Id de la carga -->
                        <div class="form-group">
                           <label for="carg_id" class="">Código de la Carga</label>
                           <input class="form-control" type="text" id="carg_id" name="carg_id" value="<?php echo isset($_GET["carg_id"]) ? $_GET["carg_id"] : "" ?>" readonly>
                        </div>
                        <!-- descripción de la carga -->

                        <div class="form-group">
                           <label for="cade_desc" class="">Descripción de la Carga</label>
                           <input type="text" id="cade_desc" class="form-control" name="cade_desc">
                        </div>

                        <!-- Kg peso -->
                        <div class="form-group">
                           <label for="cade_peso">Kg</label>
                           <input type="number" id="cade_peso" class="form-control" name="cade_peso">
                        </div>
                        <!-- largo -->
                        <div class="form-group">
                           <label for="cade_largo">Largo</label>
                           <input type="number" id="cade_largo" class="form-control" name="cade_largo">
                        </div>

                     </div>
                     <!-- Segunda columna -->
                     <div class="col-6 col-md-4">
                        <!-- ancho -->
                        <div class="form-group">
                           <label for="cade_ancho">Ancho</label>
                           <input type="number" id="cade_ancho" class="form-control" name="cade_ancho">
                        </div>
                        <!-- alto -->
                        <div class="form-group">
                           <label for="cade_alto"> Alto</label>
                           <input type="number" id="cade_alto" class="form-control" name="cade_alto">
                        </div>

                        <!-- Localizacion -->
                        <div class="form-group">
                           <label for="cade_localizacion">Localización</label>
                           <input type="text" id="cade_localizacion" class="form-control" name="cade_localizacion">
                        </div>
                        <!-- Notas de carga -->
                        <div class="form-group">
                           <label for="cade_notas">Notas de Carga</label>
                           <input type="text" id="cade_notas" class="form-control" name="cade_notas">
                        </div>

                     </div>
                     <!-- Tercera columna -->
                     <div class="col-6 col-md-4">
                        <!-- Piezas -->
                        <div class="form-group">
                           <label for="cade_piezas">Piezas </label>
                           <input type="number" id="cade_piezas" class="form-control" name="cade_piezas">
                        </div>
                        <!-- Recibidas -->
                        <div class="form-group">
                           <label for="cade_recibidas">Recibidas </label>
                           <input type="number" id="cade_recibidas" class="form-control" name="cade_recibidas">
                        </div>
                        <!-- Salida -->
                        <div class="form-group">
                           <label for="cade_salida">Salida </label>
                           <input type="number" id="cade_salida" class="form-control" name="cade_salida">
                        </div>

                        <!-- Código Interlineal -->
                        <div class="form-group">
                           <label for="coin_id">Código Interlineal </label>
                           <select id="coin_id" class="form-control custom-select" name="coin_id">
                              <option selected>Seleccione una opción</option>
                              <?php while ($fila = mysql_fetch_assoc($codigoint)) : ?>
                                 <option value="<?php echo $fila["coin_id"] ?>"><?php echo $fila["coin_codigo"] ?></option>
                              <?php endwhile ?>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-secondary" data-dismiss="modal" onclick="resetForm()">Cerrar</button>
                  <button type="submit" class="btn btn-primary">Guardar</button>
                  <script>
                     function resetForm() {
                        $('#formulariocargadetalle').trigger('reset')
                     }
                  </script>
               </div>
            </form>

         </div>
      </div>
   </div>
</div>


<script>
   $("document").ready(function() {
      obtenerDetalles()
   })



   $(".ocultar").hide()
   $(".disabled").prop("disabled", true)
   $(document).ready(function() {

      $('input[type="radio"][name="direccion"]').change(function() {
         // Si se selecciona la opción Export

         if ($(this).val() !== '1' && $(this).val() !== '2') {
            // Ocultar los campos adicionales
            $('.ocultar').hide();
            $(".disabled").prop("disabled", true)
         } else {
            // Mostrar los campos adicionales para otras opciones
            $('.ocultar').show();
            $(".disabled").prop("disabled", false)
         }
      });
   });


   function registrarCarga() {
      const datos = new FormData($("#form-nueva-carga")[0])

      $.ajax({
         url: "ajax/carga.php",
         method: "POST",
         contentType: false,
         processData: false,
         data: datos,
         success: res => {
            // Aquí se ejecuta si el formulario es válido
            alert("Mensaje enviado exitosamente");
            const carg_id = JSON.parse(res).carg_id
            $("#carg_id").val(carg_id)
         }
      })
   }

   function registrarCargadetalle() {
      const datos = new FormData($("#formulariocargadetalle")[0])


      $.ajax({
         url: "ajax/carga-detalles.php",
         method: "POST",
         contentType: false,
         processData: false,
         data: datos,
         success: res => {
            alert("Mensaje enviado exitosamente");
            obtenerDetalles();
            // console.log(res)
            // Aquí se ejecuta si el formulario es válido
         },
         complete: function() {
            const carg_id_val = $("#carg_id").val()
            resetForm();
            $("#carg_id").val(carg_id_val)
         }


      })
   }


  // Después de agregar un nuevo detalle de carga exitosamente, llamar a esta función
function obtenerDetalles() {
    const carg_id = $("#carg_id").val().trim();

    // Verificar si el ID de carga no está vacío
    if (carg_id !== "") {
        $.ajax({
            url: "ajax/carga.php",
            method: "GET",
            data: {
                carg_id: carg_id
            },
            success: function(response) {
                const detalles = JSON.parse(response);
                const tbody = $("#tbody-carga-detalles");
                tbody.empty();

                if (!detalles) {
                    const row = `<tr colspan="10"><b>NO HAY DETALLES</b></tr>`;
                    tbody.append(row);
                } else {
                    // Construir las filas de la tabla con los detalles de carga
                    detalles.forEach(detalle => {
                        const row = `
                        <tr>
                            <td>${detalle.cade_id}</td>
                            <td>${detalle.cade_piezas}</td>
                            <td>${detalle.cade_peso}</td>
                            <td>${detalle.cade_largo}</td>
                            <td>${detalle.cade_ancho}</td>
                            <td>${detalle.cade_alto}</td>
                            <td>${(detalle.cade_largo * detalle.cade_ancho * detalle.cade_alto) / 6000 * (detalle.cade_piezas)}</td>
                            <td>${detalle.cade_desc}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-editar" data-id="${detalle.cade_id}">Editar</button>
                                <button type="button" class="btn btn-danger btn-borrar" data-id="${detalle.cade_id}">Borrar</button>
                            </td>
                        </tr>`;
                        tbody.append(row);
                    });

                   
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al obtener detalles de carga:", error);
            }
        });
    }
}

     
   $("document").ready(function() {

      $("#form-nueva-carga").validate({

         rules: {
            caes_id: "required",
            no_recibo: "required",
            guia: "required",
            //shipper:"required",
            //consignee:"required",
            agencia: "required",
            vuelo: "required",
            destino_final: "required",
            recepcion_real: "required",
            fecha_creacion: "required",
            direccion: "required",
            trans_nombre: "required",
            trans_cedula: "required",
            trans_matricula: "required",
            transporte_id: "required"
         },
         messages: {
            caes_id: "<span style='color: red; font-size: smaller;'>Ingrese el estado</span>",
            no_recibo: "<span style='color: red; font-size: smaller;'>Ingrese el número de recibo</span>",
            guia: "<span style='color: red; font-size: smaller;'>Ingrese el número de guía</span>",
            //shipper:"<span style='color: red; font-size: smaller;'>Ingrese el shipper</span>",
            //consignee:"<span style='color: red; font-size: smaller;'>Ingrese el consignee</span>",
            agencia: "<span style='color: red; font-size: smaller;'>Ingrese la agencia</span>",
            vuelo: "<span style='color: red; font-size: smaller;'>Ingrese el vuelo</span>",
            destino_final: "<span style='color: red; font-size: smaller;'>Ingrese el destino final</span>",
            recepcion_real: "<span style='color: red; font-size: smaller;'>Ingrese la recepción real</span>",
            fecha_creacion: "<span style='color: red; font-size: smaller;'>Ingrese la fecha de creación</span>",
            direccion: "<span style='color: red; font-size: smaller;'>Ingrese la dirección</span>",
            trans_nombre: "<span style='color: red; font-size: smaller;'>Ingrese el nombre</span>",
            trans_cedula: "<span style='color: red; font-size: smaller;'>Ingrese la cédula</span>",
            trans_matricula: "<span style='color: red; font-size: smaller;'>Ingrese la matricula</span>",
            transporte_id: "<span style='color: red; font-size: smaller;'>Seleccione el transporte</span>"
         },
         errorPlacement: function(error, element) {
            if (element.attr("name") == "direccion") {
               error.appendTo("#direccion-error");
            } else {
               error.insertAfter(element);
            }
         },
         submitHandler: function(form) {
            // Envía el formulario después de mostrar el mensaje
            registrarCarga();
         }

      });

   });

   $("document").ready(function() {

      $("#formulariocargadetalle").validate({

         rules: {

            cade_desc: "required",
            cade_peso: "required",
            cade_largo: "required",
            cade_ancho: "required",
            cade_alto: "required",
            cade_localizacion: "required",
            //cade_notas:"required",
            cade_piezas: "required",
            cade_recibidas: "required",
            cade_salida: "required",
            coin_id: "required"
         },
         messages: {

            cade_desc: "<span style='color: red; font-size: smaller;'>Ingrese una descripción</span>",
            cade_peso: "<span style='color: red; font-size: smaller;'>Ingrese el peso</span>",
            cade_largo: "<span style='color: red; font-size: smaller;'>Ingrese  el largo</span>",
            cade_ancho: "<span style='color: red; font-size: smaller;'>Ingrese el ancho</span>",
            cade_alto: "<span style='color: red; font-size: smaller;'>Ingrese el alto</span>",
            cade_localizacion: "<span style='color: red; font-size: smaller;'>Ingrese la localización</span>",
            //cade_notas:"<span style='color: red; font-size: smaller;'>Ingrese la nota </span>",
            cade_piezas: "<span style='color: red; font-size: smaller;'>Ingrese la cantidad de piezas</span>",
            cade_recibidas: "<span style='color: red; font-size: smaller;'>Ingrese  cantidad recibida</span>",
            cade_salida: "<span style='color: red; font-size: smaller;'>Ingrese la dirección</span>",
            coin_id: "<span style='color: red; font-size: smaller;'>Ingrese el código</span>"
         },
         submitHandler: function(form) {

            registrarCargadetalle();
         }

      });

   });


   // Obtener referencia al radio button
   var radioButtons = document.querySelectorAll('input[name="direccion"]');

   // Agregar evento change a cada radio button
   radioButtons.forEach(function(radioButton) {
      radioButton.addEventListener('change', function() {
         // Obtener el valor seleccionado
         var valor = this.value;

         // Determinar el nombre correspondiente según el valor seleccionado
         var nombre = "";
         if (valor == 1) {
            nombre = "de Entrega";
         } else if (valor == 2) {
            nombre = "de Recibo";
         } else if (valor == 3) {
            nombre = "de Retiro";
         } else {
            nombre = "de Entrega";
         }

         // 
         document.getElementById('nombre-carga').textContent = nombre;
         //document.getElementById('inputName').setAttribute('placeholder', 'Número ' + nombre);
      });
   });
</script>