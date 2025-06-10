<?php

$usuario = $_SESSION["datos_usuario_log"] ?? null;

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journey</title>
    <link rel="stylesheet" href="estilos/estilos.css" >
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="js/jquery.js"></script>

</head>

<header id="cabecera">
    <!-- Botón hamburguesa (solo visible en móvil) -->
    <label class="menu-toggle" id="menuHamburguesa">
        <span></span>
        <span></span>
        <span></span>
    </label>

    <!-- Menú de navegación -->
    <div id="menuNavegacion">
        <nav id="opcionesMenu">
            <a href="<?= PUBLIC_PATH ?>index.php?vista=inicio&limpiar=1">
                <div><h2>Inicio</h2></div>
            </a>
            <a href="<?= PUBLIC_PATH ?>index.php?vista=sobreNosotros">
                <div><h2>Sobre nosotros</h2></div>
            </a>
            <a href="<?= PUBLIC_PATH ?>index.php?vista=serviciosJourney">
                <div><h2>Servicios Journey</h2></div>
            </a>
        </nav>
    </div>


    <img src="img/Iconos/Logo.svg" alt="Journey" class="logo">
    <a href="<?= PUBLIC_PATH ?>index.php?vista=perfilUsuario" id="usuarioIcono">
        <img src="img/Iconos/Usuario.svg" alt="Usuario">
    </a>
    <script type="text/javascript" charset="UTF-8" src="//cdn.cookie-script.com/s/1c40c037eb35615e67de7ccff5ba2c85.js"></script>
</header>