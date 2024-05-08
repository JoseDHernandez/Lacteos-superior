<?php
include("../../DATABASE.php");
if (isset($_POST["type"]) && $_POST["type"] == "upload") {

    $titulo = $_POST["titulo"];
    $asuntoId = $_POST["asunto"];
    $mensaje = $_POST["mensaje"];
    //variables opcionales
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
    $empresa = isset($_POST["empresa"]) ? $_POST["empresa"] : "";
    $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : "";
    $correo = isset($_POST["correo"]) ? $_POST["correo"] : "";
    //SQL
    if (isset($_SESSION['auth'])) {
        $SQL = $CONEXION->prepare("INSERT INTO `consulta`(`fk_asunto`, `fk_cliente`, `mensaje`, `titulo`) 
            VALUES (:asunto,:cliente:,:mensaje,:titulo)");
        $SQL->execute([
            ":asunto" => $asuntoId,
            ":cliente" => $_SESSION['Id'],
            ":mensaje" => $mensaje,
            ":titulo" => $titulo
        ]);
    } else {
        $SQL = $CONEXION->prepare("INSERT INTO `consulta`(`fk_asunto`, `mensaje`, `titulo`, `nombre`, `empresa`, `telefono`, `correo`) 
            VALUES (:asunto,:mensaje,:titulo,:nombre,:empresa,:telefono,:correo)");
        $SQL->execute([
            ":asunto" => $asuntoId,
            ":mensaje" => $mensaje,
            ":titulo" => $titulo,
            ":nombre" => $nombre,
            ":empresa" => $empresa,
            ":telefono" => $telefono,
            "correo" => $correo
        ]);
    }
    //redirecion
    if ($SQL->rowCount() > 0) {
        header('Location:./');
    } else {
        header('Location:./?Error');
    }
}
