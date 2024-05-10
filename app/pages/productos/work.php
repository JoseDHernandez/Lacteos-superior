<?php
//session
include("../../session.php");
if ($_SESSION['Rol'] !== 2) {
    session_destroy();
    header('Location:../login/');
}
include('../../DATABASE.php');

// Variables para el formulario
$nombre = '';
$precio = '';
$imagen = '';
$cantidad = '';
$oferta = '';
$descuento = '';
$existencias = '';
$descripcion = '';
// Verificar si se está editando un producto
if (isset($_GET['id'])) {
    // Obtener los datos del producto para prellenar el formulario
    $id = $_GET['id'];
    $sql = "SELECT * FROM producto WHERE Id = :id";
    $stmt = $CONEXION->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    //Obtener categorias

    $SQL = $CONEXION->prepare("SELECT c.Id as'Id',
    c.nombre as 'nombre',
    CASE WHEN pc.fk_categoria IS NOT NULL THEN 1 ELSE 0 END AS asociada
    FROM categoria c
    LEFT JOIN producto_categoria pc ON c.Id = pc.fk_categoria AND pc.fk_producto = :id");
    $SQL->bindParam(":id", $id, PDO::PARAM_INT);
    $SQL->execute();
    $Categorias = $SQL->fetchAll(PDO::FETCH_ASSOC);
    if ($producto) {
        $nombre = $producto['nombre'];
        $precio = $producto['precio'];
        $imagen = $producto['imagen'];
        $cantidad = $producto['cantidad_contenido'];
        $oferta = $producto['oferta'];
        $descuento = $producto['descuento'] * 100;
        $existencias = $producto['existencias'];
        $descripcion = $producto['descripcion'];
    } else {
        // Si el producto no existe, redirigir a la página principal de administración
        header('Location: ./');
        exit;
    }
}
// Si se solicito el formulario de registro o edición de producto
if (isset($_GET['new'])) {

    $id = isset($_GET['update']) ? $_GET['update'] : '';
    $nombre = '';
    $descripcion = '';
    // Verificar si es un nuevo producto
    if ($_GET['new'] == "newPro" || $_GET["new"] == "newCat") {
        $SQL = $CONEXION->prepare("SELECT * FROM categoria");
        $SQL->execute();
        $Categorias = $SQL->fetchAll(PDO::FETCH_ASSOC);
        //actualizar categoria
        if ($_GET["new"] == "newCat" && isset($_GET['update'])) {
            $SQL = $CONEXION->prepare("SELECT * FROM categoria WHERE Id=:id");
            $SQL->bindParam(":id", $id, PDO::PARAM_INT);
            $SQL->execute();
            $categoriaUpdate = $SQL->fetch(PDO::FETCH_ASSOC);
            $id = $categoriaUpdate['Id'];
            $nombre = $categoriaUpdate['nombre'];
            $descripcion = $categoriaUpdate['descripcion'];
        }
    } else {
        // Redirigir a la página principal de administración si no se reconoce la acción
        header("Location: ./");

        exit;
    }
}


// Incluir el encabezado
include("../../templates/header.php");
?>

<div class="container mx-auto">


    <!-- Formulario de Registro o Edición de Producto -->
    <?php if (isset($_GET['id']) || (isset($_GET['new']) && $_GET['new'] == "newPro")) : ?>
        <h1 class="text-4xl font-bold my-8">Formulario de
            <?php if ((isset($_GET['new']) && $_GET['new'] == "newPro")) {
                echo "Registro";
            } else {
                echo "Actualización";
            } ?>
            de Producto</h1>
        <form method="post" action="../../assets/work.php" enctype="multipart/form-data" class="mb-8">
            <input type="hidden" name="new" value="<?php if ((isset($_GET['new']) && $_GET['new'] == "newPro")) {
                                                        echo "newPro";
                                                    } else {
                                                        echo "actualizar";
                                                    } ?>">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
            <!-- Input para el nombre del producto -->
            <div class="mb-4">
                <label for="nombre" class="block text-lg font-semibold mb-2">Nombre del Producto:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" class="w-full border border-gray-300 rounded-lg p-2" required>
            </div>
            <!-- Input para el precio -->
            <div class="mb-4">
                <label for="precio" class="block text-lg font-semibold mb-2">Precio:</label>
                <input type="number" id="precio" name="precio" value="<?php echo $precio; ?>" class="w-full border border-gray-300 rounded-lg p-2" required>
            </div>
            <!-- Input para existencias -->
            <div class="mb-4">
                <label for="existencias" class="block text-lg font-semibold mb-2">Existencias:</label>
                <input type="number" id="existencias" name="existencias" value="<?php echo $existencias; ?>" class="w-full border border-gray-300 rounded-lg p-2" required>
            </div>
            <!-- Input para cantidad de contenido -->
            <div class="mb-4">
                <label for="cantidad" class="block text-lg font-semibold mb-2">Cantidad de Contenido:</label>
                <input type="text" id="cantidad" name="cantidad" value="<?php echo $cantidad; ?>" class="w-full border border-gray-300 rounded-lg p-2" required>
            </div>
            <!-- Radio para oferta -->
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">Oferta:</label>
                <label for="of1" class="inline-flex items-center">
                    <input type="radio" id="of1" name="oferta" value="1" class="mr-2" <?php if ($oferta == 0) {
                                                                                            echo "checked";
                                                                                        } ?>>
                    <span>Es una oferta</span>
                </label><br>
                <label for="of2" class="inline-flex items-center">
                    <input type="radio" id="of2" name="oferta" value="0" class="mr-2" <?php if ($oferta == 1 || (isset($_GET['new']) && $_GET['new'] == "newPro")) {
                                                                                            echo "checked";
                                                                                        } ?>>
                    <span>No es una oferta</span>
                </label>
            </div>
            <!-- Input para descuento -->
            <div class="mb-4">
                <label for="descuento" class="block text-lg font-semibold mb-2">Descuento:</label>
                <input type="number" id="descuento" name="descuento" min="0" max="100" step="1" value="<?php echo $descuento; ?>" class="w-full border border-gray-300 rounded-lg p-2">
            </div>
            <!-- Input para descripción -->
            <div class="mb-4">
                <label for="descripcion" class="block text-lg font-semibold mb-2">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="w-full border border-gray-300 rounded-lg p-2" required><?php echo $descripcion; ?></textarea>
            </div>
            <!-- Input para la imagen -->
            <div class="mb-4">
                <input type="hidden" name="urlImagen" id="urlImagen" value="<?php $producto['imagen'] ?>">
                <label for="Imagen" class="block text-lg font-semibold mb-2">Imagen:</label>
                <input type="file" onclick="imagen()" accept=".png, .jpg, .jpeg, .svg" id="Imagen" name="Imagen" class="w-full border border-gray-300 rounded-lg p-2" <?php if (isset($_GET['new'])) {
                                                                                                                                                                            echo "required";
                                                                                                                                                                        } ?>>
            </div>
            <!-- Checkbox para categorías -->
            <div class="mb-4">
                <p class="block text-lg font-semibold mb-2">Categorías:</p>
                <?php foreach ($Categorias as $categoria) { ?>
                    <label for="<?php echo $categoria['nombre']; ?>" class="inline-flex items-center text-xl mb-2">
                        <input class="mr-2" type="checkbox" id="<?php echo $categoria['nombre']; ?>" name="<?php echo $categoria['nombre']; ?>" value="<?php echo $categoria['Id']; ?>" <?php if (isset($categoria['asociada']) && $categoria['asociada'] == 1) {
                                                                                                                                                                                            echo "checked";
                                                                                                                                                                                        } ?>>
                        <span><?php echo $categoria['nombre']; ?></span>
                    </label><br>
                <?php } ?>
            </div>
            <!-- Botón de enviar -->
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">

                    <?php if ((isset($_GET['new']) && $_GET['new'] == "newPro")) {
                        echo "Registrar";
                    } else {
                        echo "Actualizar";
                    } ?>
                </button>
            </div>
        </form>
        <script>
            function imagen() {
                const filesInput = document.getElementById("Imagen");
                filesInput.addEventListener("change", () => {
                    const files = filesInput.files;
                    if (!files || !files.lenght) {
                        return;
                    }
                    const archivo = files[0];
                    const url = URL.createObjectURL(archivo)
                    document.getElementById("urlImagen").value = url;

                })
            }
        </script>
    <?php elseif (isset($_GET['new']) && $_GET['new'] == "newCat") :

    ?>
        <!-- Formulario de Registro de Nueva Categoría -->
        <div class="flex justify-between">
            <div class="w-1/2 pr-8">
                <h1 class="text-4xl font-bold my-8">Formulario de Categoría</h1>
                <form method="post" action="../../assets/work.php" class="mb-8">
                    <?php if (isset($_GET['update'])) : ?>
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                    <?php endif; ?>
                    <input type="hidden" name="type" value="<?php if (isset($_GET['update'])) {
                                                                echo "update";
                                                            } else {
                                                                echo "register";
                                                            } ?>">
                    <!-- Input para el nombre de la categoría -->
                    <div class="mb-4">
                        <label for="nombre" class="block text-lg font-semibold mb-2">Nombre de la Categoría:</label>
                        <input type="text" id="nombre" name="nombre" maxlength="20" class="w-full border border-gray-300 rounded-lg p-2" value="<?php echo $nombre ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="descripcion" class="block text-lg font-semibold mb-2">Descripción de la Categoría:</label>
                        <input type="text" id="descripcion" maxlength="150" name="descripcion" class="w-full border border-gray-300 rounded-lg p-2" value="<?php echo $descripcion ?>" required>
                    </div>
                    <!-- Botón de Enviar -->
                    <div>
                        <button type="submit" name="new" value="newCat" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">

                            <?php if (isset($_GET['update'])) : ?>
                                Actualizar
                            <?php else : ?>
                                Registrar
                            <?php endif; ?>
                        </button>
                        <?php if (isset($_GET['update'])) : ?>
                            <a href="<?php echo $URL . "productos/work.php?new=newCat" ?>" class="ml-8 bg-red-500 text-white px-4 py-2 text-lg rounded hover:bg-red-600">Cancelar</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="w-1/2 pl-8">
                <?php if (count($Categorias) > 0) : ?>
                    <h1 class="text-4xl font-bold my-8">Categorías</h1>
                    <table class="w-full">
                        <tr>
                            <th class="border border-gray-400 px-4 py-2">ID</th>
                            <th class="border border-gray-400 px-4 py-2">Nombre</th>
                            <th class="border border-gray-400 px-4 py-2">Descripción</th>
                            <th class="border border-gray-400 px-4 py-2">Opciones</th>
                        </tr>

                        <?php
                        foreach ($Categorias as $categoria) { ?>
                            <tr>
                                <td class="border border-gray-400 px-4 py-2"><?php echo $categoria['Id']; ?></td>
                                <td class="border border-gray-400 px-4 py-2"><?php echo $categoria['nombre']; ?></td>
                                <td class="border border-gray-400 px-4 py-2"><?php echo $categoria['descripcion']; ?></td>
                                <td class="border border-gray-400 px-4 py-2">
                                    <a href="<?php echo $URL . "productos/work.php?new=newCat&update=" . $categoria['Id']; ?>" class="text-blue-500 hover:text-blue-900">Editar</a>
                                    <form method="POST" action="../../assets/work.php" class="inline-block ml-2">
                                        <input type="hidden" name="id" value="<?php echo $categoria['Id']; ?>">
                                        <input type="hidden" name="type" value="delete">
                                        <button type="submit" value="newCat" name="new" class="text-red-500 hover:text-red-900">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>


    <?php endif; ?>
</div>

<?php include("../../templates/footer.php"); ?>