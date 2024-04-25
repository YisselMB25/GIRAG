<?php
include '../conexion.php';
include '../funciones.php';
session_start();

switch ($_SERVER["REQUEST_METHOD"]) {
   case "POST":
      $caes_id = $_POST["caes_id"]; //Verifica si es un borrador o ya lo vamos a recibir
      $carg_notas = "";
      $no_recibo = $_POST["no_recibo"]; //Numero de recibo
      $carg_guia = $_POST["guia"]; //Numero de guia
      //$shipper_id = $_POST["shipper"]; //Va a recibir id
      //$consignee = $_POST["consignee"]; //Va a recibir id
      $agencia = $_POST["agencia"]; //Va a recibir un ID
      $vuelo = $_POST["vuelo"];
      $destino_final_id = $_POST["destino_final"]; //ID del puerto al que va
      $fecha_recepcion_real = $_POST["recepcion_real"];
      $usua_id_creador = $_SESSION["login_user"]; //Podemos usar la variable de Sesion para asignar este valor
      $fecha_creado = $_POST["fecha_creacion"];
      $cati_id = $_POST["direccion"]; //Import, export ...

      // Valores para carga de tipo import -> $carga_tipo = 1
      $trans_nombre = isset($_POST["trans_nombre"]) ? $_POST["trans_nombre"] : "";
      $trans_cedula = isset($_POST["trans_cedula"]) ? $_POST["trans_cedula"] : "";
      $trans_matricula = isset($_POST["trans_matricula"]) ? $_POST["trans_matricula"] : "";
      $transporte_id = isset($_POST["transporte_id"]) ? $_POST["transporte_id"] : "";


      $error = "";

      if($cati_id == 1){
         $stmt = "INSERT INTO carga(cati_id, carg_guia, carg_fecha_registro, vuel_id, aeco_id_destino_final, usua_id_creador, carg_recepcion_real, carg_notas, liae_id, caes_id, carg_transportista, carg_transportista_cedula, carg_transportista_matricula, tran_id, carg_no_recibo) VALUES('$cati_id', '$carg_guia', '$fecha_recepcion_real', '$vuelo', '$destino_final_id', '$usua_id_creador', '$fecha_creado', '$carg_notas', '$agencia', '$caes_id', '$trans_nombre', '$trans_cedula', '$trans_matricula', '$transporte_id', '$no_recibo')";
      }else{
         $stmt = "INSERT INTO carga(cati_id, carg_guia, carg_fecha_registro, vuel_id, aeco_id_destino_final, usua_id_creador, carg_recepcion_real, carg_notas, liae_id, caes_id, carg_no_recibo) VALUES('$cati_id', '$carg_guia', '$fecha_recepcion_real', '$vuelo', '$destino_final_id', '$usua_id_creador', '$fecha_creado', '$carg_notas', '$agencia', '$caes_id', '$no_recibo')";
      }
      
      mysql_query($stmt);
      $last_insert_id = mysql_insert_id();

      echo json_encode(["carg_id" => $last_insert_id]);

      if(mysql_error()){
         http_response_code(400);
         echo json_encode(["error" => "Ha ocurrido un error"]);
      }

      break;
      case "GET":
         $carg_id = $_GET["carg_id"];
         $stmt = "SELECT * FROM carga_detalles WHERE carg_id = $carg_id";
         
         $res = [];
         $query = mysql_query($stmt);
         
         if ($query) {
            while($fila = mysql_fetch_assoc($query)){
               $res[] = $fila;
            }
            echo json_encode($res);
      
         } else {
            echo json_encode(["error" => "Error al obtener los detalles de carga"]);
         }
      break;
   
}
