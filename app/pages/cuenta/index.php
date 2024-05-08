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
<?php
    // Incluir el pie de página
    include("../../templates/footer.php");
} else {
    // Si no hay sesión iniciada, redirigir al usuario a la página de inicio de sesión
    header("Location: ../../login.php");
    exit();
}
?>