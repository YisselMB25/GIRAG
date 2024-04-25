<?php
include '../conexion.php';
include '../funciones.php';

switch ($_SERVER["REQUEST_METHOD"]) {
   case "POST":

      $carg_id = $_POST["carg_id"];
      $cade_peso = $_POST["cade_peso"];
      $cade_largo = $_POST["cade_largo"];
      $cade_ancho = $_POST["cade_ancho"];
      $cade_alto = $_POST["cade_alto"];
      $cade_piezas = $_POST["cade_piezas"];
      $cade_recibidas = $_POST["cade_recibidas"];
      $cade_salida = $_POST["cade_salida"];
      $coin_id = $_POST["coin_id"];
      $cade_desc = $_POST["cade_desc"];
      $cade_notas = $_POST["cade_notas"];
      $cade_localizacion = $_POST["cade_localizacion"];

      if(empty($cade_peso) or empty($cade_largo) or empty($cade_alto) or empty($cade_localizacion) or $coin_id == 0){
         http_response_code(400);
         echo json_encode(["error" => "No se puede registrar"]);
      }else{
         $stmt = "INSERT INTO carga_detalles(
         carg_id, 
         cade_peso, 
         cade_largo, 
         cade_ancho, 
         cade_alto, 
         cade_piezas, 
         cade_recibidas, 
         cade_salida, 
         coin_id, 
         cade_desc, 
         cade_notas, 
         cade_localizacion)
          VALUES (
            '$carg_id', 
            '$cade_peso', 
            '$cade_largo', 
            '$cade_ancho', 
            '$cade_alto', 
            '$cade_piezas', 
            '$cade_recibidas', 
            '$cade_salida',
            '$coin_id', 
            '$cade_desc',
            '$cade_notas',
            '$cade_localizacion')";

         
         $res = mysql_query($stmt); //Ejecutamos

         if(mysql_error()){
            echo json_encode(["error_sql" => mysql_error()]);
         }
         
         echo json_encode(["success" => "Se ha enviado correctamente"]);
      }
      break;
      default: 
         break;
}