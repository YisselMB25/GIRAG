<?php
include('../conexion.php');
include('../funciones.php');
// include('../seguridad.php');

print_r($_POST);

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Guardar todas las variables revibidas del POST
    $nombre_abierto_por = !empty($_POST["abierto_por"]) ? $_POST["abierto_por"] : "N/A";
    $correo = !empty($_POST["correo"]) ? $_POST["correo"] : "N/A";
    $descripcion = $_POST['descripcion'];
    $departamento = $_POST['departamento'];
    $tipo = $_POST['tipo'];
    $ubicacion = $_POST['ubicacion'];
    $cacl_id = $_POST["cacl_id"];
    $cacd_id = $_POST["cacd_id"];
    $equipos = $_POST['equipos'];
    $fecha_incidencia = $_POST['fecha_incidencia'];
    $nota = $_POST['nota'];
    $caus_id = $_POST["caus_id"];
    // $frecuencia = $_POST['frecuencia'];
    // $inc_seg_op = $_POST['seg_op'];
    // $inc_procesos = $_POST['procesos'];
    // $imp_eco = $_POST['imp_eco'];
    // $imp_per = $_POST['imp_per'];
    // $imp_med_amb = $_POST['imp_med_amb'];
   
    //Verficiar si estan llenos los campos
    // if(!empty($descripcion)  && !empty($tipo) && !empty($ubicacion) && !empty($frecuencia) && !empty($inc_seg_op) && !empty($inc_procesos) && !empty($imp_eco) && !empty($imp_per) && !empty($imp_med_amb) && !empty($equipos) && !empty($nota) && !empty($ubicacion) && !empty($cacl_id)) { 
    if(!empty($descripcion)  && !empty($tipo) && !empty($ubicacion) && !empty($cacl_id)) { 
      try{
        
        // Query que sube los nombres del archivo y rutina que los sube tambien al server
        // $stmt = "INSERT INTO casos(caso_descripcion, depa_id, cati_id, inso_id, inpr_id, imec_id, impe_id, imma_id, equi_id, caso_fecha, caso_nota, caso_ubicacion, caso_nombre_abierto_por, caso_correo_abierto_por, cacl_id, cacd_id) VALUES('$descripcion', '$departamento', '$tipo', '$inc_seg_op', '$inc_procesos', '$imp_eco', '$imp_per', '$imp_med_amb', '$equipos', now(), '$nota', '$ubicacion', '$nombre_abierto_por', '$correo', '$cacl_id', '$cacd_id')";
        $stmt = "INSERT INTO casos(caso_descripcion, depa_id, cati_id, equi_id, caso_fecha, caso_nota, caso_ubicacion, caso_nombre_abierto_por, caso_correo_abierto_por, cacl_id, cacd_id, caus_id) VALUES('$descripcion', '$departamento', '$tipo', '$equipos', now(), '$nota', '$ubicacion', '$nombre_abierto_por', '$correo', '$cacl_id', '$cacd_id', '$caus_id')";
        $res = mysql_query($stmt, $dbh);
        if(!$res){
          throw new Exception("Error al ejecutar la consulta: " . $con->error);
        }else{
          echo "Enviado exitosamente";
        }
        
        //Verificar si hay documentos para crear la QUERY
        if(!empty($_FILES["archivos"]["name"])){
          // Query que me guarda cada imagen en el server------------
          $last_id = mysql_insert_id();
          $docs = $_FILES["archivos"];

          foreach($docs["name"] as $key => $val){
            $nombre = $docs["full_path"][$key];
            $renombrar = time()."-".$nombre;

            $stmt = "INSERT INTO casos_documentos(cado_ref, caso_id, cado_nombre) VALUES('$renombrar', '$last_id', '$nombre')";

            //Guardamos el documento
            move_uploaded_file($docs["tmp_name"][$key], "../img/casos_docs/".$renombrar);

            // Ejecutamos la query de subida a cado
            $res = mysql_query($stmt, $dbh);

            if(!$res){
              throw new Exception("Error al ejecutar la consulta de subida de archivos: " . $con->error);
            
            }else{
                // echo "Documentos subido exitosamente";
            }
          }
        }
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }else{
      echo "No se ha podido enviar, llene todos los campos correctamente";
    }

  }
?>
