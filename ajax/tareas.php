<?php

include "../conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Registrar una tarea nueva
   $error = "";

   $cate_nombre = $_POST["nombre"];
   $depa_id = $_POST["departamento"];
   $usua_id = $_POST["usuario"];
   // $cate_fecha_cierre = $_POST["fecha_cierre"];
   $cate_descripcion = $_POST["descripcion"];
   $caso_id = $_POST["caso_id"];

   if (empty($cate_nombre) or empty($cate_descripcion)) {
      echo $error = "Llenar todos los campos correctamente";
      if ($usua_id == 0 && $depa_id == 0) {
         echo $error = "Asignar la tarea a un departamento o usuario";
      }
   }

   // $depa_id = $depa_id > 0 ? $depa_id : (NULL);
   // $usua_id = $usua_id > 0 ? $usua_id : (NULL);

   if (empty($error)) {
      $stmt = "INSERT INTO casos_tareas(cate_nombre, cate_descripcion, cate_estado, caso_id, depa_id, usua_id) VALUES('$cate_nombre', '$cate_descripcion', 1, $caso_id, $depa_id, '$usua_id')";
      mysql_query($stmt);

      $last_id = mysql_insert_id();

      echo "Enviado exitosamente";
   }else{
      echo "No se ha enviado";
   }

   if (isset($_FILES["archivos"]["name"][0]) and empty($error)) {
      foreach ($_FILES["archivos"]["name"] as $key => $value) {
         $new_ref = time() . "-" . $_FILES["archivos"]["name"][$key];
         $nombre = $_FILES["archivos"]["name"][$key];

         $stmt = "INSERT INTO tareas_documentos(tado_ref, cate_id, tado_nombre) VALUES('$new_ref', '$last_id', '$nombre')";
         $res = mysql_query($stmt);
         move_uploaded_file($_FILES["archivos"]["tmp_name"][$key], "../img/tareas_docs/" . $new_ref);

         echo "Documentos subidos";
      }
   }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
   // Seleccionar todas las tareas seleccionadas de cada caso
   $caso_id = $_GET["caso_id"];
   $response = [];

   $stmt = "SELECT ct.*, (SELECT usua_nombre FROM usuarios WHERE usua_id = ct.usua_id) as usua_nombre, (SELECT depa_nombre FROM departamentos WHERE depa_id = ct.depa_id) as depa_nombre
   FROM casos_tareas ct
   WHERE ct.caso_id = '$caso_id' 
   ORDER BY ct.cate_id DESC";
   $res = mysql_query($stmt);

   while ($fila = mysql_fetch_assoc($res)) {
      array_push($response, $fila);
   }

   echo json_encode($response);
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
   // Eliminar un documento de tareo especifico
   $datos = json_decode(file_get_contents("php://input"), true);

   if (isset($datos["tarea_id"])) {
      $tarea_id = $datos["tarea_id"];

      $stmt = "DELETE FROM casos_tareas WHERE cate_id = $tarea_id";
      mysql_query($stmt);

      echo "Tarea correctamente borrada";
   }
}
