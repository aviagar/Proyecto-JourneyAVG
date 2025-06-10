<?php
session_name("Journey");
session_start();

require_once "funciones_CTES.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idReserva = $_SESSION['actualizar_reserva']['id_reserva'] ?? null;
    $ubicacionRecogida = $_POST["ubicacionRecogida"] ?? null;
    $ubicacionDevolucion = $_POST["ubicacionDevolucion"] ?? null;
    $fechaRecogida = $_POST["fechaRecogida"] ?? null;
    $horaRecogida = $_POST["horaRecogida"] ?? null;
    $fechaDevolucion = $_POST["fechaDevolucion"] ?? null;
    $horaDevolucion = $_POST["horaDevolucion"] ?? null;
    $idSedeRecogida = $_POST["idSedeRecogida"] ?? null;
    $idSedeDevolucion = $_POST["idSedeDevolucion"] ?? null;

    $errores = [];

    // Validaciones simples
    if (!$ubicacionRecogida) {
        $errores['ubicacionRecogida'] = "La ubicación de recogida es obligatoria.";
    }

    if (!$ubicacionDevolucion) {
        $errores['ubicacionDevolucion'] = "La ubicación de devolución es obligatoria.";
    }

    if (!$fechaRecogida) {
        $errores['fechaRecogida'] = "La fecha de recogida es obligatoria.";
    }

    if (!$horaRecogida) {
        $errores['horaRecogida'] = "La hora de recogida es obligatoria.";
    }

    if (!$fechaDevolucion) {
        $errores['fechaDevolucion'] = "La fecha de devolución es obligatoria.";
    }

    if (!$horaDevolucion) {
        $errores['horaDevolucion'] = "La hora de devolución es obligatoria.";
    }

    if (!empty($errores)) {
        $_SESSION['errores_reserva'] = $errores;

        $idReserva = $_SESSION['actualizar_reserva']['id_reserva'] ?? null;

        $_SESSION['actualizar_reserva'] = [
            'id_reserva' => $idReserva,
            'ubicacionRecogida' => $ubicacionRecogida,
            'ubicacionDevolucion' => $ubicacionDevolucion,
            'diaRecogida' => $fechaRecogida,
            'horaRecogida' => $horaRecogida,
            'diaDevolucion' => $fechaDevolucion,
            'horaDevolucion' => $horaDevolucion
        ];

        header("Location: /index.php?vista=vistaActualizarReserva");
        exit;
    }


    if ($fechaRecogida && $fechaDevolucion && $horaRecogida && $horaDevolucion) {
        $inicio = strtotime("$fechaRecogida $horaRecogida");
        $fin = strtotime("$fechaDevolucion $horaDevolucion");
        if ($fin < $inicio) {
            $errores['fechaDevolucion'] = "La devolución debe ser posterior a la recogida.";
        }
    }

    if (!$idRecogida || !$idDevolucion) {
        $respuesta = consumir_servicios_REST(DIR_SERV . "/obtenerSedes", "GET");
        if (isset($respuesta["error"])) {
            $_SESSION["error"] = "Error al obtener sedes: " . $respuesta["error"];
            header("Location: /index.php?vista=inicio");
            exit;
        }

        if (is_string($respuesta)) {
            $respuesta = json_decode($respuesta, true);
        }

        $sedes = $respuesta["sedes"] ?? [];

        foreach ($sedes as $sede) {
            if ($sede["nombre_sede"] === $ubicacionRecogida) {
                $idRecogida = $sede["id_sede"];
            }
            if ($sede["nombre_sede"] === $ubicacionDevolucion) {
                $idDevolucion = $sede["id_sede"];
            }
        }

        if (!$idRecogida || !$idDevolucion) {
            if (!$idRecogida) {
                $_SESSION["error_recogida"] = "No se encontró la sede de recogida especificada.";
            }
            if (!$idDevolucion) {
                $_SESSION["error_devolucion"] = "No se encontró la sede de devolución especificada.";
            }
            header("Location: /index.php?vista=vistaActualizarReserva");
            exit;
        }
    } else {
        $idRecogida = $_POST["idSedeRecogida"];
        $idDevolucion = $_POST["idSedeDevolucion"];
    }

    if (!empty($errores)) {
        $_SESSION['errores_reserva'] = $errores;
        $_SESSION['actualizar_reserva'] = [
            'ubicacionRecogida' => $ubicacionRecogida,
            'ubicacionDevolucion' => $ubicacionDevolucion,
            'diaRecogida' => $fechaRecogida,
            'horaRecogida' => $horaRecogida,
            'diaDevolucion' => $fechaDevolucion,
            'horaDevolucion' => $horaDevolucion
        ];
        header("Location: /index.php?vista=vistaActualizarReserva");
        exit;
    }

    $datos_env = [
        'id_reserva' => $idReserva,
        'fecha_inicio' => $fechaRecogida . ' ' . $horaRecogida,
        'fecha_fin' => $fechaDevolucion . ' ' . $horaDevolucion,
        'sede_recogida' => $idRecogida,
        'sede_entrega' => $idDevolucion
    ];

    $url = DIR_SERV . "/actualizarReserva";
    $headers = [
        'Authorization: Bearer ' . $_SESSION["token"]
    ];

    // Consumir servicio con método PUT
    $respuesta = consumir_servicios_JWT_REST($url, "PUT", $headers, $datos_env);
    $json_respuesta = json_decode($respuesta, true);

    if (!$json_respuesta || isset($json_respuesta["error"])) {
        $_SESSION["error"] = $json_respuesta["error"] ?? "Error al actualizar la reserva.";
        header("Location: /index.php?vista=vistaActualizarReserva");
        exit;
    }

    // Éxito
    header("Location: /index.php?vista=confirmaActualizarReserva");
    exit;
}
