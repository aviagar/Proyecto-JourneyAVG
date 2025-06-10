<?php
session_name("Journey");
session_start();

require_once "funciones_CTES.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación básica de los campos del formulario
    $numero_tarjeta = trim($_POST['numero_tarjeta'] ?? '');
    $nombre_titular = trim($_POST['nombre_titular'] ?? '');
    $fecha_expiracion = trim($_POST['fecha_expiracion'] ?? '');
    $cvv = trim($_POST['cvv'] ?? '');
    $pais = trim($_POST['pais'] ?? '');
    $codigo_postal = trim($_POST['codigo_postal'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $ciudad = trim($_POST['ciudad'] ?? '');
    $provincia = trim($_POST['provincia'] ?? '');

    if (
        !$numero_tarjeta || !$nombre_titular || !$fecha_expiracion || !$cvv ||
        !$pais || !$codigo_postal || !$direccion || !$ciudad || !$provincia
    ) {
        $_SESSION["error"] = "Faltan datos del formulario.";
        header("Location: /JOURNEY/public/index.php?vista=pago");
        exit;
    }

    // Validamos que existan los datos de sesión requeridos
    if (
        !isset($_SESSION["coche_seleccionado"]) ||
        !isset($_SESSION["periodo_reserva"]["fechaRecogida"]) ||
        !isset($_SESSION["periodo_reserva"]["fechaDevolucion"]) ||
        !isset($_SESSION["periodo_reserva"]["idSedeRecogida"]) ||
        !isset($_SESSION["periodo_reserva"]["idSedeDevolucion"]) ||
        !isset($_SESSION["periodo_reserva"]["plan"]) ||
        !isset($_SESSION["datos_usuario_log"]["id_usuario"])

    ) {
        $_SESSION["error"] = "Faltan datos de la reserva en la sesión.";
        header("Location: /JOURNEY/public/index.php?vista=inicio");
        exit;
    }

    // Construimos los datos para enviar al servicio
    $datos_env = [
        "id_usuario" => $_SESSION["datos_usuario_log"]["id_usuario"],
        "id_vehiculo" => $_SESSION["coche_seleccionado"],
        "fecha_inicio" => $_SESSION["periodo_reserva"]["fechaRecogida"],
        "fecha_fin" => $_SESSION["periodo_reserva"]["fechaDevolucion"],
        "ubicacion_recogida" => $_SESSION["periodo_reserva"]["idSedeRecogida"],
        "ubicacion_devolucion" => $_SESSION["periodo_reserva"]["idSedeDevolucion"],
        "plan" => $_SESSION["periodo_reserva"]["plan"]
    ];


    // Llamamos al servicio REST para registrar la reserva
    $url = DIR_SERV . "/realizarReserva";
    $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
    $respuesta = consumir_servicios_JWT_REST($url, "POST", $headers, $datos_env);
    $json_reserva = json_decode($respuesta, true);

    if (!$json_reserva || isset($json_reserva["error"])) {
        $_SESSION["error"] = $json_reserva["error"] ?? "Error al procesar la reserva.";
        header("Location: /JOURNEY/public/index.php?vista=pago");
        exit;
    }

    // Éxito
    $_SESSION["reserva_completada"] = "¡Reserva realizada con éxito!";
    // Limpiamos los datos de la reserva de la sesión
    unset($_SESSION["periodo_reserva"]);
    unset($_SESSION["coche_seleccionado"]);

    header("Location: /JOURNEY/public/index.php?vista=confirmaReserva");
    exit;
} else {
    header("Location: /JOURNEY/public/index.php?vista=pago");
    exit;
}
