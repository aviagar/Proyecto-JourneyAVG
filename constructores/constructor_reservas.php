<?php
require_once "src/funciones_CTES.php";


if (!isset($_SESSION["token"])) {
    echo "<h1>Acceso no autorizado</h1>";
    return;
}

$url = DIR_SERV . "/obtenerReservasCliente";
$headers = ['Authorization: Bearer ' . $_SESSION["token"]];
$respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
$respuesta = json_decode($respuesta, true);

if (isset($respuesta["error"])) {
    echo "<h1 class = 'centrado'>Error al obtener las reservas: " . htmlspecialchars($respuesta["error"]) . "</h1>";
    echo '<form action="index.php" method="post" class="pagoFormulario">
        <div class="contenedorCentrado">
            <button type="submit" name="btnSalir" value="salir" class="botonConfirmarCuadrado">
                Salir
            </button>
        </div>
    </form>';
    return;
}

if (empty($respuesta["reservas_usuario"])) {
    echo "<h1 class = 'centrado'>No dispones de ninguna reserva actualmente</h1>";
    echo '<form action="index.php" method="post" class="pagoFormulario">
        <div class="contenedorCentrado">
            <button type="submit" name="btnSalir" value="salir" class="botonConfirmarCuadrado">
                Salir
            </button>
        </div>
    </form>';
    return;
}

$reservas = $respuesta["reservas_usuario"] ?? [];

if (empty($reservas)) {
    echo "<h1 class = 'centrado'> No dispones de ninguna reserva actualmente</h1>";
    return;
}

echo "<div id='historial_reservas'>";

foreach ($reservas as $reserva) {
    $id_reserva = htmlspecialchars($reserva["id_reserva"]);
    $fecha_inicio = new DateTime($reserva["fecha_inicio"]);
    $fecha_fin = new DateTime($reserva["fecha_fin"]);
    $sede_recogida = htmlspecialchars($reserva["nombre_sede_recogida"]);
    $sede_entrega = htmlspecialchars($reserva["nombre_sede_entrega"]);
    $estado = htmlspecialchars($reserva["estado_reserva"]);
    $plan = htmlspecialchars($reserva["plan"]);

    $fechaInicioFormateada = $fecha_inicio->format("d M | H:i");
    $fechaFinFormateada = $fecha_fin->format("d M | H:i");

    echo <<<HTML
<div class="reserva">
    <form action="index.php?vista=vistaActualizarReserva" method="post" class="formActualizarReserva">
        <input type="hidden" name="id_reserva" value="{$id_reserva}">
        <button type="submit" class="btnReservaDetalle" style="all: unset; cursor: pointer; width: 100%;">
            <nav class="volverDetalles">
                <span>{$sede_recogida} - {$sede_entrega}</span>
                <img alt="editar" src="img/Iconos/LapizEditar.svg" id="editar">
                <span class="subtitulo">{$fechaInicioFormateada} - {$fechaFinFormateada}</span>
                <span class="estadoReserva">Estado: {$estado} | Plan: {$plan}</span>
            </nav>
        </button>
    </form>
</div>
HTML;
}

echo "</div>";
