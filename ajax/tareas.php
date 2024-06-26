<?php

include "../conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Registrar una tarea nueva
   $error = "";

   $cate_nombre = $_POST["nombre"];
   $usua_id = $_POST["usuario"];
   $fecha_fin = $_POST["fecha_fin"];
   $fecha_inicio = $_POST["fecha_inicio"];
   $cate_descripcion = $_POST["descripcion"];
   $caso_id = $_POST["caso_id"]; //Registrar tarea a este caso
   $cate_recursos = $_POST["recursos"];
   $cate_observaciones = $_POST["observaciones"];

   if (empty($cate_nombre) or empty($cate_descripcion) or empty($fecha_inicio) or empty($fecha_fin)) {
      echo $error = "Llenar todos los campos correctamente";
      if ($usua_id == 0) {
         echo $error = "Asignar la tarea a un departamento o usuario";
      }
   }

   // $depa_id = $depa_id > 0 ? $depa_id : (NULL);
   // $usua_id = $usua_id > 0 ? $usua_id : (NULL);

   if (empty($error)) {
      $stmt = "INSERT INTO casos_tareas(cate_nombre, cate_descripcion, cate_estado, caso_id, usua_id, cate_fecha_inicio, cate_fecha_cierre, cate_observaciones, cate_recursos) VALUES('$cate_nombre', '$cate_descripcion', 3, $caso_id, '$usua_id', '$fecha_inicio', '$fecha_fin', '$cate_observaciones', '$cate_recursos')";
      mysql_query($stmt);

      $last_id = mysql_insert_id();

      $stmt = "INSERT INTO casos_tareas_bitacora(cate_id, catb_descripcion, catb_avance, catb_fecha) VALUES($last_id, 'Apertura de tareas', '0', now())";
      mysql_query($stmt);
      echo json_encode(["success" => "Tarea registrada"]);
   }else{
      http_response_code(400);
      echo json_encode(["error" => "Ha ocurrido un error"]);
   }

   if (!empty($_FILES["archivos"]["name"][0]) and empty($error)) {
      foreach ($_FILES["archivos"]["name"] as $key => $value) {
         $new_ref = time() . "-" . $_FILES["archivos"]["name"][$key];
         $nombre = $_FILES["archivos"]["name"][$key];

         $stmt = "INSERT INTO tareas_documentos(tado_ref, cate_id, tado_nombre) VALUES('$new_ref', '$last_id', '$nombre')";
         $res = mysql_query($stmt);
         move_uploaded_file($_FILES["archivos"]["tmp_name"][$key], "../img/tareas_docs/" . $new_ref);

         echo "Documentos subidos<br>";
      }
   }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
   // Seleccionar todas las tareas seleccionadas de cada caso
   $caso_id = $_GET["caso_id"];
   $response = [];

   $stmt = "SELECT ct.*, 
   (SELECT usua_nombre FROM usuarios WHERE usua_id = ct.usua_id) as usua_nombre, 
   (SELECT depa_nombre FROM departamentos WHERE depa_id = ct.depa_id) as depa_nombre,
   (SELECT caes_nombre FROM casos_estado WHERE caes_id = cate_estado ) as tarea_estado,
   (SELECT catb_avance FROM casos_tareas_bitacora WHERE cate_id = ct.cate_id ORDER BY catb_id DESC LIMIT 1) as ultimo_avance
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

      echo "Tarea correctamente borrada<br>";
   }
}