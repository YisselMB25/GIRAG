<?php
include '../conexion.php';
include '../funciones.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comentario = $_POST["comentario"];
    $reporte_id = $_GET["id"];
    $estado_id = $_GET["estado_id"];

    if (!empty($reporte_id)) {
        $stmt = "UPDATE reportes_documentos_bitacora SET redb_comentario = '$comentario' WHERE redb_id = $reporte_id";
        mysql_query($stmt);
    } else {
        echo "Error: ID de registro no proporcionado";
    }
}
?>
