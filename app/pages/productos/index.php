<?php
//session
include("../../session.php");
if ($_SESSION['Rol'] !== 2) {
    session_destroy();
    header('Location:../login/');
}
include('../../DATABASE.php');
//Obtener productos
//Paginación
$resultados_por_pagina = 30;

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
$sql = "SELECT p.Id as 'Id', p.nombre as 'Nombre', p.precio as 'Precio',p.imagen as 'imagen', GROUP_CONCAT(c.nombre) as 'categorias', 
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
include("../../templates/header.php");
?>
<div class="container mx-auto p-8">
    <h1 class="text-4xl font-bold mb-8">Administración de Productos</h1>

    <?php if (count($Productos) > 0) : ?>
        <div class="flex justify-center items-center ">
            <div class="w-9/12 mb-8">
                <div class="grid grid-cols-8">
                    <input class="col-span-7 px-3 py-2 border border-gray-300 rounded-lg" required type="text" placeholder="Buscar" id="buscar" name="buscar">
                    <button onclick="filtrarCatalogo()" class="bg-red-500 text-white text-xl px-4 py-2 rounded ml-4">Buscar</button>
                </div><br>
                <div>
                    <span class="text-xl mr-4">Filtros: </span>
                    <span class="mr-8">
                        <select id="categorias" name="categoria" class="w-auto text-lg  border p-2 rounded">
                            <option value="0">Categorias</option>
                            <?php
                            foreach ($Categorias as $Categoria) {
                            ?>
                                <option value="<?php $Categoria['Id'] ?>"><?php echo ($Categoria['nombre']) ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </span>
                    <span>
                        <select id="precios" name="precio" class="w-auto text-lg  border p-2 rounded">
                            <option value="0">Orden de precio</option>
                            <option value="1"><?php echo ($Precios[0]['0']) ?></option>
                            <option value="1"><?php echo ($Precios[0]['1']) ?></option>
                        </select>
                    </span>
                    <span class="text-xl mr-4 ml-16">Opciones: </span>
                    <a href="work.php?new=newPro" class="bg-green-500 text-white px-4 py-2 rounded ml-4">Nuevo producto</a>
                    <a href="work.php?new=newCat" class="bg-violet-500 text-white px-4 py-2 rounded ml-4">Categorias</a>
                </div>
            </div>
        </div>
        <table class="w-full border-collapse mb-8">
            <thead>
                <tr>
                    <th class="border border-gray-400 px-4 py-2">ID</th>
                    <th class="border border-gray-400 px-4 py-2">Nombre</th>
                    <th class="border border-gray-400 px-4 py-2">Precio</th>
                    <th class="border border-gray-400 px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Productos as $Producto) : ?>
                    <tr>
                        <td class="border border-gray-400 px-4 py-2"><?php echo $Producto['Id']; ?></td>
                        <td class="border border-gray-400 px-4 py-2"><?php echo $Producto['Nombre']; ?></td>
                        <td class="border border-gray-400 px-4 py-2"><?php echo "$" . number_format($Producto['Precio']); ?></td>
                        <td class="border border-gray-400 px-4 py-2 ">
                            <div class="flex justify-between">

                                <form method="post" action="../../assets/work.php" class="inline-block">
                                    <input type="hidden" name="new" value="delete">
                                    <input type="hidden" name="imagen" value="<?php echo $Producto['imagen']; ?>">
                                    <input type="hidden" name="id" value="<?php echo $Producto['Id']; ?>">
                                    <button type="submit" class="bg-red-500 text-white px-4 py-3 rounded">Eliminar</button>
                                </form>
                                <a href="work.php?id=<?php echo $Producto['Id']; ?>" class="bg-blue-500 text-lg text-white px-4 py-2 rounded mr-2 ">Editar</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

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
        <script>
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
    <?php else : ?>
        <p class="text-4xl text-center mb-16 font-semibold text-gray-800">No se encontraron productos</p>
        <div class="col-span-4 flex justify-center items-center">
            <a class="block py-2 px-4 bg-red-500 text-xl text-white rounded" href="work.php?new=newCat">Registrar categor&iacute;a</a>
            <a class=" ml-8 block py-2 px-4 bg-red-500 text-xl text-white rounded" href="work.php?new=newPro">Registrar producto</a>
        </div>
    <?php endif; ?>
</div>
<?php include("../../templates/footer.php"); ?>