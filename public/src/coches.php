<?php
session_name("Journey");
session_start();

require_once "funciones_CTES.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_coche = $_POST["id_coche"] ?? null;

    if (!$id_coche) {
        $_SESSION["error"] = "No se ha especificado ningún coche";
        header("Location: /JOURNEY/public/index.php?vista=cochesDisponibles");
        exit;
    }

    $timestamp = date("Y-m-d H:i:s");
    $session_id = session_id();
    $id_usuario = $_SESSION["datos_usuario_log"]["id_usuario"] ?? null;

    $reset_env = ["seleccionado_por" => $session_id];
    consumir_servicios_REST(DIR_SERV . "/resetSeleccionados", "PUT", $reset_env);

    if ($id_usuario) {
        $reset_env = ["seleccionado_por" => $id_usuario];
        consumir_servicios_REST(DIR_SERV . "/resetSeleccionados", "PUT", $reset_env);
    }

    $usuario = $id_usuario ?? $session_id;

    $datos_env = [
        "seleccionado_por" => $usuario,
        "seleccionado_timestamp" => $timestamp,
        "id_vehiculo" => $id_coche
    ];

    $respuesta = consumir_servicios_REST(DIR_SERV . "/seleccionarCoche", "PUT", $datos_env);
    $json_resp = json_decode($respuesta, true);

    if (isset($json_resp["error"])) {
        $_SESSION["error"] = "Error al seleccionar el coche: " . $json_resp["error"];
        header("Location: /JOURNEY/public/index.php?vista=mostrarCoches");
    } else {
        $_SESSION["coche_seleccionado"] = $id_coche;
        header("Location: /JOURNEY/public/index.php?vista=elegirPlan");
        exit;
    }

    exit;
}
