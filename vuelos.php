<div class="card p-2 col-12 col-md-6  m-auto">
   <h2>Registrar vuelos</h2>
   <form class="card-body" id="form-archivo" enctype="multipart/form-data">
      <div class="form-group">
         <label for="usfi_ref">Escoga un archivo</label>
         <input class="form-control" type="file" id="excel" name="excel" />
      </div>
      <div>
         <div class="text-center">
            <span class="btn btn-primary" id="cargar-archivo">Enviar</span>
         </div>
         <!-- <button type="reset" class="btn btn-success">ANULAR</button>-->
      </div>
   </form>
</div>

<script>
   $("#cargar-archivo").on("click", function() {
      const datos = new FormData($("#form-archivo")[0])

      $.ajax({
         url: "ajax/cargar-vuelos.php",
         method: "POST",
         data: datos,
         processData: false,
         contentType: false,
         success: res => {
            console.log(res);
         },
         complete: function() {
            console.log("lesgoo");
         }
      })
   })
</script>