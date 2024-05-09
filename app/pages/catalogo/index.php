<?php
//session
include("../../session.php");
include("../../DATABASE.php");
//Paginación
$resultados_por_pagina = 8;

// Obtener el número total de filas en la tabla 'producto'
$total_resultados = $CONEXION->prepare("SELECT COUNT(*) FROM producto");
$total_resultados->execute();
$total_resultados = $total_resultados->fetchColumn(); // Obtener el número total de filas directamente

// Calcular el número total de páginas
$total_paginas = ceil($total_resultados / $resultados_por_pagina);

// Obtener el número de página actual
$pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Calcular el índice de inicio para la consulta SQL
$indice_inicio = ($pagina_actual - 1) * $resultados_por_pagina;

// Articulo de búsqueda
$Buscar = isset($_GET['buscar']) ? $_GET['buscar'] : "";

// Inicializar las variables de los filtros
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : "";
$precio = isset($_GET['precio']) ? $_GET['precio'] : 0;
// Consulta SQL para obtener los productos paginados
$sql = "SELECT p.Id as 'Id', p.nombre as 'Nombre', p.precio as 'Precio', p.imagen as 'Img', GROUP_CONCAT(c.nombre) as 'categorias', 
p.cantidad_contenido as 'cantidad',p.oferta as'oferta',p.descuento as 'desc' FROM producto_categoria INNER JOIN producto p ON fk_producto=p.Id 
INNER JOIN categoria c ON fk_categoria=c.Id";
// Condición WHERE
$where = array();
// Aplicar filtro de categoría
if (!empty($categoria)) {
    $where[] = "c.nombre = :categoria";
}
// Aplicar filtro de búsqueda
if (!empty($Buscar)) {
    $where[] = "p.nombre LIKE CONCAT('%', :buscar, '%')";
}
// Agregar condiciones al SQL
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " GROUP BY p.Id, p.nombre, p.precio, p.imagen";
// Aplicar filtro de precio
if ($precio == 1) {
    $sql .= " ORDER BY p.precio DESC";
} elseif ($precio == 2) {
    $sql .= " ORDER BY p.precio ASC";
}
$sql .= " LIMIT :inicio, :fin";
$SQL = $CONEXION->prepare($sql);
// Asignar parámetros de la consulta
if (!empty($categoria)) {
    $SQL->bindParam(':categoria', $categoria, PDO::PARAM_STR);
}
if (!empty($Buscar)) {
    $SQL->bindParam(':buscar', $Buscar, PDO::PARAM_STR);
}
$SQL->bindParam(':inicio', $indice_inicio, PDO::PARAM_INT);
$SQL->bindParam(':fin', $resultados_por_pagina, PDO::PARAM_INT);
$SQL->execute();


$Productos = $SQL->fetchAll(PDO::FETCH_ASSOC);

//Categorias
$SQL = $CONEXION->prepare("SELECT Id,nombre,descripcion FROM categoria");
$SQL->execute();
$Categorias = $SQL->fetchAll(PDO::FETCH_ASSOC);
//Precios
$SQL = $CONEXION->prepare("SELECT CONCAT(MAX(precio) ,' - ', MIN(Precio))as'0',CONCAT(MIN(precio) ,' - ', MAX(Precio)) as'1' FROM producto");
$SQL->execute();
$Precios = $SQL->fetchAll(PDO::FETCH_ASSOC);
//Navbar
if (isset($_SESSION['auth']) == true) {
    include("../../templates/header.php");
} else {
    include("../../templates/head.php");
}

