<?php
session_start();
function buscarProductoEnCarrito($idProducto, &$carrito)
{
    foreach ($carrito as $indice => $producto) {
        if ($producto[0] == $idProducto) {
            return $indice;
        }
    }
    return -1; // Si no se encuentra el producto, se devuelve -1
}

if ((isset($_POST["producto"]) && isset($_POST['cantidad']))) {
    $idProducto =  $_POST['producto'];
    $cantidad = $_POST['cantidad'];

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    if ($cantidad > 0) {
        $indice = buscarProductoEnCarrito($idProducto, $_SESSION['carrito']);

        if ($indice !== -1) {
            $_SESSION['carrito'][$indice][1] = $cantidad;
        } else {
            // Si el producto no está en el carrito, se agrega
            $_SESSION['carrito'][] = [$idProducto, $cantidad];
        }
    }
}
//Consultar productos
if (isset($_SESSION["carrito"]) && count($_SESSION['carrito']) > 0 && is_array($_SESSION["carrito"])) {
    include("../../DATABASE.php");
    $Ids = implode(",", array_column($_SESSION["carrito"], 0));

    // Realizar la consulta SQL para obtener los detalles de los productos en el carrito
    $SQL = $CONEXION->prepare("SELECT Id, nombre, precio, imagen,descuento FROM producto WHERE Id IN ($Ids)");
    $SQL->execute();
    $productos = $SQL->fetchAll(PDO::FETCH_ASSOC);
}
//Eliminar carrito
if (isset($_POST['deleteCar']) && count($_SESSION['carrito']) > 0) {
    // Verificar si el carrito existe y no está vacío
    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        // Vaciar el carrito
        $_SESSION['carrito'] = [];
    }
}
//Eliminar producto
if (isset($_GET['eliminar'])) {
    $idProductoEliminar = $_GET['eliminar'];

    // Busca el índice del producto en el carrito
    $indiceProducto = array_search($idProductoEliminar, array_column($_SESSION['carrito'], 0));

    // Si se encuentra el producto en el carrito, se elimina
    if ($indiceProducto !== false) {
        unset($_SESSION['carrito'][$indiceProducto]);
        // Reindexa el array después de eliminar el producto
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }

    // Redirecciona de nuevo al carrito
    header('Location: carrito.php');
    exit();
}
//Navbar
if (isset($_SESSION['auth']) == true) {
    include("../../templates/header.php");
} else {
    include("../../templates/head.php");
}
?>
<div class="container mx-auto my-16 h-screen">
    <?php if (isset($productos) && !empty($productos)) : ?>
        <h1 class="text-3xl font-bold mb-8">Carrito de Compras</h1>
        <?php if (!isset($_SESSION['auth'])) : ?>
            <p>Para terminar su pedido debe ingresar o registrarse</p>
        <?php endif; ?>
        <div class="w-auto flex justify-between my-8">
            <span class="text-lg">
                <a href="./" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-4">Ir al catalogo</a>
                <?php if (isset($_SESSION['auth'])) : ?>
                    <a href="../pedidos/pedido.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Terminar pedido</a>
                <?php else : ?>
                    <a href="../login/" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Ingresar / Registrarse</a>
                <?php endif; ?>
            </span>
            <?php if (isset($_SESSION["carrito"]) && count($_SESSION['carrito']) > 0) : ?>
                <a href="#" onclick="limpiarCarrito()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Limpiar todo el carrito</a>

            <?php endif; ?>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $i = 0;
            foreach ($productos as $producto) : ?>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex items-center">
                    <!-- Imagen del producto -->
                    <div class="w-1/4 mr-4">
                        <img src="<?php echo $URL_IMG . "images/" . $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" class="w-full">
                    </div>
                    <!-- Información del producto -->
                    <div class="w-1/2 mr-4">
                        <h2 class="text-lg font-bold mb-2"><?php echo $producto['nombre']; ?></h2>
                        <p class="text-gray-700 mb-2">Precio: $
                            <?php if ($producto['descuento'] > 0.0) {
                                echo ($producto['precio'] - ($producto['precio'] * $producto['descuento']));
                            } else {
                                echo $producto['precio'];
                            } ?>
                        </p>
                    </div>
                    <!-- Cantidad y botones -->
                    <div class="w-1/4">
                        <form action="carrito.php" method="POST" id="agregar-al-carrito">
                            <input type="hidden" name="producto" value="<?php echo $producto['Id']; ?>">
                            <div class="flex items-center mb-2">
                                <button type="button" class="bg-red-500 text-bold text-xl  px-2 py-1 rounded-l focus:outline-none" onclick="decrementarCantidad(<?php echo $producto['Id']; ?>)">-</button>
                                <?php
                                $indice = buscarProductoEnCarrito($producto['Id'], $_SESSION['carrito']);
                                $cantidad = 1;
                                if ($indice !== -1) {
                                    $cantidad = $_SESSION['carrito'][$indice][1];
                                }
                                ?>
                                <input type="number" id="cantidad<?php echo $producto['Id']; ?>" name="cantidad" value="<?php echo ($cantidad) ?>" min="1" max="999" class="w-16 px-3 py-2 border border-gray-300 rounded-none focus:outline-none text-center">
                                <button type="button" class="bg-red-500 text-bold text-xl  px-2 py-1 rounded-r focus:outline-none" onclick="incrementarCantidad(<?php echo $producto['Id']; ?>)">+</button>
                            </div>
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Actualizar</button>
                            <a href="carrito.php?eliminar=<?php echo $producto['Id']; ?>" class="float-right bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">X</a>
                        </form>
                    </div>
                </div>


            <?php
                $i++;
            endforeach; ?>
        </div>
        <script>
            function incrementarCantidad(num) {
                var cantidadInput = document.getElementById("cantidad" + num);
                var cantidad = parseInt(cantidadInput.value);
                if (cantidad < 10) {
                    cantidadInput.value = cantidad + 1;
                }
            }

            function decrementarCantidad(num) {
                var cantidadInput = document.getElementById("cantidad" + num);
                var cantidad = parseInt(cantidadInput.value);
                if (cantidad > 1) {
                    cantidadInput.value = cantidad - 1;
                }
            }

            function limpiarCarrito() {
                // Envía una solicitud POST al mismo script PHP que maneja el carrito
                // con un parámetro para indicar que el carrito debe ser eliminado
                let url = '<?php echo ($URL) . "catalogo/carrito.php"; ?>';
                fetch(url, {
                    method: 'POST',
                    body: new URLSearchParams({
                        deleteCar: true
                    })
                }).then(response => {
                    window.location.href = url
                }).catch(error => {
                    console.error('Error al limpiar el carrito:', error);
                });
            }
        </script>
    <?php else : ?>
        <div class="container mx-auto text-center my-8">
            <img src="<?php echo $URL_IMG ?>/logo2.png" alt="Logo de la empresa" class="mx-auto mb-4">
            <p class="text-2xl my-8 text-gray-600">Tu carrito de compras está vacío.</p>
            <p class="text-lg text-gray-600">¡Te invitamos a explorar nuestro catálogo!</p>
            <a href="./" class="inline-block mt-4 bg-red-500 text-white text-xl py-2 px-4 rounded hover:bg-red-600">Explorar Catálogo</a>
        </div>
    <?php endif; ?>
</div>
<?php include("../../templates/footer.php"); ?>