<?php
include('conexion.php');
include('funciones.php');
include('seguridad.php');

// print_r($_POST);

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Guardar todas las variables revibidas del POST
    $descripcion = $_POST['descripcion'];
    $departamento = $_POST['departamento'];
    $tipo = $_POST['tipo'];
    $ubicacion = $_POST['ubicacion'];
    $frecuencia = $_POST['frecuencia'];
    $inc_seg_op = $_POST['seg_op'];
    $inc_procesos = $_POST['procesos'];
    $imp_eco = $_POST['imp_eco'];
    $imp_per = $_POST['imp_per'];
    $imp_med_amb = $_POST['imp_med_amb'];
    $equipos = $_POST['equipos'];
    $fecha_incidencia = $_POST['fecha_incidencia'];
    $nota = $_POST['nota'];

    //Verficiar si estan llenos los campos
    if(!empty($descripcion) && !empty($departamento) && !empty($tipo) && !empty($ubicacion) && !empty($frecuencia) && !empty($inc_seg_op) && !empty($inc_procesos) && !empty($imp_eco) && !empty($imp_per) && !empty($imp_med_amb) && !empty($equipos) && !empty($fecha_incidencia) && !empty($nota)) { 
      try{
        
        // Query que sube los nombres del archivo y rutina que los sube tambien al server
        $stmt = "INSERT INTO casos(caso_descripcion, depa_id, cati_id, inso_id, inpr_id, imec_id, impe_id, imma_id, equi_id, caso_fecha, caso_nota) VALUES('$descripcion', '$departamento', '$tipo', '$inc_seg_op', '$inc_procesos', '$imp_eco', '$imp_per', '$imp_med_amb', '$equipos', '$fecha_incidencia', '$nota')";
        
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

            $stmt = "INSERT INTO casos_documentos(cado_ref, caso_id) VALUES('$renombrar', '$last_id')";

            //Guardamos el documento
            move_uploaded_file($docs["tmp_name"][$key], "img/casos_docs/".$renombrar);

            // Ejecutamos la query de subida a cado
            $res = mysql_query($stmt, $dbh);

            if(!$res){
              throw new Exception("Error al ejecutar la consulta de subida de archivos: " . $con->error);
            
            }else{
                echo "Documentos subido exitosamente";
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
