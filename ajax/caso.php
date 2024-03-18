<?php 
session_start();

include "../conexion.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

   if(isset($_POST["fecha_revision"]) and !empty($_POST["fecha_revision"])){
      // print_r($_POST);
      // Actualizar fecha de revision

      $caso_id = $_POST["caso_id"];
      $fecha_analisis = $_POST["fecha_revision"];
      $stmt = "UPDATE casos 
      SET caso_fecha_analisis = '$fecha_analisis'
      WHERE caso_id =  $caso_id";

      $rs = mysql_query($stmt, $dbh);
      if(!mysql_error()){
         $msg = "Actualizada correctamente";
      }else{
         $msg = "Error";
      }
      
      $rs = [
         "fecha" => $fecha_analisis,
         "msg" => $msg
      ];
   
      echo json_encode($rs);

   }elseif(!empty($_FILES["new_docs"]["name"]) and isset($_FILES["new_docs"]["name"])){
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
   }else{
      echo "Error";
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
}elseif($_SERVER["REQUEST_METHOD"] == "PUT"){
   // print_r(file_get_contents("php://input"));
   //Aprobar los casos
   $_PUT = json_decode(file_get_contents("php://input"), true);
   // print_r($_SESSION["login_user"]);
   $caso_id = $_PUT["caso_id"];
   $observaciones = $_PUT["observaciones"];
   $user_id = $_SESSION["login_user"];

   $stmt = "UPDATE casos 
   SET usua_id_revisado = $user_id,
   caes_id = 3,
   caso_observaciones = '$observaciones'
   WHERE caso_id = $caso_id";
   mysql_query($stmt);

   echo "Caso revisado";

}



?>