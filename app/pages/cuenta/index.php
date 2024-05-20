<?php
// Incluir el archivo de sesión
include("../../session.php");

// Verificar la autenticación
if (isset($_SESSION['auth']) == true) {
    // Incluir la cabecera según el estado de la sesión
    if ($_SESSION['auth'] == true) {
        include("../../templates/header.php");
    } else {
        include("../../templates/head.php");
    }

    // Incluir la conexión a la base de datos
    include("../../DATABASE.php");

    // Preparar y ejecutar la consulta para obtener los datos del usuario actual
    $SQL = $CONEXION->prepare("SELECT u.Id AS Id, u.nombre AS nombre, email, movil, CONCAT(i.tipo,'  ',u.identificacion) AS identificacion, fecha_nacimiento, t.nombre AS tipo_persona, empresa, r.nombre AS rol 
                               FROM usuario u 
                               INNER JOIN tipo t ON fk_tipo_persona = t.Id 
                               INNER JOIN identificacion i ON fk_identificacion = i.Id 
                               INNER JOIN rol r ON fk_rol = r.Id 
                               WHERE u.Id = :id");
    $SQL->bindParam(":id", $_SESSION["Id"], PDO::PARAM_INT);
    $SQL->execute();

    // Obtener los datos del usuario actual
    $Datos = $SQL->fetch(PDO::FETCH_ASSOC);
?>
    <!-- HTML para mostrar los datos de la cuenta -->
    <div class="container mx-auto ">
        <h1 class="text-3xl font-bold my-4">Datos de la Cuenta</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <p class="mb-4"><strong>ID:</strong> <?php echo $Datos['Id']; ?></p>
                <p class="mb-4"><strong>Nombre:</strong> <?php echo $Datos['nombre']; ?></p>
                <p class="mb-4"><strong>Email:</strong> <?php echo $Datos['email']; ?></p>
                <p class="mb-4"><strong>Teléfono:</strong> <?php echo $Datos['movil']; ?></p>
                <p class="mb-4"><strong>Identificación:</strong> <?php echo $Datos['identificacion']; ?></p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <p class="mb-4"><strong>Fecha de Nacimiento:</strong> <?php echo $Datos['fecha_nacimiento']; ?></p>
                <p class="mb-4"><strong>Tipo de Persona:</strong> <?php echo $Datos['tipo_persona']; ?></p>
                <p class="mb-4"><strong>Empresa:</strong> <?php echo $Datos['empresa']; ?></p>
                <p class="mb-4"><strong>Rol:</strong> <?php echo $Datos['rol']; ?></p>
            </div>
        </div>
    </div>

    <!-- Formulario de actualización de datos de la cuenta -->
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-bold mb-4">Actualizar Datos de la Cuenta</h2>
        <form action="#" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $Datos['nombre']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $Datos['email']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="movil" class="block text-gray-700 text-sm font-bold mb-2">Teléfono:</label>
                <input type="tel" id="movil" name="movil" value="<?php echo $Datos['movil']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="fecha_nacimiento" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $Datos['fecha_nacimiento']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="empresa" class="block text-gray-700 text-sm font-bold mb-2">Empresa:</label>
                <input type="text" id="empresa" name="empresa" value="<?php echo $Datos['empresa']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="clave" class="block text-gray-700 text-sm font-bold mb-2">Contraseña:</label>
                <input type="text" id="clave" name="clave" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Actualizar</button>
            </div>
        </form>
    </div>

<?php
    // Incluir el pie de página
    include("../../templates/footer.php");
} else {
    // Si no hay sesión iniciada, redirigir al usuario a la página de inicio de sesión
    header("Location: ../../login.php");
    exit();
}
?>