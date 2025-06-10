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

    case "guardar_edicion":
        if ($tabla === "vehiculos") {
            $datos = [
                "id_vehiculo" => $_POST["id_vehiculo"],
                "marca" => $_POST["marca"],
                "modelo" => $_POST["modelo"],
                "matricula" => $_POST["matricula"],
                "estado" => $_POST["estado"],
                "sede_actual" => $_POST["sede_actual"],
                "plazas" => $_POST["plazas"],
                "transmision" => $_POST["transmision"],
                "descripcion" => $_POST["descripcion"],
                "combustible" => $_POST["combustible"]
            ];

            $respuesta = consumir_servicios_JWT_REST(DIR_SERV . "/editarVehiculo", "PUT", $headers, $datos);
            $json = json_decode($respuesta, true);

            if (isset($json["error"])) {
                $_SESSION["mensaje_error"] = "Error al editar: " . $json["error"];
            } elseif (isset($json["mensaje"])) {
                $_SESSION["mensaje_info"] = $json["mensaje"];
            } else {
                $_SESSION["mensaje_error"] = "Respuesta inesperada del servidor";
            }
        }
        break;

    case "insertar":
        if ($tabla === "vehiculos") {
            $datos = [
                "marca" => $_POST["marca"],
                "modelo" => $_POST["modelo"],
                "matricula" => $_POST["matricula"],
                "estado" => $_POST["estado"],
                "sede_actual" => $_POST["sede_actual"],
                "plazas" => $_POST["plazas"],
                "transmision" => $_POST["transmision"],
                "descripcion" => $_POST["descripcion"],
                "combustible" => $_POST["combustible"]
            ];
            $respuesta = consumir_servicios_JWT_REST(DIR_SERV . "/insertarVehiculo", "POST", $headers, $datos);
            $json = json_decode($respuesta, true);

            if (isset($json["error"])) {
                $_SESSION["mensaje_error"] = "Error al insertar: " . $json["error"];
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
header("Location: index.php?vista=vistaAdmin");
exit;
