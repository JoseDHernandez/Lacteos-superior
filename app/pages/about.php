<?php
//session
include("../session.php");
//Navbar
if (isset($_SESSION['auth'])) {
    include("../templates/header.php");
} else {
    include("../templates/head.php");
} ?>
<!-- Acerca de section -->
<div id="acerca" class=" py-12 ">
    <div class="container p-8 mx-auto bg-red-500 py-12 rounded-lg text">
        <h2 class="text-5xl text-white font-bold mb-8 text-center">Quiénes Somos</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="col-span-2 text-justify bg-white px-4 pb-4 rounded">
                <h1 class="text-3xl text-red-500 text-center py-2 rounded  font-semibold mb-4">Historia</h1>
                <span class="text-xl ">
                    <p>Inversiones Fasulac es una empresa familiar, fundada en 1975 por la Señora ANA HILDA ORTEGÓN, una mujer emprendedora, que como muchas mujeres colombianas necesitaba sacar adelante a su familia. La empresa la inició de forma artesanal elaborando mantequilla para panaderías y tiendas de barrio. Con el empeño y el trabajo de la familia se fueron creando nuevas referencias de derivados lácteos, los cuales se comercializaron con Bienestar Familiar y almacenes de cadena.</p><br>
                    <p>En 1988 fue constituida como una sociedad limitada, cambiando el nombre de lácteos la superior a INVERSIONES FASULAC LTDA marca "LACTEOS SUPERIOR". Después del fallecimiento de la Señora Hilda, la dirección de la empresa quedo a cargo de sus hijos.</p><br>
                    <p>En el año 2000 con la dirección de la Nueva Gerencia además de una gran inversión en tecnología, maquinarias y una nueva planta, la fábrica Superior de lácteos fue trasladada a la Cra 34ª 4b-73 donde funciona hoy en día.</p><br>
                    <p>Inversiones Fasulac cuenta con una moderna infraestructura de producción, una flota de transporte refrigerado propia, con un excelente equipo de trabajo, que ha garantizado la calidad y el cumplimiento a los requerimientos de los clientes.</p><br>
                    <p>Con todos los años de experiencia en el mercado Inversiones Fasulac ha desarrollado varias gamas de productos derivados lácteos y de lonchera que tienen gran acogida entre sus clientes, especialmente en los niños, a los cuales están enfocados gran parte del portafolio ofreciendo todas las bondades nutricionales del Yogurt natural verdadero, Superior a cualquier bebida láctea del mercado.</p><br>
                    <p>Inversiones Fasulac con su marca de quesos "LA FLOR DEL CAQUETA Y SUPERIOR" se ha apoderado de la confianza y el reconocimiento de muchos consumidores por rico sabor y calidad. Siendo esta línea muy representativa en el mercado.</p>
                </span>
                </p>
            </div>

            <div class="bg-white px-4 pb-4 rounded">
                <h3 class="text-2xl text-red-500 text-center py-2 rounded  font-semibold mb-4">Misión</h3>
                <p class="text-justify text-lg">Nuestra misión es elaborar y comercializar nuestros productos con las mejores materias primas, la mejor tecnología, unos excelentes estándares de calidad y el mejor talento humano, con la conciencia de un mejoramiento continuo, para obtener altos niveles de eficiencia de los recursos y márgenes de rentabilidad que le permitan a la empresa su crecimiento y desarrollo, que sirvan para mejorar la calidad de vida de sus trabajadores y de la comunidad donde nos desarrollamos.</p>
            </div>

            <div class="bg-white px-4 pb-4 rounded">
                <h3 class="text-2xl text-red-500 text-center py-2 rounded  font-semibold mb-4">Visión</h3>
                <p class="text-justify text-lg">Nuestra visión es lograr la excelencia en la producción, logrando obtener certificaciones de calidad. Ampliar la comercialización de nuestros productos al sector de tiendas de barrio, y pequeños supermercados, ofreciendo el respaldo de nuestra marca como valor agregado a nuestros nuevos clientes. Esto en procura de continuar mejorando la calidad de vida de nuestros trabajadores.</p>
            </div>

            <div class="bg-white px-4 pb-4 rounded">
                <h3 class="text-2xl text-red-500 text-center py-2 rounded  font-semibold mb-4">Valores</h3>
                <span class="list-disc pl-5 text-justify text-lg">
                    <p><b class="bg-red-400 p-1 rounded text-white">RESPETO</b><br> Hacia nuestros consumidores, nuestros clientes, nuestros trabajadores, pues son las personas las que nos dan la oportunidad de mantenernos y crecer como empresa.</p><br>
                    <p><b class="bg-red-400 p-1 rounded text-white">RESPONSABILIDAD</b><br> Con nuestros clientes, con nuestros niños, con nuestros proveedores, con nuestros asociados.</p><br>
                    <p><b class="bg-red-400 p-1 rounded text-white">EQUIDAD</b><br> Con nuestros trabajadores, con nuestros clientes, con nuestros socios estratégicos.</p><br>
                    <p><b class="bg-red-400 p-1 rounded text-white">SOSTENIBILIDAD</b><br> Cuidando nuestras decisiones de hoy que afectarán el futuro de las generaciones, en lo económico y el medio ambiente.</p><br>
                    <p><b class="bg-red-400 p-1 rounded text-white">HONESTIDAD</b><br> Siendo 100% transparentes en nuestras negociaciones, nuestros procesos, siendo una empresa confiable en todos los aspectos.</p><br>
                    <p><b class="bg-red-400 p-1 rounded text-white">SOLIDARIDAD</b><br> Trabajamos basados en la tolerancia, la libertad, la democracia, la igualdad buscando una empresa mejor donde todos tengamos las mismas oportunidades.</p><br>
                </span>
            </div>

            <div class="bg-white px-4 pb-4 rounded">
                <h3 class="text-2xl text-red-500 text-center py-2 rounded  font-semibold mb-4">Política de Calidad</h3>
                <p class="text-justify text-lg">Inversiones Fasulac Ltda. “LACTEOS SUPERIOR” tiene como política de calidad: En lácteos superior nos comprometemos a mantener la inocuidad de nuestros productos, a través de un sistema integrado de calidad con cada uno de los departamentos de nuestra empresa, manejando herramientas como la mejora continua y excelentes recursos, desde el personal altamente calificado y pasando por el total de los recursos destinados para la producción y la satisfacción del consumidor, logrando así alcanzar las metas y retos propuestos en el desarrollo de la organización. Esto también se logra a través de la producción con mano de obra calificada, buscado promover a nivel nacional la cultura de consumo saludable y frecuente de estos productos, preservando el valor agregado que le otorga su naturaleza, adicional al cumplimiento de la normatividad vigente.</p>
            </div>
        </div>
    </div>
</div>
<?php include("../templates/footer.php");
