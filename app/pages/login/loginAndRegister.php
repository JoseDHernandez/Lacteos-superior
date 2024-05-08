<?php
session_start();
if ($_POST) {
    include("../../DATABASE.php");
    // print_r($_POST);
    $Type = $_POST['type'];
    if ($Type == "login") {
        echo "login";
        $email = $_POST['email'];
        $password = $_POST['password'];
        //Consulta
        $SQL = $CONEXION->prepare("SELECT id,nombre,contrasena,fk_rol  as rol,COUNT(*) as 'total' FROM usuario WHERE email=:Email AND contrasena=:Pass");
        //Ejecuto
        $SQL->bindParam(":Email", $email);
        $SQL->bindParam(":Pass", $password);
        $SQL->execute();
        $Usuarios = $SQL->fetchAll(PDO::FETCH_ASSOC);
        print_r($Usuarios);
        //Sesion
        if ($Usuarios[0]['total'] == 1) {
            $_SESSION['Id'] = $Usuarios[0]['id'];
            $_SESSION['Nombre'] = $Usuarios[0]['nombre'];
            $_SESSION['Rol'] = $Usuarios[0]['rol'];
            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }
            $_SESSION['auth'] = true;
            if ($Usuarios[0]['rol'] == 1) {
                header('Location:../catalogo/');
            } else {
                header('Location:../pedidos/');
            }
        } else {
            header('Location:./?Error=login');
        }
    } elseif ($Type == "register") {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $movil = $_POST['movil'];
        $tipo_identificacion = $_POST['tipo_identificacion'];
        $numero_identificacion = $_POST['numero_identificacion'];
        $password = $_POST['password'];
        $direccion = $_POST['direccion'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $tipo_persona = $_POST['tipo_persona'];
        $empresa = (isset($_POST['empresa'])) ? $_POST['empresa'] : '';

        // Preparar la consulta
        $SQL = $pdo->prepare("INSERT INTO usuario (nombre, email, movil, fk_identificacion, identificacion, contrasena, direccion, fecha_nacimiento, fk_rol, fk_tipo_persona,empresa) 
        VALUES (:nombre, :email, :movil, :fk_identificacion, :identificacion, :contrasena, :direccion, :fecha_nacimiento, :fk_rol, :fk_tipo_persona,:empresa)");

        // Ejecutar la consulta
        $SQL->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':movil' => $movil,
            ':fk_identificacion' => $tipo_identificacion,
            ':identificacion' => $numero_identificacion,
            ':contrasena' => $password,
            ':direccion' => $direccion,
            ':fecha_nacimiento' => $fecha_nacimiento,
            ':fk_rol' => 1, // Cliente
            ':fk_tipo_persona' => $tipo_persona,
            ':empresa' => $empresa,
        ]);
        //Valido si hay error
        if ($SQL->rowCount() > 0) {
            header('Location:../catalogo/');
        } else {
            header('Location:./?Error=register');
        }
    }
}
