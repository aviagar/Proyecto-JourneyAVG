<?php
session_name("Journey");
session_start();

require_once "funciones_CTES.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ubicacionRecogida = $_POST["ubicacionRecogida"] ?? null;
    $ubicacionDevolucion = $_POST["ubicacionDevolucion"] ?? null;
    $fechaRecogida = $_POST["fechaRecogida"] ?? null;
    $horaRecogida = $_POST["horaRecogida"] ?? null;
    $fechaDevolucion = $_POST["fechaDevolucion"] ?? null;
    $horaDevolucion = $_POST["horaDevolucion"] ?? null;
    $idRecogida = $_POST["idSedeRecogida"] ?? null;
    $idDevolucion = $_POST["idSedeDevolucion"] ?? null;


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

    // Ejemplo extra: validar que la devolución no sea antes que la recogida
    if ($fechaRecogida && $fechaDevolucion && $horaRecogida && $horaDevolucion) {
        $inicio = strtotime("$fechaRecogida $horaRecogida");
        $fin = strtotime("$fechaDevolucion $horaDevolucion");
        if ($fin < $inicio) {
            $errores['fechaDevolucion'] = "La fecha y hora de devolución deben ser posteriores a la recogida.";
        }
    }

    if (!empty($errores)) {
        $_SESSION['errores_reserva'] = $errores;

        // Guardar datos antiguos para rellenar el formulario
        $_SESSION['periodo_reserva'] = [
            'ubicacionRecogida' => $ubicacionRecogida,
            'ubicacionDevolucion' => $ubicacionDevolucion,
            'diaRecogida' => $fechaRecogida,
            'horaRecogida' => $horaRecogida,
            'diaDevolucion' => $fechaDevolucion,
            'horaDevolucion' => $horaDevolucion
        ];

        header("Location: /JOURNEY/public/index.php?vista=inicio");
        exit;
    }



    if (!$idRecogida || !$idDevolucion) {
        $respuesta = consumir_servicios_REST(DIR_SERV . "/obtenerSedes", "GET");
        if (isset($respuesta["error"])) {
            $_SESSION["error"] = "Error al obtener sedes: " . $respuesta["error"];
            header("Location: /JOURNEY/public/index.php?vista=inicio");
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
            header("Location: /JOURNEY/public/index.php?vista=inicio");
            exit;
        }
    } else {
        $idRecogida = $_POST["idSedeRecogida"];
        $idDevolucion = $_POST["idSedeDevolucion"];
    }


    // Combinar fechas y horas en formato datetime
    $datetimeRecogida = date("Y-m-d H:i:s", strtotime($fechaRecogida . ' ' . $horaRecogida));
    $datetimeDevolucion = date("Y-m-d H:i:s", strtotime($fechaDevolucion . ' ' . $horaDevolucion));

    // Guardar en la sesión
    // Guardar en variables de sesión individuales
    $_SESSION["periodo_reserva"] = [
        "ubicacionRecogida"   => $ubicacionRecogida,
        "idSedeRecogida"          => $idRecogida,
        "ubicacionDevolucion" => $ubicacionDevolucion,
        "idSedeDevolucion"        => $idDevolucion,
        "fechaRecogida"       => $datetimeRecogida,
        "fechaDevolucion"     => $datetimeDevolucion,
        "horaRecogida"       => $horaRecogida,
        "horaDevolucion"     => $horaDevolucion,
        "diaRecogida"       => $fechaRecogida,
        "diaDevolucion"     => $fechaDevolucion
    ];


    $_SESSION["mensaje"] = "Datos de reserva guardados correctamente.";

    // Redirigir a la siguiente vista (ej: detalles del alquiler)
    header("Location: /JOURNEY/public/index.php?vista=mostrarCoches");
    exit;
}
