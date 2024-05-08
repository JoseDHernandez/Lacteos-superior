<?php
session_start();
include("../../templates/rutas.php");
if (isset($_POST["mensaje"]) && isset($_POST["calificacion"]) && isset($_POST["id"]) && isset($_SESSION['auth'])) {
    $id = $_POST['id']; // ID del producto
    $mensaje = $_POST['mensaje']; // Contenido del comentario
    $calificacion = $_POST['calificacion']; // Calificación del comentario
    //
    include('../../DATABASE.php');
    $SQL = $CONEXION->prepare("INSERT INTO  comentario (fk_producto,fk_cliente,mensaje,calificacion) VALUES (:producto,:cliente,:mensaje,:calificacion)");
    $SQL->bindParam(":producto", $id);
    $SQL->bindParam(":cliente", $_SESSION['Id']);
    $SQL->bindParam(":mensaje", $mensaje);
    $SQL->bindParam(":calificacion", $calificacion);
    $SQL->execute();
    header("Location:" . $URL . "catalogo/producto.php?producto=" . $id);
} else {
    header("Location:" . $URL . "catalogo/");
}