//Url imagen
$URL_IMG = $URL_HOST . "/app/assets/images/";
?>
<h1 class="text-4xl text-center  font-bold m-8">Catálogo</h1>
<?php
if (count($Productos) > 0) {

?>
    <div class="flex justify-center items-center">
        <div class="w-9/12">
            <div class="grid grid-cols-8">
                <input class="col-span-7 px-3 py-2 border border-gray-300 rounded-lg" required type="text" placeholder="buscar" id="buscar" name="buscar">
                <button onclick="filtrarCatalogo()" class="bg-red-500 text-white text-xl px-4 py-2 rounded ml-4">Buscar</button>
            </div><br>
            <div>
                <span class="mr-8">
                    <label for="categorias" class="text-lg mr-4">Categorías</label>
                    <select id="categorias" name="categoria" class="w-80 text-lg border p-2 rounded">
                        <option value="0">Seleccione</option>
                        <?php foreach ($Categorias as $Categoria) { ?>
                            <option value="<?php $Categoria['Id'] ?>"><?php echo ($Categoria['nombre']) ?></option>
                        <?php } ?>
                    </select>
                </span>
                <span>
                    <label for="precios" class="text-lg mr-4">Por precio</label>
                    <select id="precios" name="precio" class="w-80 text-lg border p-2 rounded">
                        <option value="0">Seleccione</option>
                        <option value="1"><?php echo ($Precios[0]['0']) ?></option>
                        <option value="1"><?php echo ($Precios[0]['1']) ?></option>
                    </select>
                </span>
            </div>
        </div>
    </div>
    <div class="p-16 grid grid-cols-4 gap-x-4 gap-y-12 h-full ">
        <?php foreach ($Productos as $Producto) { ?>
            <div class="max-w-96 h-[35em]  rounded-lg shadow-lg overflow-hidden <?php echo ($Producto['oferta'] == 1) ? "bg-orange-400" : "bg-white"; ?>">
                <div class="bg-white flex justify-center w-full h-[22em] overflow-hidden">
                    <img class="object-cover object-center rounded-lg" src="<?php echo ($URL_IMG . $Producto['Img']); ?>" alt="Imagen del producto">
                </div>
                <div class="p-4">
                    <h2 class="text-xl font-semibold text-gray-800 text-center"><?php echo ($Producto['Nombre'] . " - " . $Producto['cantidad']) ?></h2>
                    <p class="px-4 text-center mt-2 mb-8">
                        <?php if ($Producto['desc'] > 0.0) { ?>
                            <span class="text-gray-900 line-through text-ms font-semibold ">
                                <?php echo ("$" . number_format($Producto['Precio'])); ?>
                            </span>
                            <span class="text-gray-900  text-2xl font-semibold ml-2 mr-4">
                                <?php echo ("$" . number_format($Producto['Precio'] - ($Producto['Precio'] * $Producto['desc']))); ?>
                            </span>
                            <span class="text-red-900  text-2xl font-semibold ">
                                <?php echo ("   " . ($Producto['desc'] * 100) . "%"); ?>
                            </span>
                        <?php } else { ?>
                            <span class="text-gray-900  text-2xl font-semibold ml-2 mr-4">
                                <?php echo ("$" . number_format($Producto['Precio'])); ?>
                            </span>
                        <?php } ?>
                    </p>
                    <div class="mt-4 flex justify-center">
                        <button onclick="agregarCarrito(<?php echo ($Producto['Id']) ?>)" class="bg-blue-400  px-4 py-2 rounded-md hover:bg-blue-500 ml-4">Agregar al carrito</button>
                        <a class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 ml-4" href="producto.php?producto=<?php echo ($Producto['Id']) ?>">Ver producto</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <script>
        function agregarCarrito(id) {
            // Envía una solicitud POST al mismo script PHP que maneja el carrito
            // con un parámetro para indicar que el carrito debe ser eliminado
            let url = '<?php echo ($URL) . "catalogo/carrito.php"; ?>';
            fetch(url, {
                method: 'POST',
                body: new URLSearchParams({
                    producto: id,
                    cantidad: 1
                })
            }).then(response => {
                // Manejar la respuesta si es necesario
                window.location.href = url
            }).catch(error => {
                console.error(error);
            });
        }

        function filtrarCatalogo() {
            let categoria = document.getElementById("categorias").value;
            let precio = document.getElementById("precios").value;
            let buscar = document.getElementById("buscar").value.trim();
            // Construye la URL con los parámetros de filtro
            let url = '<?php echo ($URL) . "catalogo/"; ?>';
            url += '?buscar=' + buscar + '&categoria=' + categoria + '&precio=' + precio;

            window.location.href = url;
        }
    </script>


    </div>
    <div class="flex justify-center space-x-2">
        <!-- Botón anterior -->
        <a href="?pagina=<?php echo max(1, $pagina_actual - 1); ?>" class="py-2 px-4 bg-orange-500 text-white rounded hover:bg-orange-400">Anterior</a>

        <!-- Números de página -->
        <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
            <a href="?pagina=<?php echo $i; ?>" class="py-2 px-4 <?php echo ($i == $pagina_actual) ? 'border border-orange-500 ' : 'bg-white text-blue-500 border border-blue-500'; ?> rounded hover:bg-orange-500 hover:text-white"><?php echo $i; ?></a>
        <?php endfor; ?>

        <!-- Botón siguiente -->
        <a href="?pagina=<?php echo min($total_paginas, $pagina_actual + 1); ?>" class="py-2 px-4 bg-orange-500 text-white rounded hover:bg-orange-400">Siguiente</a>
    </div>
<?php
} else {
?>
    <p class="text-4xl text-center mb-16 font-semibold text-gray-800">No se encontraron productos</p>
    <div class="col-span-4 flex justify-center items-center">
        <a class="block py-2 px-4 bg-red-500 text-xl text-white rounded" href="<?php echo $URL . "catalogo/" ?>">Ir al cat&aacute;logo</a>
    </div>
    <p class="text-sm mt-32 text-center"><i>*En caso de no buscar un articulo y no se carguen los productos el cat&aacute;logo es un error.</i></p>
<?php
}

?>
<?php include("../../templates/footer.php"); ?>