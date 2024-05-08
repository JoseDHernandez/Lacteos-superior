<?php
include("../../templates/rutas.php");
$IdPedido = "";
if (isset($_POST['type']) && $_POST['type'] == "true") {
    session_start();
    if (isset($_SESSION['auth']) && isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
        include('../../DATABASE.php');

        // Obtener los detalles de los productos en el carrito
        $Ids = implode(",", array_column($_SESSION["carrito"], 0));
        $SQL = $CONEXION->prepare("SELECT Id, precio, descuento FROM producto WHERE Id IN ($Ids)");
        $SQL->execute();
        $productos = $SQL->fetchAll(PDO::FETCH_ASSOC);

        if (count($productos) > 0) {
            //total
            $total = 0;
            function buscarProductoEnCarrito($idProducto, &$carrito)
            {
                foreach ($carrito as $indice => $producto) {
                    if ($producto[0] == $idProducto) {
                        return $indice;
                    }
                }
                return -1; // Si no se encuentra el producto, se devuelve -1
            }

            // Generar un UID único
            $uid = uniqid('', true);

            // Insertar datos en la tabla pedido
            $SQL = $CONEXION->prepare("INSERT INTO `pedido`(`estado`, `codigo`) 
            VALUES (:estado, :codigo)");
            $estado = 'Pendiente'; // Por defecto, el estado es pendiente
            $SQL->bindParam(":estado", $estado, PDO::PARAM_STR);
            $SQL->bindParam(":codigo", $uid, PDO::PARAM_STR);
            $SQL->execute();

            //Generar factura
            //Obtener id pedido
            $SQL = $CONEXION->prepare("SELECT Id FROM pedido WHERE codigo=:codigo");
            $SQL->bindParam(':codigo', $uid, PDO::PARAM_STR);
            $SQL->execute();
            $IdPedido = $SQL->fetch(PDO::FETCH_ASSOC);
            $IdPedido = $IdPedido["Id"];
            // Insertar datos en la tabla compra
            $sql = "INSERT INTO compra (`fk_cliente`, `fk_producto`,fk_pedido, `cantidad`, `valor`) VALUES";
            foreach ($productos as $producto) {
                $valor = $producto['precio'] - ($producto['descuento'] * $producto['precio']);
                $cantidad = $_SESSION['carrito'][buscarProductoEnCarrito($producto['Id'], $_SESSION['carrito'])][1];
                $total += $valor * $cantidad;
                $sql .= "(" . $_SESSION['Id'] . "," . $producto['Id'] . "," . $IdPedido . "," . $cantidad . "," . $valor . "),";
            }
            $sql = rtrim($sql, ','); // Eliminar la última coma
            $SQL = $CONEXION->prepare($sql);
            $SQL->execute();
            //Insertar factura
            $SQL = $CONEXION->prepare("INSERT INTO `factura`(`fk_pedido`, `estado`, `total`) 
            VALUES (:pedido,:estado,:total)");
            $SQL->bindParam(":pedido", $IdPedido, PDO::PARAM_INT);
            $SQL->bindParam(":estado", $estado);
            $SQL->bindParam(":total", $total);
            $SQL->execute();
            //idpedido a url
            $IdPedido = "?pedido=" . $IdPedido;
            $_SESSION['carrito'] = [];
            header('Location:' . $URL . "pedidos/" . $IdPedido);
        }
    }
}
