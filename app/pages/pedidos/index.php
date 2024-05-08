<?php
session_start();
include("../../templates/rutas.php");
// Verificar si el usuario está autenticado
if (!isset($_SESSION['auth'])) {
    header('Location: ' . $URL_LOGIN); // Redireccionar al usuario a la página de inicio de sesión si no está autenticado
    exit();
}

// Incluir el encabezado de la página
include("../../templates/header.php");

// Obtener el ID del pedido desde la URL
$pedido_id = isset($_GET['pedido']) ? $_GET['pedido'] : null;
if ($_SESSION['auth'] && $_SESSION['Rol'] == 2 && $pedido_id == null) {
    include("../../DATABASE.php");
    $pedido_id = isset($_POST['id']) ? $_POST['id'] : '';
    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
    $cliente_id = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : '';
    $sql = "SELECT ROUND(f.total* f.iva,0) AS 'total',p.Id as 'Id', p.estado as 'estP', p.codigo as 'codigo', u.nombre as 'nombre', p.tiempo as 'timP', f.tiempo as 'timF',f.estado as 'estF', detalles
    FROM compra c
    INNER JOIN pedido p ON c.fk_pedido = p.Id
    inner join usuario u on c.fk_cliente = u.Id
    inner join factura f on f.fk_pedido = p.Id
    ";
    if (!empty($pedido_id) || !empty($codigo) || !empty($cliente_id)) {
        $sql .= " WHERE";
    }
    if (!empty($pedido_id)) {
        $sql .= " p.Id = :id OR";
    }
    if (!empty($codigo)) {
        $sql .= " p.codigo = :codigo OR";
    }
    if (!empty($cliente_id)) {
        $sql .= " u.Id = :id_cliente OR";
    }
    $sql = substr($sql, 0, -2);
    $sql .= " GROUP BY p.Id";
    // Preparar la consulta
    $SQL = $CONEXION->prepare($sql);

    // Asociar los parámetros y ejecutar la consulta
    if (!empty($pedido_id)) {
        $SQL->bindParam(":id", $pedido_id);
    }
    if (!empty($codigo)) {
        $SQL->bindParam(":codigo", $codigo);
    }
    if (!empty($cliente_id)) {
        $SQL->bindParam(":id_cliente", $cliente_id);
    }
    $SQL->execute();

    // Obtener los resultados
    $pedidos = $SQL->fetchAll(PDO::FETCH_ASSOC);

?>
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold my-4">Listado de Pedidos</h1>
        <?php if (count($pedidos) > 0) : ?>
            <!-- Formulario de filtros -->
            <form method="post">
                <div class="grid grid-cols-3">
                    <div class="mb-4">
                        <label for="id" class="block font-semibold mb-2">ID Pedido:</label>
                        <input type="text" id="id" name="id" class="border border-gray-300 rounded-lg p-2" value="<?php echo $pedido_id; ?>">
                    </div>
                    <div class="mb-4">
                        <label for="codigo" class="block font-semibold mb-2">Código:</label>
                        <input type="text" id="codigo" name="codigo" class="border border-gray-300 rounded-lg p-2" value="<?php echo $codigo; ?>">
                    </div>
                    <div class="mb-4">
                        <label for="id_cliente" class="block font-semibold mb-2">ID Cliente:</label>
                        <input type="text" id="id_cliente" name="id_cliente" class="border border-gray-300 rounded-lg p-2" value="<?php echo $cliente_id; ?>">
                    </div>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filtrar</button>
            </form>
            <!-- Resultados de los pedidos -->
            <div class="mt-8">
                <table class="border-collapse border border-gray-400">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-400 p-2">ID</th>
                            <th class="border border-gray-400 p-2">Total</th>
                            <th class="border border-gray-400 p-2">Estado Pedido</th>
                            <th class="border border-gray-400 p-2">Código</th>
                            <th class="border border-gray-400 p-2">Nombre Cliente</th>
                            <th class="border border-gray-400 p-2">Tiempo Pedido</th>
                            <th class="border border-gray-400 p-2">Tiempo Factura</th>
                            <th class="border border-gray-400 p-2">Estado Factura</th>
                            <th class="border border-gray-400 p-2">Detalles</th>
                            <th class="border border-gray-400 p-2">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido) : ?>
                            <tr>
                                <td class="border border-gray-400 p-2"><?php echo  $pedido['Id']; ?></td>
                                <td class="border border-gray-400 p-2"><?php echo $pedido['total']; ?></td>
                                <td class="border border-gray-400 p-2"><?php echo $pedido['estP']; ?></td>
                                <td class="border border-gray-400 p-2"><?php echo $pedido['codigo']; ?></td>
                                <td class="border border-gray-400 p-2"><?php echo $pedido['nombre']; ?></td>
                                <td class="border border-gray-400 p-2"><?php echo $pedido['timP']; ?></td>
                                <td class="border border-gray-400 p-2"><?php echo $pedido['timF']; ?></td>
                                <td class="border border-gray-400 p-2"><?php echo $pedido['estF']; ?></td>
                                <td class="border border-gray-400 p-2"><?php echo $pedido['detalles']; ?></td>
                                <td class="border border-gray-400 p-2">
                                    <a href="<?php echo $URL . "pedidos/?pedido=" . $pedido['Id'] ?>">Ver</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <p>No hay pedidos</p>
        <?php endif; ?>
    </div>
    <?php

    // Verificar si se proporcionó un ID de pedido válido
} elseif (!$pedido_id) {
    if ($_SESSION['Rol'] !== 2) {
        include('../../DATABASE.php');
        $cliente_id = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : '';
        $sql = "SELECT ROUND(f.total* f.iva,0) AS 'total',p.Id as 'Id', p.estado as 'estP', p.codigo as 'codigo', u.nombre as 'nombre', p.tiempo as 'timP', f.tiempo as 'timF',f.estado as 'estF', detalles
    FROM compra c
    INNER JOIN pedido p ON c.fk_pedido = p.Id
    inner join usuario u on c.fk_cliente = u.Id
    inner join factura f on f.fk_pedido = p.Id
    WHERE c.fk_cliente = :id";
        $SQL = $CONEXION->prepare($sql);
        $SQL->bindParam(":id", $_SESSION['Id']);
        $SQL->execute();

        // Obtener los resultados
        $pedidos = $SQL->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold my-4">Listado de Pedidos</h1>
            <?php if (count($pedidos) > 0) : ?>
                <!-- Resultados de los pedidos -->
                <div class="mt-8">
                    <table class="border-collapse border border-gray-400">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-400 p-2">ID</th>
                                <th class="border border-gray-400 p-2">Total</th>
                                <th class="border border-gray-400 p-2">Estado Pedido</th>
                                <th class="border border-gray-400 p-2">Código</th>
                                <th class="border border-gray-400 p-2">Tiempo Pedido</th>
                                <th class="border border-gray-400 p-2">Tiempo Factura</th>
                                <th class="border border-gray-400 p-2">Estado Factura</th>
                                <th class="border border-gray-400 p-2">Detalles</th>
                                <th class="border border-gray-400 p-2">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $pedido) : ?>
                                <tr>
                                    <td class="border border-gray-400 p-2"><?php echo  $pedido['Id']; ?></td>
                                    <td class="border border-gray-400 p-2"><?php echo $pedido['total']; ?></td>
                                    <td class="border border-gray-400 p-2"><?php echo $pedido['estP']; ?></td>
                                    <td class="border border-gray-400 p-2"><?php echo $pedido['codigo']; ?></td>
                                    <td class="border border-gray-400 p-2"><?php echo $pedido['timP']; ?></td>
                                    <td class="border border-gray-400 p-2"><?php echo $pedido['timF']; ?></td>
                                    <td class="border border-gray-400 p-2"><?php echo $pedido['estF']; ?></td>
                                    <td class="border border-gray-400 p-2"><?php echo $pedido['detalles']; ?></td>
                                    <td class="border border-gray-400 p-2">
                                        <a href="<?php echo $URL . "pedidos/?pedido=" . $pedido['Id'] ?>">Ver</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="text-center text-2xl mt-16">No hay pedidos, pero puedes ingresar en el cat&aacute;logo y descubir por que nos prefieres</p>
                <div class="flex justify-center mt-8">
                    <a class="text-white text-xl py-2 px-4 bg-red-500 rounded hover:bg-red-600" href="<?php echo $URL . "catalogo/" ?>">Ir al cat&aacute;logo </a>
                </div>
            <?php endif; ?>
        </div>
    <?php
    } else {
    ?>
        <p>No se ha proporcionado un ID de pedido válido.</p>
        <?php
    }
} else {
    // Consultar la base de datos para obtener los detalles del pedido
    include("../../DATABASE.php");

    // Consulta para obtener los detalles del pedido
    $sql = "SELECT p.Id as 'Id', codigo,estado,tiempo,detalles FROM compra INNER JOIN pedido p ON fk_pedido = p.Id WHERE p.Id = :pedido_id ";
    if ($_SESSION['Rol'] !== 2) {
        $sql .= 'AND fk_cliente = :id';
    }
    $stmt = $CONEXION->prepare($sql);
    $stmt->bindParam(':pedido_id', $pedido_id, PDO::PARAM_INT);
    if ($_SESSION['Rol'] !== 2) {
        $stmt->bindParam(':id', $_SESSION['Id'], PDO::PARAM_INT);
    }
    $stmt->execute();
    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
    if (count($pedido) > 0) {
        // Verificar si se encontró el pedido
        if (!$pedido) {
            echo "<p>No se encontró el pedido solicitado.</p>";
        } else {
            // Consulta para obtener los detalles de los productos comprados en el pedido
            $sql_productos = "SELECT c.cantidad as 'cantidad', c.fk_cliente as 'cli',c.valor as 'precio', p.nombre as 'nombre', c.valor*c.cantidad as 'valor' 
        FROM compra c INNER JOIN producto p ON fk_producto = p.Id WHERE c.fk_pedido = :ids";
            $stmt_productos = $CONEXION->prepare($sql_productos);
            $stmt_productos->bindParam(':ids', $pedido_id);
            $stmt_productos->execute();
            $productos = $stmt_productos->fetchAll(PDO::FETCH_ASSOC);
            $id = $_SESSION['Rol'] == 2 ? $productos[0]['cli'] : $_SESSION['id'];
            //validar
            if ($_SESSION['Rol'] !== 2 && $_SESSION['Id'] !== $id) {
                header('./');
            }
            //consultar factura
            $SQL = $CONEXION->prepare("SELECT estado, tiempo,ROUND(total+(total*iva),0) as 'total',iva FROM factura WHERE fk_pedido=:pedido");
            $SQL->bindParam(":pedido", $pedido_id);
            $SQL->execute();
            $factura = $SQL->fetch(PDO::FETCH_ASSOC);
            //usuario
            $SQL = $CONEXION->prepare("SELECT u.nombre as 'nombre', email,movil, concat(i.tipo ,' ', u.identificacion) as 'identificacion',direccion,empresa, t.nombre as 'tipo' FROM usuario u INNER JOIN identificacion i ON i.Id=fk_identificacion INNER JOIN tipo t ON t.Id = fk_tipo_persona WHERE u.Id=:id");

            $SQL->bindParam(":id", $id, PDO::PARAM_INT);
            $SQL->execute();
            $usuario = $SQL->fetch(PDO::FETCH_ASSOC);
            // Mostrar los detalles del pedido y los productos comprados
        ?>
            <div class="container mx-auto my-8">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <h1 class="text-2xl font-semibold mb-4">Detalles del Pedido</h1>
                        <p class="mb-2"><strong>Código de Pedido:</strong> <?php echo $pedido['codigo']; ?></p>
                        <p class="mb-2"><strong>Estado:</strong> <?php echo $pedido['estado']; ?></p>
                        <p class="mb-2"><strong>Fecha y Hora:</strong> <?php echo $pedido['tiempo']; ?></p>
                        <p class="mb-2"><strong>Nombre: </strong><?php echo $usuario['nombre'] ?></p>
                        <p class="mb-2"><?php echo $usuario['empresa'] ?></p>
                        <p class="mb-2"><strong>Teléfono: </strong><?php echo $usuario['movil'] ?></p>
                        <p class="mb-2"><strong>Identificación: </strong><?php echo $usuario['identificacion'] ?></p>
                        <p class="mb-2"><strong>Tipo: </strong><?php echo $usuario['tipo'] ?></p>
                        <p class="mb-2"><strong>Dirección de Envío: </strong><?php echo $usuario['direccion'] ?></p>
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold mb-4">Detalles de la Factura</h2>
                        <p class="mb-2"><strong>Estado: </strong><?php echo $factura['estado'] ?></p>
                        <p class="mb-2"><strong>Fecha y hora: </strong><?php echo isset($factura['tiempo']) ? $factura['tiempo'] : "Aun no hay fecha y hora, pendiente de entrega y pago" ?></p>
                        <p class="mb-2"><strong>Precio total: </strong>$<?php echo number_format($factura['total']) ?></p>
                        <p class="mb-2"><strong>Iva: </strong><?php echo ($factura['iva'] * 100) . "%" ?></p>
                    </div>
                </div>
                <hr>
                <h2 class="text-xl font-semibold my-4">Productos Comprados</h2>
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="border border-gray-400 px-4 py-2">Nombre</th>
                            <th class="border border-gray-400 px-4 py-2">Cantidad</th>
                            <th class="border border-gray-400 px-4 py-2">Precio Unitario</th>
                            <th class="border border-gray-400 px-4 py-2">Precio Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto) : ?>
                            <tr>
                                <td class="border border-gray-400 px-4 py-2"><?php echo $producto['nombre']; ?></td>
                                <td class="border border-gray-400 px-4 py-2"><?php echo $producto['cantidad']; ?></td>
                                <td class="border border-gray-400 px-4 py-2">$<?php echo number_format($producto['precio']); ?></td>
                                <td class="border border-gray-400 px-4 py-2">$<?php echo number_format($producto['valor']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-right px-4 py-2">Precio total: </td>
                            <td class="border border-gray-400 px-4 py-2">$<?php echo number_format($factura['total']) ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-8">
                    <a class="text-white text-xl bg-red-500 py-2 px-4 rounded hover:bg-red-600" href="./">Volver a pedidos</a>
                    <?php if ($_SESSION['Rol'] == 1) : ?>
                        <a class="ml-8 text-white text-xl bg-red-500 py-2 px-4 rounded hover:bg-red-600" href="<?php echo $URL . "catalogo/" ?>">Ir al cat&aacute;logo</a>
                    <?php endif; ?>
                </div>
            </div>
<?php
        }
    }
}

// Incluir el pie de página
include("../../templates/footer.php");
?>