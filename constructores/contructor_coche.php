<?php
require_once "src/funciones_CTES.php";

$url = DIR_SERV . "/obtenerCochesDisponibles";
$parametros = [
    'fecha_inicio' => $_SESSION['periodo_reserva']['fechaRecogida'],
    'fecha_fin' => $_SESSION['periodo_reserva']['fechaDevolucion'],
    'id_sede_recogida' => $_SESSION['periodo_reserva']['idSedeRecogida']
];
$respuesta = consumir_servicios_REST($url, "GET", $parametros);

if (is_string($respuesta)) {
    $respuesta = json_decode($respuesta, true);
}

if (isset($respuesta["error"])) {
    echo "<p>Error al obtener coches: " . htmlspecialchars($respuesta["error"]) . "</p>";
    return;
}

if (isset($respuesta["sin_coches"])) {
    echo "<div class='contenedor_not_found'>";
    echo "<img src='img/Iconos/not_results.svg' class = 'not_found' alt='No hay coches disponibles para su viaje'>";
    echo "<h1>OH NO!</h1>";
    echo "<p>" . htmlspecialchars($respuesta["sin_coches"]) . ", por favor intente otra fecha.</p>";
    echo "</div>";
    return;
}

$coches = $respuesta["coches"] ?? [];
?>

<form action="<?= PUBLIC_PATH ?>src/coches.php" method="post">
    <div id="coches">
        <?php
        $session_id = session_id();
        $id_usuario = isset($_SESSION["token"]) ? (string)$_SESSION["datos_usuario_log"]["id_usuario"] : null;

        $ahora = new DateTime(); // Fecha y hora actual

        foreach ($coches as $coche):
            $estado = $coche["estado"];
            $seleccionado_por = $coche["seleccionado_por"];
            $timestamp_raw = $coche["seleccionado_timestamp"];

            // Saltar coches con estado reservado o no disponible
            if ($estado === "Reservado" || $estado === "No disponible") {
                continue;
            }

            // Evaluar si hay selección y si ha expirado
            $expirado = false;
            if (!is_null($seleccionado_por) && !is_null($timestamp_raw)) {
                try {
                    $seleccion_time = new DateTime($timestamp_raw);
                    $diff = $ahora->getTimestamp() - $seleccion_time->getTimestamp();

                    if ($diff > 600) { // 600 segundos = 10 minutos
                        $expirado = true;
                    }
                } catch (Exception $e) {
                    $expirado = true; // Si falla la conversión, lo tratamos como expirado
                }
            }

            // Mostrar si:
            // - no tiene seleccionado_por
            // - lo ha seleccionado el mismo usuario o misma sesión
            // - ha expirado la selección
            if (
                is_null($seleccionado_por) ||
                ($id_usuario !== null && $seleccionado_por === $id_usuario) ||
                ($id_usuario === null && $seleccionado_por === $session_id) ||
                $expirado
            ) {
                $id = htmlspecialchars($coche["id_vehiculo"]);
                $img = htmlspecialchars($coche["imagen"]);
                $alt = htmlspecialchars($coche["marca"] . " " . $coche["modelo"]);
        ?>
                <button class="coche" type="submit" name="id_coche" value="<?= $id ?>">
                    <img class="coche" src="img/Imagenes/<?= $img ?>" alt="<?= $alt ?>">
                    <div class="car-info-wrapper">
                        <div class="car-info-main">
                            <h3><?= $coche["marca"] . " " . $coche["modelo"] ?></h3>
                            <p><?= $coche["combustible"] ?></p>
                        </div>
                        <p class="car-info-desc"><?= $coche["descripcion"] ?></p>
                        <div class="car-info-secundary">
                            <p><?= $coche["plazas"] ?></p>
                            <p><?= $coche["transmision"] ?></p>
                        </div>
                    </div>

                </button>
        <?php
            }
        endforeach; ?>

    </div>
</form>