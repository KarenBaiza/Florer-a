<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'floreria');

// Verificar conexión
if ($conn->connect_error) 
{
    die("Error de conexión: " . $conn->connect_error);
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Florería KB</title>   <!--Es el nombre que aparece al abrir el navegador-->

    <!--Código del tipo de letra que usare en el título-->
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+CU:wght@100..400&display=swap" rel="stylesheet">

    <!--Enlaza las paginas a está-->
    <link rel = "stylesheet" href = "css/normalize.css">
    <link rel = "stylesheet" href = "css/estilo.css">

    <style>

        .sobreMi
        {
            display: grid;
            grid-template-columns: repeat( 2, 1fr );
            margin: 4rem;                                 /*coloca el margen abajo de grid(de la cuádricula)*/
        }

        @media (min-width: 768px)
        {
            .sobreMi
            {
                grid-template-columns: repeat( 2, 1fr);
                gap: 2rem;

            }
        }

        .sobreMi-contenido
        {
            font-size:19px;            /*tamaño del texto*/
            text-align: left;          /*alinea el texto a la izquierda*/
        }

        .sobreMi-imagen
        {
            width: 100%;               /*la imagen se ajusta a la cuádricula*/
        }

        /*Se ajusta a cualquier dispositivo*/
        @media (min-width: 768px) 
        {
            .sobreMi-imagen 
            {
                grid-template-columns: repeat( 2, 1fr);
                column-gap: 2rem;
            }  
        }


        .comprar-titulo
        {
            color: burlywood;
        }

        /*bloques - son los iconos de la parte de abajo de la página Sobre mi*/
        .bloques
        {
            display: grid;
            grid-template-columns: repeat( 2, 1fr);
            gap: 2rem;
        }

        @media (min-width: 768px)
        {
            .bloques
            {
                grid-template-columns: repeat( 3, 1fr);
            }    
        }

        .bloque
        {
            text-align: center;
        }

        .bloque-titulo
        {
            text-align: left;    /*alinea el texto a la izquierda*/
            font-size: 18px;     /*tamaño de la letra*/
            margin: 2rem ;       /*margen del título a lo que se encuentra abajo del el*/
        }

        .bloque-imagen
        {
            height: 100px;    /*tamaño de la imagen de alto*/
            width:  100px;    /*tamaño de la imagen de lo ancho*/
        }
            </style>


<!---------------------------------------------------------------------------------------------->

</head>
<body>


    <header class = "header"> <!--Inicio del header (Encabezado)-->

        <h1>Floreria KB</h1>

            <a href = "index.html">
                <img class ="header-logo" src = "Imagenes/logo1.png" alt = "logo">
            </a>

    </header> <!--Fin del header (Encabezado)-->

    <!-- Opciones de la barra de menú -->
    <nav class="barraMenu">
        <a class="barraMenu-enlace barraMenu-enlace-activo" href="index.php">Inicio</a>
        <a class="barraMenu-enlace" href="sobre_mi.php">Sobre mí</a>
        <a class="barraMenu-enlace" href="Sesion_admin.php">Iniciar sesión</a>
    </nav>
    

 
    <main class = "contenedor">   <!--Inicio del main-->

        <h2>Sobre mi</h2>

        <div class = "sobreMi">
            <div class = "sobreMi-contenido">
                <p>
                    Nuestra misión es ser la florería más querida y reconocida,
                    donde cada arreglo floral no solo embellezca el entorno,
                    sino que también lleve un mensaje de amor, alegría y esperanza,
                    creando recuerdos inolvidables y momentos especiales para
                    nuestros clientes. Nos esforzamos por conectar corazones a 
                    través del lenguaje único de las flores, promoviendo la armonía
                    con la naturaleza y el arte floral. 
                </p>
            </div>

            <img class = "sobreMi-imagen" src = "Imagenes/op36.jpeg" alt = "Sobre mi">

        </div>

        <section class = "contenedor comprar">
            <h2 class = "comprar-titulo">¿Porqué comprar con nosotros?</h2>

            <div class = "bloques">
                <div class = "bloque">

                    <img class = "bloque-imagen" src = "Imagenes/k1.png" alt = "poque comprar">

                    <h3 class = "bloque-titulo">El mejor precio y calidad</h3>

                    <p>
                        Nosotros garantizamos un precio adecuado y 
                        una calidad única.
                    </p>

                </div> <!--fin class bloque-->
                
                <div class = "bloque">

                    <img class = "bloque-imagen" src = "Imagenes/o1.png" alt = "poque comprar">

                    <h3 class = "bloque-titulo">Valores</h3>

                    <p>
                        Esta florería promueve el respeto para todas
                        las personas y sobre todo el amor.
                    </p>

                </div> <!--fin class bloque-->

                <div class = "bloque">

                    <img class = "bloque-imagen" src = "Imagenes/op3.png" alt = "poque comprar">

                    <h3 class = "bloque-titulo">Diseño</h3>

                    <p>
                        Nos empeñamos demasiado para que tú ramo
                        sea único y especial para ti.
                    </p>

                </div> <!--fin class bloque-->



            </div> <!--fin class bloques-->
        </section> <!--Fin de la class contenedor comprar-->



    </main>  <!--Fin del main-->


    <footer>
        <p class = "footer-texto"> Frontend - Todos los derechos resevardos. Karen Baiza </p>
    </footer>

</body>
</html>   