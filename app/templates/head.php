<?php
include("rutas.php");
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
if (isset($_SESSION['auth'])) {
    echo "asd";
}
?>

<!doctype html>
<html lang="es">

<head>
    <title>Lacteos superior</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        customRed: '#D12027',
                    },
                },
            },
        }
    </script>
</head>

<body>
    <header>
        <nav class="bg-customRed py-4 lg:py-2">
            <div class="container mx-auto flex justify-between items-center">
                <a href="<?php echo $URL_HOST; ?>/" class="flex items-center text-white text-lg font-bold">
                    <img src="<?php echo $URL_IMG; ?>logo.png" alt="Lacteos superior" class="h-12 mr-2" />
                </a>
                <div class="flex space-x-4">
                    <a href="<?php echo $URL; ?>about.php" class="text-white hover:underline">Acerca de</a>
                    <a href="<?php echo $URL; ?>consultas/" class="text-white hover:underline">Consultas</a>
                    <?php if (!empty($carrito)) : ?>
                        <a href="<?php echo $URL; ?>catalogo/carrito.php" class="text-white hover:underline">Carrito</a>
                    <?php endif; ?>
                    <a href="<?php echo $URL; ?>catalogo/" class="text-white hover:underline">Catálogo</a>
                    <a href="<?php echo $URL; ?>login/" class="text-white hover:underline">Ingreso</a>
                </div>
            </div>
        </nav>
    </header>

    <main>