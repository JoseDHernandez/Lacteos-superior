<?php
//session
include("app/session.php");
//Navbar
if (isset($_SESSION['auth'])) {
    include("app/templates/header.php");
} else {
    include("app/templates/head.php");
} ?>
<div class="bg-red-500">


    <!-- Hero section -->
    <div class="h-screen flex items-center justify-center relative text-white">
        <div class="text-center">
            <!-- Título con el texto y el logo -->
            <div class="flex items-center justify-center mb-4">
                <h1 class="text-5xl font-bold mr-4">¡Bienvenidos a</h1>
                <img src="<?php echo $URL_IMG; ?>/logo2.png" alt="Lácteos Superior" class="w-40 h-auto">
                <h1 class="text-5xl font-bold ml-4">!</h1>
            </div>

            <!-- Texto y botón -->
            <p class="text-2xl mb-14">Siempre nos vas a preferir...</p>
            <a href="<?php echo ($URL . "catalogo/"); ?>" class="bg-white  text-xl text-red-500 font-bold py-2 px-6 rounded hover:bg-red-600 hover:text-white">Ver Productos</a>
        </div>
    </div>


    <!-- Productos section -->
    <div id="productos" class="bg-white py-12 ">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold mb-8 text-center">Nuestros Productos</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Nuestra línea de Yogures -->
                <div class="bg-gray-100 p-8 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4">Yogures</h3>
                    <p class="mb-4">Nuestro producto es 100% yogur entero, con la mejor calidad y un sabor superior.</p>
                    <a href="<?php echo ($URL . "catalogo/?buscar=yogur"); ?>" class="block mt-4 bg-red-500 text-white font-semibold py-2 px-4 rounded-lg text-center">Ver Yogures</a>
                </div>

                <!-- Nuestra línea de Quesos -->
                <div class="bg-gray-100 p-8 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4">Quesos</h3>
                    <p class="mb-4">Quesos de tradición con gran valor nutricional con todas las bondades de la leche.</p>
                    <a href="<?php echo ($URL . "catalogo/?buscar=queso"); ?>" class="block mt-4 bg-red-500 text-white font-semibold py-2 px-4 rounded-lg text-center">Ver Quesos</a>
                </div>

                <!-- Nuestra línea de Kumis -->
                <div class="bg-gray-100 p-8 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4">Kumis</h3>
                    <p class="mb-4">Los más variados productos de lácteos.</p>
                    <a href="<?php echo ($URL . "catalogo/?buscar=kumis"); ?>" class="block mt-4 bg-red-500 text-white font-semibold py-2 px-4 rounded-lg text-center">Ver Kumis</a>
                </div>

                <!-- Nuestra línea de Mantequilla -->
                <div class="bg-gray-100 p-8 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4">Mantequillas</h3>
                    <p class="mb-4">Mantequilla tradicional ideal para su mesa y la industria.</p>
                    <a href="<?php echo ($URL . "catalogo/?buscar=mantequilla"); ?>" class="block mt-4 bg-red-500 text-white font-semibold py-2 px-4 rounded-lg text-center">Ver Mantequillas</a>
                </div>

                <!-- Nuestra línea de Refrigerios Escolares -->
                <div class="bg-gray-100 p-8 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4">Refrigerios Escolares</h3>
                    <p class="mb-4">Los más variados menús, ideales para la lonchera.</p>
                    <a href="#" class="block mt-4 bg-red-500 text-white font-semibold py-2 px-4 rounded-lg text-center">Ver Refrigerios</a>
                </div>

                <!-- Contacto -->
                <div class="bg-red-300 p-8 rounded-lg shadow-lg">
                    <h3 class="text-2xl  text-center font-semibold mb-4">Siempre nos vas a preferir</h3>
                    <p class="text  text-lg mb-4">¡Contáctanos para más información!</p>
                    <a href="<?php echo ($URL . "contacto.php"); ?>" class="block mt-4 bg-red-500  text-white font-semibold py-2 px-4 rounded-lg text-center">Contactar</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Carrusel de Logos de Empresas Distribuidoras -->
    <div class="bg-red-500 py-12 text-white">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold mb-8 text-center text-white">Algunas de Nuestras Distribuidoras</h2>
            <div class="mx-auto w-4/5 bg-white rounded-lg p-4">
                <div class="slider flex items-center justify-center">
                    <img src="<?php echo ($URL_IMG) ?>jumbo.png" alt="Logo 1" class="mr-4">
                    <img src="<?php echo ($URL_IMG) ?>alkosto.jpg" alt="Logo 2" class="mr-4">
                    <img src="<?php echo ($URL_IMG) ?>makro.png" alt="Logo 3" class="mr-4">
                    <img src="<?php echo ($URL_IMG) ?>metro.png" alt="Logo 4" class="mr-4">
                    <img src="<?php echo ($URL_IMG) ?>Olimpica.png" alt="Logo 5" class="mr-4">
                    <img src="<?php echo ($URL_IMG) ?>surtimax.png" alt="Logo 6" class="mr-4">
                    <img src="<?php echo ($URL_IMG) ?>Carulla.png" alt="Logo 7" class="mr-4">
                </div>
            </div>
        </div>
    </div>


    <div class="bg-white py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center">Ubicación de la Tienda</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Mapa de Google Maps -->
                <div class="shadow rounded">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.915709985621!2d-74.10585218864296!3d4.609108895346223!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f99405f7d959d%3A0x81b00348dddacb44!2sCra.%2034a%20%234b-73%2C%20Bogot%C3%A1!5e0!3m2!1ses-419!2sco!4v1714936978580!5m2!1ses-419!2sco" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <!-- Información de la tienda y formulario de contacto -->
                <div class="text-lg">
                    <p class="mb-4"><strong>Visítanos en nuestra tienda física ubicada en:</strong></p>
                    <p class="mb-2"><i class="fas fa-map-marker-alt mr-2 text-red-500"></i>Dirección: Carrera 34<sup>a</sup> No.4B-73 Bogotá, Colombia</p>
                    <p class="mb-2"><i class="fas fa-envelope mr-2 text-red-500"></i>Email: <a href="mailto:lacteossuperior@fasulac.com" class="text-blue-500">lacteossuperior@fasulac.com</a></p>
                    <p class="mb-2"><i class="fas fa-phone-alt mr-2 text-red-500"></i>Teléfono: <a href="tel:+5712374705" class="text-blue-500">+57 123 747 05</a></p>
                    <p><i class="far fa-clock mr-2 text-red-500"></i>Horario de atención: Lunes a Viernes de 8:00 am a 5:00 pm y Sábados de 8:00 am a 1:00 pm</p>

                    <!-- Formulario de contacto -->
                    <div class="bg-red-500 py-12 px-8 mt-8">
                        <h2 class="text-3xl text-center font-bold mb-8 text-white">Contáctenos</h2>
                        <p class="text-lg text-white mb-8">¿Tienes alguna pregunta o necesitas más información sobre nuestros productos? ¡No dudes en contactarnos!</p>
                        <a href="<?php echo $URL . "contacto.php"; ?>" class="bg-white text-red-500 font-bold py-3 px-8 rounded hover:bg-red-600 hover:text-white">Contactar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/min/tiny-slider.js"></script>
<script>
    // Esperar a que se cargue el DOM
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar carrusel
        var slider = tns({
            container: '.slider',
            items: 7,
            autoplay: true,
            autoplayButtonOutput: false,
            autoplayHoverPause: true,
            controls: false,
            responsive: {
                768: {
                    items: 5
                }
            }
        });
    });
</script>

<?php include("app/templates/footer.php"); ?>