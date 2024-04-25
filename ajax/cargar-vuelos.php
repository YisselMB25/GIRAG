<?php
include "../conexion.php";
error_reporting(0);

// require "../PHPExcel/PHPExcel.php";
require "../excelReader/excel_reader2.php";
require "../excelReader/SpreadsheetReader.php";

/**
 * Primero hay que subir el archivo para luego traerlo en 
 * @param string $path 
 */

switch ($_SERVER["REQUEST_METHOD"]) {
   case "POST":

      // print_r($_FILES);

      if (isset($_FILES["excel"]["full_path"]) and !empty($_FILES["excel"]["full_path"])) {
         $path = "../vuelosExcel/"; //Carpeta donde se guardan los excels
         $nombreArchivo = time() . "-" . $_FILES["excel"]["full_path"];
         $tmpName = $_FILES["excel"]["tmp_name"];

         if (move_uploaded_file($tmpName, $path . $nombreArchivo)) {
            $sql = "INSERT INTO vuelos_docs(vudo_nombre) VALUES('$nombreArchivo')";
            mysql_query($sql);
         }
         /**
          * Vamos a traer el archivo desde el directorio donde lo guardamos y vamos a procesarlo para insertar en la tabla vuelos de acuerdo con sus datos
          */

         $reader = new SpreadsheetReader($path . $nombreArchivo);
         $valuesInsert = "";
         foreach ($reader as $key => $row) {
            $liae = $row[0];
            $origen = $row[1];
            $destino = $row[2];
            $fecha = $row[3];
            $codigoVuelo = $row[4];

            if (empty($liae)) {
               break;
            }

            $sql = "SELECT liae_id,
               (SELECT aeco_id FROM aereopuertos_codigos WHERE aeco_codigo = '$origen') origen,
               (SELECT aeco_id FROM aereopuertos_codigos WHERE aeco_codigo = '$destino') destino
               FROM lineas_aereas WHERE liae_nombre = '$liae'";
            $res = mysql_query($sql);
            $res = mysql_fetch_assoc($res);

            $liaeId = $res["liae_id"];
            $aecoOrigen = $res["origen"];
            $aecoDestino = $res["destino"];

            $valuesInsert .= "('$liaeId', '$aecoOrigen', '$aecoDestino', '$fecha', '$codigoVuelo'),";
         }


         if (!empty($valuesInsert)) {
            $valuesInsert = substr($valuesInsert, 0, -1);
            echo $sql = "INSERT INTO vuelos(liae_id, aeco_id_origen, aeco_id_destino, vuel_fecha, vuel_codigo) VALUES $valuesInsert";
            $res = mysql_query($sql);

            if (mysql_error()) {
               echo "error";
            }
         }
      } else {
         http_response_code(400);
         echo json_encode(["error" => "Archivo no encontrado"]);
      }
      break;
}
