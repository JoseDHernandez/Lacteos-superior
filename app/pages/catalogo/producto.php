<?php
include("../../session.php");

if (isset($_SESSION['auth']) == true) {
    include("../../templates/header.php");
} else {
    include("../../templates/head.php");
}
if (isset($_GET['producto'])) {
    include("../../DATABASE.php");
    // Consulta SQL para obtener los productos paginados
    $SQL = $CONEXION->prepare("SELECT p.Id as 'Id', p.descripcion as 'descripcion',p.cantidad_contenido as 'cantidad',p.existencias as 'existencias', p.nombre as 'Nombre', p.precio as 'Precio', p.imagen as 'Img', GROUP_CONCAT(c.nombre) as 'categorias', 
    p.cantidad_contenido as 'cantidad',p.oferta as'oferta',p.descuento as 'desc' FROM producto_categoria INNER JOIN producto p ON fk_producto=p.Id 
    INNER JOIN categoria c ON fk_categoria=c.Id WHERE  p.Id = :id GROUP BY p.Id, p.nombre, p.precio, p.imagen ");

    $SQL->bindParam(':id', $_GET['producto'], PDO::PARAM_INT);
    $SQL->execute();
    $producto = $SQL->fetch(PDO::FETCH_ASSOC);
    //Calificacion promedio
    $SQL = $CONEXION->prepare("SELECT AVG(calificacion) as 'calificacionGeneral',count(Id) as 'can' FROM comentario WHERE fk_producto = :id ");
    $SQL->bindParam(':id', $_GET['producto'], PDO::PARAM_INT);
    $SQL->execute();
    $Calificacion = $SQL->fetch(PDO::FETCH_ASSOC);
    //Comentarios
    $limit = isset($_GET['limit']) && $_GET['limit'] == "false" ? "" : "LIMIT 0, 20";
    $SQL = $CONEXION->prepare("SELECT u.nombre as 'nombre' ,mensaje, calificacion,tiempo FROM comentario INNER JOIN usuario u ON fk_cliente = u.Id WHERE fk_producto = :id ORDER BY tiempo DESC, calificacion DESC " . $limit);
    $SQL->bindParam(':id', $_GET['producto'], PDO::PARAM_INT);
    $SQL->execute();
    $Comentarios = $SQL->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="container mx-auto my-16">
        <!-- Mostrar información del producto -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Imagen del producto -->
            <div>
                <img src="<?php echo $URL_IMG . "images/" . $producto['Img']; ?>" alt="<?php echo $producto['Nombre']; ?>" class="w-[40em] mt-4 ml-4 rounded-xl">
            </div>
            <!-- Detalles del producto -->
            <div>
                <h1 class="text-6xl font-bold mb-4"><?php echo ($producto['Nombre']); ?></h1>
                <p class="text-2xl mt-8"><b>Calificación: </b><?php if ($Calificacion['can'] > 0) {
                                                                    echo number_format($Calificacion['calificacionGeneral'], 1);
                                                                } else {
                                                                    echo ("No hay calificación ");
                                                                } ?></p>
                <p class="px-4 m-8">
                    <?php
                    if ($producto['desc'] > 0.0) {
                    ?>
                        <span class="text-gray-900 line-through text-lg font-semibold ">
                            <?php echo ("$" . number_format($producto['Precio'])); ?>
                        </span>
                        <span class="text-gray-900  text-4xl font-semibold ml-2 mr-4">
                            <?php echo ("$" . number_format($producto['Precio'] - ($producto['Precio'] * $producto['desc']))); ?>
                        </span>
                        <span class="text-red-900  text-4xl font-semibold ">
                            <?php echo ("   " . ($producto['desc'] * 100) . "%"); ?>
                        </span>
                    <?php } else { ?>
                        <span class="text-gray-900  text-4xl font-semibold ml-2 mr-4">
                            <?php echo ("$" . number_format($producto['Precio'])); ?>
                        </span>
                    <?php }
                    ?>
                </p>
                <p class="text-xl mb-6 ">Cantidad de contenido: <?php echo $producto['cantidad']; ?></p>
                <p class="text-xl mb-6 ">Existencias: <?php echo $producto['existencias']; ?></p>
                <p class="text-xl mb-6 ">Categorias: <?php echo $producto['categorias']; ?></p>
                <hr class="mb-6">
                <p class="text-xl my-10 "><?php echo $producto['descripcion']; ?></p>
                <hr class="mb-6">
                <!-- Agregar al carrito -->
                <form action="carrito.php" method="POST" id="agregar-al-carrito">
                    <input type="hidden" name="producto" value="<?php echo $producto['Id']; ?>">
                    <div class="flex items-center mb-4">
                        <label for="cantidad" class="mr-2 text-3xl">Cantidad: &nbsp;</label>
                        <div class="flex">
                            <button type="button" class="bg-red-500 text-bold text-xl  px-3 py-1 rounded-l focus:outline-none" onclick="decrementarCantidad()">-</button>
                            <input type="number" id="cantidad" name="cantidad" value="1" min="1" max="999" class="w-16 px-3 py-2 border border-gray-300 rounded-none focus:outline-none text-center">
                            <button type="button" class="bg-red-500 text-bold text-xl  px-3 py-1 rounded-r focus:outline-none" onclick="incrementarCantidad()">+</button>
                        </div>
                    </div>
                    <button type="submit" class="my-8 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Agregar al carrito</button>

                </form>
            </div>
        </div>
        <!-- Mostrar y escribir comentario -->
        <div class="mt-8">
            <?php if (isset($_SESSION['auth'])) : ?>
                <h2 class="text-2xl font-semibold mb-4">Agregar Comentario</h2>
                <form method="post" action="addComent.php" class="mb-8 grid grid-cols-4 gap-4">
                    <input type="hidden" name="id" value="<?php echo $producto['Id']; ?>">
                    <div class="col-span-3">
                        <label for="comentario" class="block text-lg font-semibold mb-2">Comentario:</label>
                        <textarea id="comentario" name="mensaje" class="w-full h-24 border border-gray-300 rounded-lg p-4 mb-4" placeholder="Escribe tu comentario aquí" required></textarea>
                    </div>
                    <div>
                        <label for="calificacion" class="block text-lg font-semibold mb-2">Calificación (0.0 - 5.0):</label>
                        <input type="number" id="calificacion" name="calificacion" class="w-32 border border-gray-300 rounded-lg p-2 mr-4" placeholder="(0.0 - 5.0)" step="0.1" min="0" max="5" required><br>
                        <button type="submit" class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Enviar Comentario</button>
                    </div>

                </form>
            <?php else : ?>
                <p class="mb-8 text-xl">Ingresa o regístrate para escribir un comentario. <a class="bg-red-500 text-white rounded py-2 px-4 ml-8" href="<?php echo $URL_LOGIN ?>" class="text-red-500 hover:underline">Ingresar</a></p>

            <?php endif; ?>

            <?php if (!empty($Comentarios)) : ?>
                <h2 class="text-2xl font-semibold my-4">Comentarios</h2>
                <?php foreach ($Comentarios as $comentario) : ?>
                    <div class="border border-gray-300 p-4 my-4 rounded-lg">
                        <p class="text-lg mb-2">
                            <strong><?php echo $comentario['nombre'] ?></strong>
                            <span class="ml-4 text-gray-600"><?php echo $comentario['tiempo'] ?></span>
                        </p>
                        <p class="text-gray-600"><b>Calificación: </b><?php echo $comentario['calificacion'] ?></p>
                        <p class="text-gray-700 mx-4 my-2"><?php echo $comentario['mensaje'] ?></p>
                    </div>
                <?php endforeach; ?>
                <?php if (count($Comentarios) == 20 && !isset($_GET['limit'])) : ?>
                    <form method="GET" action="#" class="mb-8">
                        <input type="hidden" value="false" name="limit">
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cargar más comentarios</button>
                    </form>
                <?php endif; ?>
            <?php else : ?>
                <p>No hay comentarios disponibles.</p>
            <?php endif; ?>
        </div>

    </div>

    <script>
        function incrementarCantidad() {
            var cantidadInput = document.getElementById("cantidad");
            var cantidad = parseInt(cantidadInput.value);
            if (cantidad < 10) {
                cantidadInput.value = cantidad + 1;
            }
        }

        function decrementarCantidad() {
            var cantidadInput = document.getElementById("cantidad");
            var cantidad = parseInt(cantidadInput.value);
            if (cantidad > 1) {
                cantidadInput.value = cantidad - 1;
            }
        }
    </script>
<?php
} else {
    header('Location:./');
}
?>



<?php include("../../templates/footer.php"); ?>