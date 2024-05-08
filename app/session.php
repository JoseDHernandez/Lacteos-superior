<?php
session_start();
//cerrar sesion
if (isset($_GET['Exit']) && isset($_SESSION['auth'])) {
    session_destroy();
    header('Location:http://localhost/Lacteos/app/pages/catalogo/');
}
