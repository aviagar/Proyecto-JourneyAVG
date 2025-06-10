<?php
session_name("Journey");
session_start();
require_once "funciones_CTES.php";

if (!isset($_SESSION["token"])) {
    exit("Acceso no autorizado");
}

$accion = $_POST["accion"] ?? null;
$tabla = $_POST["tabla"] ?? null;
$id = $_POST["id"] ?? null;

$headers = ['Authorization: Bearer ' . $_SESSION["token"]];

switch ($accion) {
    case "eliminar":
        if ($tabla === "vehiculos") {
            $datos = ["id_vehiculo" => $id];
            $respuesta = consumir_servicios_JWT_REST(DIR_SERV . "/eliminarVehiculo", "DELETE", $headers, $datos);
            $json = json_decode($respuesta, true);

            if (isset($json["error"])) {
                $_SESSION["mensaje_error"] = "Error al eliminar: " . $json["error"];
            } elseif (isset($json["mensaje"])) {
                $_SESSION["mensaje_info"] = $json["mensaje"];
            } else {
                $_SESSION["mensaje_error"] = "Respuesta inesperada del servidor";
            }
        }
        break;

    // Aquí puedes ir añadiendo insertarVehiculo, editarVehiculo, y lo mismo para otras tablas
    // ...

    default:
        $_SESSION["mensaje_error"] = "Acción no reconocida";
        break;
}

// Redirige de nuevo al panel admin
header("Location: /JOURNEY/public/index.php?vista=vistaAdmin");
exit;
