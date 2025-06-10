<?php
// FIX TEMPORAL COOKIES
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_name("Journey");
session_start();
require "src/funciones_CTES.php";
define("PUBLIC_PATH", "/JOURNEY/public/");


$vista = $_GET["vista"] ?? "inicio";

// Vistas donde no se quiere mostrar header/footer
$vistas_sin_header_footer = ["vistaAdmin"];
$mostrarHeaderFooter = !in_array($vista, $vistas_sin_header_footer);

if ($mostrarHeaderFooter) {
    include __DIR__ . "/components/header.php";
}
var_dump($_SESSION);
// Cierre de sesión 
if (isset($_POST["btnCerrarSession"])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Si hay sesión activa, pasamos por seguridad
if (isset($_SESSION["token"])) {
    require "src/seguridad.php";
    $datos_usuario_log = $_SESSION["datos_usuario_log"];
}

if (isset($_SESSION["mensaje_seguridad"])) {
    echo "<p class='mensaje'>" . $_SESSION["mensaje_seguridad"] . "</p>";
    unset($_SESSION["mensaje_seguridad"]);
}

// Si el usuario pulsa inicio, su reserva se resetea
if ((isset($_GET['limpiar']) && $_GET['limpiar'] == '1') || isset($_POST['btnSalir'])) {
    unset($_SESSION['periodo_reserva']);
    unset($_SESSION['coche_seleccionado']);

    header("Location: index.php?vista=inicio");
    exit;
}


// Controlador central de vistas
$vista = $_GET["vista"] ?? "inicio";

switch ($vista) {
    case "vistaAdmin":
        if (isset($_SESSION["datos_usuario_log"]["tipo"]) && $_SESSION["datos_usuario_log"]["tipo"] == "admin") {
            require "vistas/vistaAdmin.php";
            break;
        } else {
            header("Location: index.php?vista=inicio");
            exit;
        }

    case "accesibilidad":
        require "vistas/accesibilidad.php";
        break;

    case "ayuda":
        require "vistas/ayuda.php";
        break;

    case "condicionesGenerales":
        require "vistas/condicionesGenerales.php";
        break;

    case "confirmaReserva":
        if (isset($_SESSION["reserva_completada"])) {
            require "vistas/confirmaReserva.php";
            break;
        } else {
            header("Location: index.php?vista=inicio");
            exit;
        }

    case "detallesAlquiler":
        if (((isset($_SESSION["periodo_reserva"]["ubicacionDevolucion"])) && (isset($_SESSION["periodo_reserva"]["ubicacionRecogida"]))) || isset($_POST["ubicacionRecogida"])) {
            require "vistas/detallesAlquiler.php";
            break;
        } else {
            header("Location: index.php?vista=inicio");
            exit;
        }

    case "fechasDelViaje":
        require "vistas/fechasDelViaje.php";
        break;

    case "mostrarCoches":
        if ((isset($_SESSION["periodo_reserva"]["ubicacionRecogida"])) && (isset($_SESSION["periodo_reserva"]["ubicacionDevolucion"]))) {
            require "vistas/mostrarCoches.php";
            break;
        } else {
            header("Location: index.php?vista=inicio");
            exit;
        }

    case "pago":
        if ((isset($_SESSION["coche_seleccionado"])) && (isset($_SESSION["periodo_reserva"]["ubicacionRecogida"])) && (isset($_SESSION["token"]))) {
            require "vistas/pago.php";
            break;
        } else {
            header("Location: index.php?vista=inicio");
            exit;
        }

    case "perfilUsuario":
        if (isset($_SESSION["token"])) {
            require "vistas/perfilUsuario.php";
        } else {
            header("Location: index.php?vista=inicioSesion");
            exit;
        }
        break;

    case "politicaPrivacidad":
        require "vistas/politicaPrivacidad.php";
        break;

    case "serviciosJourney":
        require "vistas/serviciosJourney.php";
        break;

    case "sobreNosotros":
        require "vistas/sobreNosotros.php";
        break;

    case "inicioSesion":
        if (!isset($_SESSION["token"])) {
            require "vistas/vistaInicioSesion.php";
            break;
        } else {
            header("Location: index.php?vista=inicio");
            exit;
        }

    case "registro":
        if (!isset($_SESSION["token"])) {
            require "vistas/vistaRegistro.php";
            break;
        } else {
            header("Location: index.php?vista=inicio");
            exit;
        }

    case "elegirPlan":
        if ((isset($_SESSION["coche_seleccionado"])) && (isset($_SESSION["periodo_reserva"]["ubicacionRecogida"]))) {
            require "vistas/elegirPlan.php";
            break;
        } else {
            header("Location: index.php?vista=inicio");
            exit;
        }

    case "inicio":
    default:
        require "vistas/vistaInicio.php";
        break;
}

if ($mostrarHeaderFooter) {
    include __DIR__ . "/components/footer.php";
}
