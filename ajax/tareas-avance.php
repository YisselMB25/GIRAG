<?php
include "../conexion.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
   print_r($_POST);
   print_r($_FILES);

   $cate_id = $_POST["cate_id"];
   $avance = $_POST["avance_tarea"];
   $observaciones = $_POST["observaciones"];

   $stmt = "INSERT INTO casos_tareas_bitacora(cate_id, catb_descripcion, catb_avance, catb_fecha) 
   VALUES('$cate_id', '$observaciones', '$avance', now())";
   mysql_query($stmt);

   if(!mysql_error()){
      echo "Avance subido" . PHP_EOL;
      $last_insert_id = mysql_insert_id();
      
      if(!empty($_FILES["evidencias"]["name"][0])){
         
         foreach($_FILES["evidencias"]["name"] as $key => $value){
            $nuevo_ref = time(). " - " . $_FILES["evidencias"]["name"][$key];
            $stmt = "INSERT INTO casos_tareas_bitacora_documentos(ctdb_ref, catb_id) VALUES('$nuevo_ref', '$last_insert_id')";
            
            mysql_query($stmt);
            move_uploaded_file($_FILES["evidencias"]["tmp_name"][$key], "../img/tareas_docs/" . $nuevo_ref);
            echo "Documento subido". PHP_EOL;
         }
      }
   }else{
      echo "Fallo la subida del avance";
   }
}elseif($_SERVER["REQUEST_METHOD"] == "GET"){
   $tarea_id = $_GET["tarea_id"];
   $bitacora = [];
   // $res = ["data" => //cantidad de casos]; 
   $stmt = "SELECT catb_descripcion, catb_avance, catb_fecha,
   (SELECT GROUP_CONCAT(ctdb_ref) FROM casos_tareas_bitacora_documentos WHERE catb_id=a.catb_id) documentos
   FROM casos_tareas_bitacora a
   WHERE cate_id = $tarea_id";

   $res = mysql_query($stmt);
   while($fila = mysql_fetch_assoc($res)){
      array_push($bitacora, $fila);
   }
   
   echo json_encode($bitacora);
   
}

?>