<?php
session_start();
include("../../templates/rutas.php");
// Verificar si el usuario está autenticado
if (!isset($_SESSION['auth'])) {
    header('Location: ' . $URL_LOGIN); // Redireccionar al usuario a la página de inicio de sesión si no está autenticado
    exit();
}

//Eliminar carrito
$delete = (isset($_POST['deleteCar'])) ? true : false;
if (isset($_POST['deleteCar']) && count($_SESSION['carrito']) > 0) {
    // Verificar si el carrito existe y no está vacío
    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        // Vaciar el carrito
        $_SESSION['carrito'] = [];
    }
}
if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
    include("../../DATABASE.php");
    $Ids = implode(",", array_column($_SESSION["carrito"], 0));

    // Realizar la consulta SQL para obtener los detalles de los productos en el carrito
    $SQL = $CONEXION->prepare("SELECT Id, nombre, precio, imagen,descuento FROM producto WHERE Id IN ($Ids)");
    $SQL->execute();
    $productos = $SQL->fetchAll(PDO::FETCH_ASSOC);
    //Datos usuario
    $SQL = $CONEXION->prepare("SELECT u.nombre as 'nombre', email,movil, concat(i.tipo ,' ', u.identificacion) as 'identificacion',direccion,empresa, t.nombre as 'tipo' FROM usuario u INNER JOIN identificacion i ON i.Id=fk_identificacion INNER JOIN tipo t ON t.Id = fk_tipo_persona WHERE u.Id=:id");
    $SQL->bindParam(":id", $_SESSION['Id'], PDO::PARAM_INT);
    $SQL->execute();
    $usuario = $SQL->fetch(PDO::FETCH_ASSOC);
}
//Valor total
$total = 0;
include("../../templates/header.php");
?>
<div class="container mx-auto my-8 flex justify-center">
    <?php if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) : ?>
        <div class="grid grid-cols-3 gap-8">
            <!-- Primera columna: Tabla con los datos del producto -->
            <div class="col-span-2">
                <h2 class="text-2xl font-semibold mb-4">Detalle de los productos</h2>
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="border border-gray-400 px-4 py-2">Imagen</th>
                            <th class="border border-gray-400 px-4 py-2">Producto</th>
                            <th class="border border-gray-400 px-4 py-2">Precio por Unidad</th>
                            <th class="border border-gray-400 px-4 py-2">Cantidad</th>
                            <th class="border border-gray-400 px-4 py-2">Descuento</th>
                            <th class="border border-gray-400 px-4 py-2">Precio Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto) : ?>
                            <tr>
                                <td class="border border-gray-400 px-4 py-2"><img src="<?php echo $URL_IMG . "images/" . $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" class="w-24"></td>
                                <td class="border border-gray-400 px-4 py-2"><?php echo $producto['nombre']; ?></td>
                                <td class="border border-gray-400 px-4 py-2">$<?php echo number_format($producto['precio'], 0); ?></td>
                                <?php
                                $cantidad = $_SESSION['carrito'][array_search($producto['Id'], array_column($_SESSION['carrito'], 0))][1];
                                $precio = $producto['precio'] - ($producto['precio'] * $producto['descuento']);
                                $precio_total = $cantidad * $precio;
                                $total += $precio_total;
                                ?>
                                <td class="border border-gray-400 px-4 py-2"><?php echo $cantidad; ?></td>
                                <td class="border border-gray-400 px-2 py-2">
                                    <?php if ($producto['descuento'] > 0) : ?>
                                        <span class="text-center">
                                            <p class="my-2 bg-green-400 rounded"><?php echo ($producto['descuento'] * 100) . "%" ?></p>
                                            <p class="my-2 bg-gray-200 rounded"><?php echo "$" . number_format($precio, 0)   ?></p>
                                        </span>
                                    <?php else : ?>
                                        <p class="text-center text-2xl font-bold"> - </p>
                                    <?php endif; ?>
                                </td>
                                <td class="border border-gray-400 px-4 py-2">$<?php echo number_format($precio_total, 0); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Segunda columna: Información del pedido y botones -->
            <div>
                <h2 class="text-2xl font-semibold mb-4">Información del Pedido</h2>
                <p class="mb-4">Nombre: <?php echo $usuario['nombre'] ?></p>
                <p class="m-4"><?php echo $usuario['empresa'] ?></p>
                <p class="mb-4">Teléfono: <?php echo $usuario['movil'] ?></p>
                <p class="mb-4">Identificación: <?php echo $usuario['identificacion'] ?></p>
                <p class="mb-4">Tipo: <?php echo $usuario['tipo'] ?></p>
                <p class="mb-4">Dirección de Envío: <?php echo $usuario['direccion'] ?></p>
                <hr class="mb-4">
                <p class="mb-4 text-xl">Total del Pedido: $<?php echo number_format($total); ?></p>
                <div class="m-4 text-sm">
                    <p>Al confirmar el pedido se aplicará el IVA (19%)</p>
                    <p>Precio Total (con IVA): $<?php echo number_format($total * 1.19); ?></p>
                </div>
                <!-- Botones para confirmar o cancelar el pedido -->
                <div class="flex space-x-4">
                    <form method="POST" action="saveBuy.php">
                        <input type="hidden" name="type" value="true">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Confirmar Pedido</button>
                    </form>
                    <button onclick="cancelar()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cancelar</button>
                </div>
            </div>
        </div>
        <script>
            function cancelar() {
                let url = '<?php echo ($URL) . "pedidos/pedido.php"; ?>';
                fetch(url, {
                    method: 'POST',
                    body: new URLSearchParams({
                        deleteCar: true
                    })
                }).then(response => {
                    window.location.href = url
                }).catch(error => {
                    console.error(error);
                });
            }
        </script>
    <?php else : ?>
        <div>
            <div class="text-2xl mt-16 px-4 py-3 rounded text-center ">
                <?php if (count($_SESSION['carrito']) == 0) : ?>
                    <strong class="font-bold">¡Pedido Cancelado!</strong>
                    <span class="block sm:inline mr-8">Tu pedido se ha cancelado exitosamente.</span>
                    <span class="block mt-12">Pero aun puedes descubirir por qué siempre nos prefieres,<br> explora nuestro catálogo</span>

                <?php else : ?>
                    ¡Descubre por qué siempre nos prefieres!<br> Explora nuestro catálogo ahora mismo.
                <?php endif; ?>
            </div><br>
            <div class="flex justify-center"> <!-- Div adicional para centrar solo el botón -->
                <a href="<?php echo $URL; ?>catalogo/" class="mt-8 bg-red-500 px-4 py-3 text-xl text-white rounded">Ir al catálogo</a>
            </div>
        </div>

    <?php endif; ?>
</div>
<?php include("../../templates/footer.php"); ?>