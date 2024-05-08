<?php
//session
include("../../session.php");
include("../../DATABASE.php");
//asuntos
$SQL = $CONEXION->prepare("SELECT * FROM asunto");
$SQL->execute();
$Asuntos = $SQL->fetchAll(PDO::FETCH_ASSOC);

//Navbar
if (isset($_SESSION['auth']) && $_SESSION['auth'] == true) {
    include("../../templates/header.php");
} else {
    include("../../templates/head.php");
}

if (isset($_SESSION["auth"]) && $_SESSION["Rol"] == 2) {
    $sql = "SELECT 
    c.Id AS 'Id', 
    a.nombre AS 'asunto',
    mensaje,
    estado,
    titulo,
    CASE
        WHEN c.fk_cliente IS NULL THEN c.nombre
        ELSE u.nombre
    END AS 'cliente',
    CASE
        WHEN c.fk_cliente IS NULL THEN c.empresa
        ELSE u.empresa
    END AS 'empresa',
    CASE
        WHEN c.fk_cliente IS NULL THEN c.telefono
        ELSE u.movil
    END AS 'telefono',
    CASE
        WHEN c.fk_cliente IS NULL THEN c.correo
        ELSE u.email
    END AS 'correo',
    CASE
        WHEN c.fk_cliente IS NULL THEN u.Id
        ELSE c.Id
    END AS 'fk_cliente'
    FROM 
        consulta c 
    INNER JOIN 
        asunto a ON c.fk_asunto = a.Id 
    LEFT JOIN 
        usuario u ON c.fk_cliente = u.Id ";
    if (isset($_GET['id'])) {
        $sql .= "WHERE c.Id = :id";
    }
    $sql .= "  ORDER BY estado";
    $SQL = $CONEXION->prepare($sql);
    if (isset($_GET['id'])) {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $SQL->bindParam(":id", $id, PDO::PARAM_INT);
    }
    $SQL->execute();


    if (isset($_GET['id'])) {
        $Consultas = $SQL->fetch(PDO::FETCH_ASSOC);
        if (count($Consultas) == 0) {
            header('./');
        }
    } else {

        $Consultas = $SQL->fetchAll(PDO::FETCH_ASSOC);
    }
?>
    <div class=" min-h-screen">
        <div class="container mx-auto pt-8">
            <h1 class="text-3xl font-bold  mb-4">
                <?php if (isset($_GET['id'])) {
                    echo "Consulta #" . $Consultas['Id'];
                } else {
                    echo "Consultas";
                } ?>
            </h1>
            <?php if (isset($_GET['id'])) : ?>
                <div class="bg-white p-8 rounded-lg shadow-xl border border-gray-300">
                    <p class="mb-6 text-4xl "><strong>Titulo:</strong> <?php echo $Consultas['titulo']; ?></p>
                    <div class="grid grid-cols-2 gap-x-4 mb-4 text-xl">
                        <p class="mb-6 text-xl "><strong>Asunto:</strong> <?php echo $Consultas['asunto']; ?></p>
                        <p class="mb-6 text-xl "><strong>Estado:</strong>
                            <?php
                            if ($Consultas['estado'] == 0) {
                                echo "Pendiente";
                            } else {
                                echo "Contestada";
                            }
                            ?>
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-x-4 mb-4 text-xl">

                        <p class="mb-4"><strong>ID Cliente:</strong>
                            <?php
                            if (isset($Consultas['fk_cliente'])) {
                                echo $Consultas['fk_cliente'];
                            } else {
                                echo "No registrado";
                            }
                            ?>
                        </p>
                        <p class="mb-4"><strong>Cliente:</strong> <?php echo $Consultas['cliente']; ?></p>


                    </div>
                    <div class="grid grid-cols-3 gap-x-4 mb-4 text-xl">
                        <p class="mb-4"><strong>Empresa:</strong>
                            <?php if (!empty($Consultas['empresa'])) : ?>
                                <?php echo $Consultas['empresa']; ?>
                            <?php else : echo "No registra"; ?>
                            <?php endif; ?>
                        </p>
                        <p class="mb-4"><strong>Teléfono:</strong> <?php echo $Consultas['telefono']; ?></p>
                        <p class="mb-4"><strong>Correo:</strong> <?php echo $Consultas['correo']; ?></p>
                    </div>
                    <hr class="mb-6">
                    <p class="mb-4 text-xl"><strong>Mensaje:</strong> <?php echo $Consultas['mensaje']; ?></p>
                    <hr class="my-8">
                    <div> <a class="text-xl text-white bg-red-600 rounded hover:bg-red-700 px-4 py-2" href="<?php echo $URL . "consultas/" ?>">Volver a las consultas</a></div>
                </div>

                <?php else :
                if (count($Consultas) > 0) :
                ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php
                        // Iterar sobre cada fila de resultados
                        foreach ($Consultas as $Consulta) {
                            // Mostrar los datos de cada consulta en una tarjeta
                        ?>
                            <div class="bg-white p-4 rounded-lg shadow-xl border border-gray-300">
                                <p><strong>Asunto:</strong> <?php echo $Consulta['asunto']; ?></p>
                                <p><strong>Titulo:</strong> <?php echo $Consulta['titulo']; ?></p>
                                <p><strong>Cliente:</strong> <?php echo $Consulta['cliente']; ?></p>
                                <p><strong>Empresa:</strong>
                                    <?php
                                    if (!empty($Consulta['empresa'])) {
                                        echo $Consulta['empresa'];
                                    } else {
                                        echo "No registra";
                                    }
                                    ?>
                                </p>
                                <p><strong>Correo:</strong> <?php echo $Consulta['correo']; ?></p>
                                <p><strong>Estado:</strong>
                                    <?php
                                    if ($Consulta['estado'] == 0) {
                                        echo "Pendiente";
                                    } else {
                                        echo "Contestada";
                                    }
                                    ?>
                                </p>
                                <a class="block mt-4 text-center px-4 py-2 text-lg bg-red-400 text-white rounded hover:bg-red-600" href="<?php echo $URL . "consultas/?id=" . $Consulta['Id'] ?>">Ver completo</a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                <?php else : ?>
                    <p class="text-2xl font-bold mb-4">No hay consultas disponibles en este momento.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

<?php
} else {
?>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-4">Formulario de Contacto</h1>
        <?php if (isset($_GET['Error'])) {
            echo ('<p class="bg-red-500 text-center text-xl text-white p-4 rounded mb-4">Ocurrio un error, diligencie nuevamente el formulario</p>');
        } ?>

        <form action="consulta.php" method="POST" class="w-full max-w-lg">
            <input type="hidden" name="type" value="upload" />
            <?php
            if (!isset($_SESSION['auth'])) {
            ?>
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700 font-bold mb-2">*Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="empresa" class="block text-gray-700 font-bold mb-2">Empresa:</label>
                    <input type="text" id="empresa" name="empresa" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label for="telefono" class="block text-gray-700 font-bold mb-2">*Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="correo" class="block text-gray-700 font-bold mb-2">*Correo:</label>
                    <input type="email" id="correo" name="correo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                </div>

            <?php
            }
            ?>
            <div class="mb-4">
                <label for="titulo" class="block text-gray-700 font-bold mb-2">*Titulo:</label>
                <input type="text" id="titulo" name="titulo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="asunto" class="block text-gray-700 font-bold mb-2">*Asunto:</label>
                <select id="asunto" name="asunto" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                    <?php
                    foreach ($Asuntos as $asunto) {
                    ?>
                        <option value="<?php echo ($asunto['Id']); ?>"><?php echo ($asunto['nombre']); ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="mensaje" class="block text-gray-700 font-bold mb-2">*Mensaje:</label>
                <textarea id="mensaje" name="mensaje" rows="5" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required></textarea>
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Enviar</button>
            </div>
        </form>
    </div>
<?php }
include("../../templates/footer.php"); ?>