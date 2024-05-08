<?php
//session
include("../../session.php");
//Navbar
if (isset($_SESSION['auth'])) {
    include("../../templates/header.php");
} else {
    include("../../templates/head.php");
} ?>
<div class="container mx-auto  flex justify-center items-center w-full h-screen">
    <div class="container mx-auto max-w-lg mt-8 p-8 shadow-2xl rounded">
        <?php
        if (isset($_GET['Error'])) {
        ?>
            <p class="bg-red-500  p-4 mb-8 rounded font-bold text-center text-white text-lg">
                <?php
                if ($_GET['Error'] == 'login') {
                    echo ('Usuario no encontrado o invalido');
                } elseif ($_GET['Error'] == 'register') {
                    echo ('Error al registrar los datos');
                }
                ?>
            </p>
        <?php } ?>
        <div id="login" class="block">
            <h2 class="text-2xl font-bold mb-4">Iniciar sesión</h2>
            <form action="loginAndRegister.php" method="post" class="max-w-md">
                <input name="type" type="hidden" value="login">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold mb-2">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-red-700" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold mb-2">Contraseña</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-red-700" required>
                </div>
                <button type="submit" class="bg-red-700 text-white py-2 px-4 rounded-md hover:bg-red-600">Iniciar sesión</button>
            </form>

            <div class="mt-8">
                <p class="text-lg">¿No tienes una cuenta? <a href="#registro" class="text-red-700 font-semibold">Regístrate aquí</a></p>
            </div>
        </div>
        <div id="registro" class="hidden">
            <h2 class="text-2xl font-bold mb-4">Registro</h2>
            <form action="loginAndRegister.php" method="post" class="max-w-md">
                <input name="type" type="hidden" value="register">
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-semibold mb-2">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-red-700" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block mb-1">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="movil" class="block mb-1">Móvil</label>
                    <input type="tel" id="movil" name="movil" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="tipo_identificacion" class="block mb-1">Tipo de Identificación</label>
                    <select id="tipo_identificacion" name="tipo_identificacion" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                        <option value="1">Cedula de ciudadania</option>
                        <option value="2">Tarjeta de identidad</option>
                        <option value="3">Cedula de extranjeria</option>
                        <option value="4">Pasaporte</option>
                        <option value="5">Permiso especial de permanencia</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="numero_identificacion" class="block mb-1">Número de Identificación</label>
                    <input type="text" id="numero_identificacion" name="numero_identificacion" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block mb-1">Contraseña</label>
                    <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="direccion" class="block mb-1">Dirección</label>
                    <input type="text" id="direccion" name="direccion" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="fecha_nacimiento" class="block mb-1">Fecha de Nacimiento</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="tipo_persona" class="block mb-1">Tipo de persona</label>
                    <select id="tipo_persona" name="tipo_persona" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>

                        <option value="1">Persona natural</option>
                        <option value="2">Persona juridica</option>
                    </select>
                </div>
                <script>
                    document.getElementById("tipo_persona").addEventListener('change', e => {
                        if (document.getElementById("tipo_persona").value == 2) {
                            let com = `<div class="mb-4" id="componente">
                <label for="empresa" class="block mb-1">Empresa</label>
                <input type="text" id="empresa" name="empresa" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                </div>`;
                            // Agregar el componente después del elemento "tipo_persona"
                            document.getElementById("tipo_persona").insertAdjacentHTML('afterend', com);
                        } else {
                            // Eliminar el componente si no es tipo 2
                            document.getElementById("componente").remove();
                        }
                    });
                </script>


                <button type="submit" class="bg-red-700 text-white py-2 px-4 rounded-md hover:bg-red-600">Registrarse</button>
            </form>
            <div class="mt-8">
                <p class="text-lg">¿Ya tienes una cuenta? <a href="#login" class="text-red-700 font-semibold">Ingresa aquí</a></p>
            </div>
        </div>
    </div>
</div>
<script>
    // Mostrar/ocultar formulario de registro al hacer clic en el enlace
    document.querySelector('a[href="#registro"]').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('registro').classList.toggle('hidden');
        document.getElementById('login').classList.toggle('hidden')
    });
    document.querySelector('a[href="#login"]').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('login').classList.toggle('hidden');
        document.getElementById('registro').classList.toggle('hidden')
    });
</script>

<?php include("../../templates/footer.php"); ?>