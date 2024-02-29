<?php

include "../conexion.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
   
   foreach($_FILES["new_docs"]["name"] as $key => $value){
      $nombre = $_FILES["new_docs"]["name"][$key];
      $ref = time() . "-" . $_FILES["new_docs"]["name"][$key];
      $caso_id = $_POST['caso_id'];
      
      $stmt = "INSERT INTO casos_documentos(cado_nombre, caso_id, cado_ref) VALUES('$nombre', '$caso_id', '$ref')";
      $res = mysql_query($stmt);

      move_uploaded_file($_FILES["new_docs"]["tmp_name"][$key], "../img/casos_docs/".$ref);

   }
   if(!mysql_error()){
      echo "Subido correctamente";
   }
}elseif($_SERVER["REQUEST_METHOD"] == "GET"){
   $caso_id = $_GET["caso_id"];
   $res = [];

   $stmt = "SELECT * FROM casos_documentos WHERE caso_id = $caso_id";
   $casos_documentos = mysql_query($stmt);

   while($fila = mysql_fetch_assoc($casos_documentos)){
      array_push($res, $fila);
   }

   echo json_encode($res);
}elseif($_SERVER["REQUEST_METHOD"] == "DELETE"){
   // Eliminar un documento de tareo especifico
   $datos = json_decode(file_get_contents("php://input"), true);
   $cado_id = $datos["cado_id"];

   echo "Hola";
   print_r($datos);

   $stmt = "DELETE FROM casos_documentos WHERE cado_id = $cado_id";
   mysql_query($stmt);
}



?>