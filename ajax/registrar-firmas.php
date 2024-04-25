<?php

include "../conexion.php";

switch($_SERVER["REQUEST_METHOD"]){
   case "POST":
      $usua_id = $_POST["usuario_firma"];
      
      //USFI_REF
      $temp_file = $_FILES["usfi_ref"]["tmp_name"];
      $nuevo_nombre = time() . "-" .$_FILES["usfi_ref"]["full_path"];

      $sql = "INSERT INTO usuarios_firmas(usua_id, usfi_ref) VALUES('$usua_id', '$nuevo_nombre')";
      mysql_query($sql);

      if(mysql_error()){
         echo "USUARIO CON FIRMA EXISTENTE";
         http_response_code(400);
         die();
      }

      move_uploaded_file($temp_file, "../firmas-electronicas/".$nuevo_nombre);
      break;
}




?>