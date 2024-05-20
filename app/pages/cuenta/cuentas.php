<?php
// Incluir el archivo de sesión
include("../../session.php");

// Verificar la autenticación
if (isset($_SESSION['auth']) == true) {
    // Incluir la cabecera según el estado de la sesión
    if ($_SESSION['auth'] == true && $_SESSION['Rol'] == 2) {
        include("../../templates/header.php");
    } else {
        header("Location: ../../login.php");
        exit();
    }

    // Incluir la conexión a la base de datos
    include("../../DATABASE.php");

    // Obtener todas las cuentas registradas
    $SQL = $CONEXION->prepare("SELECT u.Id AS Id, u.nombre AS nombre, email, movil, CONCAT(i.tipo,'  ',u.identificacion) AS ide, fecha_nacimiento as fe,
     t.nombre AS tipo, empresa 
    FROM usuario u 
    INNER JOIN tipo t ON fk_tipo_persona = t.Id 
    INNER JOIN identificacion i ON fk_identificacion = i.Id 
    INNER JOIN rol r ON fk_rol = r.Id  WHERE fk_rol !=2");
    $SQL->execute();
    $Cuentas = $SQL->fetchAll(PDO::FETCH_ASSOC);
?>
    <!-- HTML para mostrar las cuentas registradas y CRUD -->
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold my-4">Cuentas Registradas</h1>
        <!-- Botón para agregar nueva cuenta -->
        <a href="agregar_cuenta.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-4">Agregar Nueva Cuenta</a>

        <!-- Tabla para mostrar las cuentas -->
        <table class="min-w-full mt-6 divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tel&eacute;fono</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">identificaci&oacute;n</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de nacimiento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo de persona</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($Cuentas as $Cuenta) { ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $Cuenta['Id']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $Cuenta['nombre']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $Cuenta['email']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $Cuenta['movil']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $Cuenta['ide']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $Cuenta['fe']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $Cuenta['tipo']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $Cuenta['empresa']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <!-- Botones de editar y eliminar cuenta -->
                            <a href="editar_cuenta.php?id=<?php echo $Cuenta['Id']; ?>" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                            <form action="eliminar_cuenta.php" method="POST" class="inline">
                                <input type="hidden" name="id" value="<?php echo $Cuenta['Id']; ?>">
                                <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
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