</main>
</body>
<?php $URL_IMG = $URL_HOST . "/app/assets/"; ?>
<footer class="bg-customRed py-8 mt-16">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">
        <!-- Logo en una columna -->
        <div class="text-white text-center md:text-left mb-4 md:mb-0 md:w-1/2">
            <!-- Logo -->
            <img src="<?php echo ($URL_IMG); ?>logo2.png" alt="Lácteos Superior" class="w-40 mb-4 mx-auto md:mx-0">

            <!-- Información de contacto -->
            <p class="font-bold">Contáctanos</p>
            <p>Lacteos Superior</p>
            <p>Dirección: Carrera 34<sup>a</sup> No.4B-73</p>
            <p>PBX: 2471611 FAX. 2374705</p>
            <p>Email: lacteossuperior@fasulac.com</p>
        </div>

        <!-- Redes sociales en la otra columna -->
        <div class="flex justify-center md:justify-end md:w-1/2">
            <a href="https://www.facebook.com/lacteossuperior.col/" class="hover:text-gray-400 px-3">
                <img src="<?php echo ($URL_IMG); ?>facebook-f.svg" alt="Facebook" class="h-6">
            </a>
            <a href="https://www.instagram.com/lacteossuperior.col/" class="hover:text-gray-400 px-3">
                <img src="<?php echo ($URL_IMG); ?>instagram.svg" alt="Instagram" class="h-6">
            </a>
        </div>
    </div>
</footer>



</html>