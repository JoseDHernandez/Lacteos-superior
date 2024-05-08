<?php
// Si se envió el formulario de registro o edición de producto
session_start();
if ($_SESSION['Rol'] !== 2) {
    session_destroy();
    header("Location:../pages/login/");
    exit;
}
if (isset($_POST['new'])) {
    //eliminar
    if ($_POST['new'] == 'delete') {
        $imagen_anterior = $_POST['imagen'];
        $ruta = $_SERVER['DOCUMENT_ROOT'] . '/Lacteos/app/assets/images/';
        // Eliminar la imagen anterior si existe
        if (!empty($imagen_anterior) && $imagen_anterior !== "product_default.png") {
            $ruta_imagen_anterior = $ruta . $imagen_anterior;
            if (file_exists($ruta_imagen_anterior)) {
                unlink($ruta_imagen_anterior);
            }
        }
        //Eliminar en base de datos
        include('../DATABASE.php');
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $SQL = $CONEXION->prepare('DELETE FROM producto WHERE Id=:id');
        $SQL->bindParam(':id', $id, PDO::PARAM_INT);
        $SQL->execute();
        header("Location:../pages/productos/");
    }
    // Verificar si es un nuevo producto
    elseif ($_POST['new'] == "newPro" || $_POST['new'] == "actualizar") {
        // Validar y procesar los datos del formulario de registro de producto
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $existencias = $_POST['existencias'];
        $cantidad = $_POST['cantidad'];
        $oferta = $_POST['oferta'];
        $descuento = $_POST['descuento'] / 100;
        $descripcion = $_POST['descripcion'];

        // Obtener el nombre de la imagen anterior desde la base de datos

        $id = isset($_POST['id']) ? $_POST['id'] : '';

        // Manejar la carga de la imagen al servidor
        $ruta = $_SERVER['DOCUMENT_ROOT'] . '/Lacteos/app/assets/images/';
        //Actualizar
        if ($_POST['new'] == "actualizar") {
            //Imagen anterior
            $imagen_anterior = $_POST['urlImagen'];
            // Eliminar la imagen anterior si existe
            if (!empty($imagen_anterior) && $imagen_anterior !== "product_default.png") {
                $ruta_imagen_anterior = $ruta . $imagen_anterior;
                if (file_exists($ruta_imagen_anterior)) {
                    unlink($ruta_imagen_anterior);
                }
            }
            $sql = "UPDATE producto SET nombre=:nombre,descripcion=:descripcion,precio=:precio,
                imagen=:imagen,existencias=:existencias,cantidad_contenido=:cantidad,oferta=:oferta,descuento=:descuento WHERE id=:id";
        } else {
            //insertar
            $sql = "INSERT INTO producto (nombre,descripcion,precio,imagen,existencias,cantidad_contenido,oferta,descuento) VALUES 
                (:nombre,:descripcion,:precio,:imagen,:existencias,:cantidad,:oferta,:descuento)";
        }

        // Nombre y ruta de la nueva imagen
        if (!empty($_FILES['Imagen']['name'])) {
            $uid = uniqid('', true);
            $tipo_imagen = $_FILES['Imagen']['type'];
            $imagen_nombre = $_FILES['Imagen']['name'];
            $tamano_imagen = $_FILES['Imagen']['size'];
            // Mover la nueva imagen al servidor
            $rutaTemp = $_SERVER['DOCUMENT_ROOT'] . '/Lacteos/app/assets/temp_img/';
            move_uploaded_file($_FILES['Imagen']['tmp_name'], $rutaTemp . $imagen_nombre);
            $TypeImgChange = "png";
            switch ($tipo_imagen) {
                case 'image/png':
                    $TypeImgChange = "png";
                    break;
                case 'image/jpg':
                    $TypeImgChange = "jpg";
                    break;
                case 'image/jpeg':
                    $TypeImgChange = "jpeg";
                    break;
                default:
                    $TypeImgChange = "png";
                    break;
            }
            $imagen_nombre_new = $uid . "." . $TypeImgChange;
            rename($rutaTemp . $imagen_nombre, $ruta . $imagen_nombre_new);
            $imagen_nombre = $imagen_nombre_new;
        } else {
            // Código de acción si no se envió una imagen
            if ($_POST['new'] == "actualizar") {
                $imagen_nombre = $_POST['urlImagen'];
            } else {
                $imagen_nombre = "product_default.png";
            }
        }

        //consultar
        include("../DATABASE.php");
        $SQL = $CONEXION->prepare($sql);
        $SQL->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $SQL->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $SQL->bindParam(':precio', $precio, PDO::PARAM_INT);
        $SQL->bindParam(':imagen', $imagen_nombre, PDO::PARAM_STR);
        $SQL->bindParam(':existencias', $existencias, PDO::PARAM_INT);
        $SQL->bindParam(':cantidad', $cantidad, PDO::PARAM_STR);
        $SQL->bindParam(':oferta', $oferta, PDO::PARAM_STR);
        $SQL->bindParam(':descuento', $descuento, PDO::PARAM_STR);
        //Actualizar
        if ($_POST['new'] == "actualizar") {
            $SQL->bindParam(':id', $id);
        }
        $SQL->execute();
        //Categorias
        //Borrar actuales
        if ($_POST['new'] == "actualizar") {
            $SQL = $CONEXION->prepare("SELECT GROUP_CONCAT(Id) as 'Id' FROM producto_categoria WHERE fk_producto = :id");
            $SQL->bindParam(":id", $id, PDO::PARAM_INT);
            $SQL->execute();
            $categorias = $SQL->fetch(PDO::FETCH_ASSOC);
            $SQL = $CONEXION->prepare("DELETE FROM producto_categoria WHERE FIND_IN_SET(Id,:ids)");
            $SQL->bindParam(":ids", $categorias['Id'], PDO::PARAM_STR);
            $SQL->execute();
        }
        //Obtener categorias  
        $SQL = $CONEXION->prepare("SELECT * FROM categoria");
        $SQL->execute();
        $Categorias = $SQL->fetchAll(PDO::FETCH_ASSOC);
        $categoriasIds = "";
        //Id del nuevo producto
        if ($_POST['new'] == "newPro") {
            $SQL = $CONEXION->prepare("SELECT Id FROM producto WHERE imagen=:imagen AND nombre=:nombre");
            $SQL->bindParam(":imagen", $imagen_nombre, PDO::PARAM_STR);
            $SQL->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $SQL->execute();
            $id = $SQL->fetch(PDO::FETCH_ASSOC);
            $id = $id['Id'];
        }
        foreach ($Categorias as $categoria) {
            $nombre_categoria = $categoria['nombre'];
            $id_categoria = $categoria['Id'];

            // Verificar si el checkbox fue marcado en el formulario
            if (isset($_POST[$nombre_categoria])) {
                $categoriasIds .= "($id , $id_categoria),";
            }
        }
        $categoriasIds = substr($categoriasIds, 0, -1);
        if (count_chars($categoriasIds) == 0) {
            $categoriasIds = "($id , 1)";
        }
        $SQL = $CONEXION->prepare("INSERT INTO producto_categoria (fK_producto,fk_categoria) VALUES " . $categoriasIds);
        $SQL->execute();
        header("Location:../pages/catalogo/producto.php?producto=" . $id);
    }
    // Verificar si es una nueva categoría
    elseif ($_POST["new"] == "newCat" && isset($_POST["type"])) {
        // Validar y procesar los datos del formulario de registro de categoría
        include('../DATABASE.php');
        $id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
        if ($_POST['type'] == "register" || $_POST['type'] == "update") {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $sql = "";
            if ($_POST['type'] == "update") {
                $sql = "UPDATE categoria SET nombre=:nombre, descripcion=:descripcion WHERE Id=:id";
            } else {
                $sql = "INSERT INTO categoria (nombre,descripcion) VALUES (:nombre,:descripcion)";
            }
            $SQL = $CONEXION->prepare($sql);
            $SQL->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $SQL->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            if ($_POST['type'] == "update") {
                $SQL->bindParam(":id", $id, PDO::PARAM_INT);
            }
            $SQL->execute();
        } elseif ($_POST['type'] == "delete") {
            //El id 1 no se puede borrar
            if ($id !== 1) {
                $SQL = $CONEXION->prepare("DELETE FROM categoria WHERE Id=:id");
                $SQL->bindParam(":id", $id, PDO::PARAM_INT);
                $SQL->execute();
            }
        }
        header("Location:../pages/productos/work.php?new=newCat");
    } else {
        // Redirigir a la página principal de administración si no se reconoce la acción
        //header("Location:../pages/productos/");
    }
}
