<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require "vendor/autoload.php";

// VARIABLES PRINCIPALES------------------------------
$smtp_username = "";
$smtp_password = "";
$smtp_host = "smtp.gmail.com";

// Conexion a la base de datos-----------------------
$server = "143.198.137.170";
$usuario = "dunderio_usr_girag";
$password = "Girag_2024!";
$db_nombre = "dunderio_girag";

// Realizar conexion
$con = new mysqli($server, $usuario, $password, $db_nombre);

if ($con->connect_error) {
   die("Error de conexion: " . $con->connect_error);
}

// Extraer la plantilla del Gmail
$sql = "SELECT cont_detalle FROM contratos WHERE cont_nombre = 'task-pending'";
$res = $con->query($sql);
$bodyEmail = $res->fetch_all()[0][0];

$sql = "SELECT cs.caso_id, caso_descripcion, 
(SELECT usua_mail FROM usuarios us WHERE us.usua_id = ct.usua_id) email_tarea_asignada,
(SELECT usua_mail FROM usuarios us2 WHERE us2.usua_id = cs.usua_id_asignado) email_caso_asignado,
cate_nombre, cate_fecha_cierre, cate_estado 
FROM casos_tareas ct 
INNER JOIN casos cs ON cs.caso_id = ct.caso_id
WHERE cate_estado = 3 AND cate_fecha_cierre BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)";

$res = $con->query($sql);

if ($res->num_rows > 0) {

   try {
      $mail = new PHPMailer(true);
      // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
      $mail->isSMTP();
      $mail->Host = $smtp_host;
      $mail->SMTPAuth = true;
      $mail->Username = $smtp_username;
      $mail->Password = $smtp_password;
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;
      $mail->CharSet = "UTF-8";
      
      while($fila = $res->fetch_assoc()){
         
         $correo_caso_asignado = $fila["email_caso_asignado"];//Email del usuario al que se asigno el seguimiento del caso
         $correo_tarea_asignada = $fila["email_tarea_asignada"];//Email del usuario que se le asigno el seguimiento de la tarea
         $caso_nombre = $fila["caso_descripcion"];
         $tarea_nombre = $fila["cate_nombre"];
         $caso_id = $fila["caso_id"];
         $fecha_cierre_tarea = $fila["cate_fecha_cierre"];
         
         
         $mail->setFrom($smtp_username, 'SISTEMA GIRAG - NOTIFICACIÓN');
         $mail->Subject = 'Notificación de tarea pendiente';
         $mail->addAddress($correo_tarea_asignada, "Coordinador de tarea");
         $mail->addAddress($correo_caso_asignado, "Coordinador de caso");
         $mail->isHTML(true);
         
         $bodyEmail = str_replace("[CASO]", $caso_id, $bodyEmail);
         $bodyEmail = str_replace("[TAREA]", $tarea_nombre, $bodyEmail);
         $bodyEmail = str_replace("[USUA_ASIGNADO_TAREA]", $correo_tarea_asignada, $bodyEmail);
         $bodyEmail = str_replace("[FECHA]", $fecha_cierre_tarea, $bodyEmail);
         
         $mail->Body = $bodyEmail;
         
         // Enviar correo electrónico
         if ($mail->send()) {
            echo 'Correo electrónico enviado correctamente';
         } else {
            echo 'Error al enviar el correo electrónico: ' . $mail->ErrorInfo;
         }
      }
   } catch (Exception $th) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
   }
}

$con->close();
