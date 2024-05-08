<?php
$_SERVER = "localhost";
$_DATA_BASE_NAME = "Lacteos";
$_USER_DB = "root";
$_PASSWORD_DB = "";
try {
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    $CONEXION = new PDO("mysql:host=$_SERVER;dbname=$_DATA_BASE_NAME", $_USER_DB, $_PASSWORD_DB, $options);
    //echo "Conectado<br/>";
} catch (Exception $error) {
    echo $error->getMessage();
}
