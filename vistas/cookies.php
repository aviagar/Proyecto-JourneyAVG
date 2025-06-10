<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journey</title>
    <link rel="stylesheet" href="../estilos/estilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/jquery.js"></script>

</head>

<div id="menuNavegacion">
    <nav id="opcionesMenu">
        <a href="index.php?vista=inicio&limpiar=1">
            <div>
                <h2>Inicio</h2>
            </div>
        </a>

        <a href="index.php?vista=cochesDisponibles">
            <div>
                <h2>Coches disponibles</h2>
            </div>
        </a>
        <a href="index.php?vista=sobreNosotros">
            <div>
                <h2>Sobre nosotros</h2>
            </div>
        </a>
        <a href="index.php?vista=serviciosJourney">
            <div>
                <h2>Servicios Journey</h2>
            </div>
        </a>
        <a href="index.php?vista=accesibilidad">
            <div class="sucursal">
                <h2>Accesibilidad</h2>
            </div>
        </a>
        <a href="index.php?vista=trailerJourney">
            <div class="sucursal">
                <h2>Trailer Journey</h2>
            </div>
        </a>
    </nav>

</div>

<header id="cabecera">
    <input type="checkbox" id="menu-toggle" style="display: none;">
    <label class="menu-toggle" for="menu-toggle" id="menuHamburguesa">
        <span></span>
        <span></span>
        <span></span>
    </label>

    <img src="../img/Iconos/Logo.svg" alt="Journey" class="logo">
    <a href="index.php?vista=perfilUsuario" id="usuarioIcono">
        <img src="../img/Iconos/Usuario.svg" alt="Usuario">
    </a>
</header>

<body>
    <main>
        <div class="header">
            <div class="titulo">
                <h2 class="pagoTitulo">Servicios Journey</h2>
            </div>
        </div>
        <div id="contenedorFijo">
            <div class="pagoFormulario" id="divSobreNosotros">
                <span class="subrayadoNegro">Journey bikes</span>
                <div class="pagoInput">
                    <p><strong>Política de Cookies de Journey</strong></p>

                    <p>
                        En Journey utilizamos cookies propias y de terceros para mejorar la experiencia de navegación de los usuarios,
                        ofrecer un servicio más personalizado y analizar la actividad del sitio web.
                    </p>

                    <p>
                        Las cookies son pequeños archivos de texto que se almacenan en tu navegador cuando visitas una página web. Estas
                        cookies permiten recordar tus preferencias, identificar sesiones, facilitar el inicio de sesión, mostrar contenido
                        relevante y obtener estadísticas de uso para mejorar el rendimiento del sitio.
                    </p>

                    <p><strong>Tipos de cookies utilizadas:</strong></p>

                    <ul>
                        <li><strong>Cookies técnicas:</strong> necesarias para el funcionamiento básico del sitio.</li>
                        <li><strong>Cookies de personalización:</strong> para recordar tus preferencias, como la sede seleccionada o el idioma.</li>
                        <li><strong>Cookies de análisis:</strong> que nos ayudan a entender cómo interactúan los usuarios con el sitio para mejorarlo.</li>
                        <li><strong>Cookies de terceros:</strong> como las de servicios de análisis o pasarelas de pago (ej. PayPal).</li>
                    </ul>

                    <p>
                        Puedes configurar tu navegador para bloquear o eliminar las cookies, aunque esto puede afectar al funcionamiento
                        correcto del sitio.
                    </p>

                    <p>
                        Al continuar navegando por este sitio, se considera que aceptas el uso de cookies conforme a nuestra política.
                        Puedes consultar más detalles en la sección de Aviso Legal y Política de Privacidad.
                    </p>

                </div>
            </div>
        </div>
    </main>
</body>

<footer>
    <div id="iconosFooter">
        <img alt="logo" src="../img/Iconos/Logo.svg" id="logo2" class="logo">
        <img alt="facebook" src="../img/Iconos/Facebook.svg" id="facebook" class="redes">
        <img alt="twitter" src="../img/Iconos/Twitter.svg" id="twitter" class="redes">
        <img alt="instagram" src="../img/Iconos/Instagram.svg" id="instagram" class="redes">
    </div>
    <div id="textoFooter">
        <a href="index.php?vista=inicio&limpiar=1" class="enlaces" id="enseñarCookies">Ajustes de cookies</a>
        <a href="index.php?vista=politicaPrivacidad" id="privacidad" class="enlaces">Política de privacidad</a>
        <a href="index.php?vista=condicionesGenerales" id="condiciones" class="enlaces">Condiciones generales</a>
        <a href="index.php?vista=ayuda" id="ayuda" class="enlaces">Ayuda</a>
        <span>© Journey 2025</span>
    </div>
</footer>

</html>