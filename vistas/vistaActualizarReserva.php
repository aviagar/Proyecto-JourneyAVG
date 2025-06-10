<?php
if (isset($_POST['id_reserva'])) {
    $_SESSION['actualizar_reserva']['id_reserva'] = $_POST['id_reserva'];
}
?>

<!DOCTYPE html>
<html lang="en">

<body>
    <div id="contenedorFijo">
        <div class="header">
            <a href="<?= PUBLIC_PATH ?>index.php?vista=inicio">
                <img alt="salir" src="img/Iconos/Salir(X).svg" id="salir">
            </a>
            <div class="titulo">
                <span id="titulo">Detalles de su alquiler</span>
            </div>
        </div>

        <main id="mainDetalles">
            <form method="POST" action="src/actualizar_reserva.php" id="formFechas" class="formFechas">

                <div class="inputWrapper">
                    <input type="text" id="ubicacionRecogida"
                        class="aeropuerto inputBuscador buscadorSedesDetalles <?php if (isset($_SESSION['errores_reserva']['ubicacionRecogida'])) echo 'campoInvalido'; ?>"
                        name="ubicacionRecogida" autocomplete="off"
                        data-sugerencias="sugerenciasSucursalRecogida"
                        data-hidden-id="idSedeRecogida"
                        placeholder="Aeropuerto, Ciudad, Estación..."
                        value="<?php if (isset($_SESSION['actualizar_reserva']['ubicacionRecogida'])) echo $_SESSION['actualizar_reserva']['ubicacionRecogida']; ?>">
                    </input>
                    <div id="sugerenciasSucursalRecogida"></div>
                    <input type="hidden" id="idSedeRecogida" name="idSedeRecogida" value="<?php if (isset($_POST['idSedeRecogida'])) echo $_POST['idSedeRecogida']; ?>">
                    <?php
                    if (isset($_SESSION['errores_reserva']['ubicacionRecogida'])) {
                        echo '<p class="error-message">' . $_SESSION['errores_reserva']['ubicacionRecogida'] . '</p>';
                    }
                    ?>
                </div>

                <div class="inputWrapper">
                    <input type="text" id="ubicacionDevolucion"
                        class="aeropuerto inputBuscador buscadorSedesDetalles <?php if (isset($_SESSION['errores_reserva']['ubicacionDevolucion'])) echo 'campoInvalido'; ?>"
                        name="ubicacionDevolucion" autocomplete="off"
                        data-sugerencias="sugerenciasSucursalDevolucion"
                        data-hidden-id="idSedeDevolucion"
                        placeholder="Aeropuerto, Ciudad, Estación..."
                        value="<?php if (isset($_SESSION['actualizar_reserva']['ubicacionDevolucion'])) echo $_SESSION['actualizar_reserva']['ubicacionDevolucion']; ?>">
                    </input>
                    <div id="sugerenciasSucursalDevolucion"></div>
                    <input type="hidden" id="idSedeDevolucion" name="idSedeDevolucion">
                    <?php
                    if (isset($_SESSION['errores_reserva']['ubicacionDevolucion'])) {
                        echo '<p class="error-message">' . $_SESSION['errores_reserva']['ubicacionDevolucion'] . '</p>';
                    }
                    ?>
                </div>

                <div id='linea1' class="linea"></div>



                <nav id="recogida-devolucion">
                    <span>Recogida</span>
                    <span>Devolución</span>

                    <!-- Inputs ocultos para enviar -->
                    <input type="hidden" name="fechaRecogida" id="fechaRecogida" value="<?php if (isset($_SESSION['actualizar_reserva']['diaRecogida'])) echo $_SESSION['actualizar_reserva']['diaRecogida']; ?>">
                    <input type="hidden" name="horaRecogida" id="horaRecogida">
                    <input type="hidden" name="fechaDevolucion" id="fechaDevolucion" value="<?php if (isset($_SESSION['actualizar_reserva']['diaDevolucion'])) echo $_SESSION['actualizar_reserva']['diaDevolucion']; ?>">
                    <input type="hidden" name="horaDevolucion" id="horaDevolucion">

                    <!-- Calendario visual -->
                    <div id="recogidaCuadro">
                        <div onclick="abrirCalendario('recogidaCuadro')"
                            class="<?php if (isset($_SESSION['errores_reserva']['fechaRecogida'])) echo 'campoInvalido'; ?>">
                            <img alt="Calendario" src="img/Iconos/Calendario.svg">
                            <span id="recogidaFechaTexto">
                                <?php
                                if (isset($_SESSION['actualizar_reserva']['diaRecogida']))
                                    echo $_SESSION['actualizar_reserva']['diaRecogida'];
                                else
                                    echo 'Seleccionar fechas';
                                ?>
                            </span>
                        </div>
                        <div id="linea2" class="linea"></div>
                        <div>
                            <input type="time" id="horaRecogidaInput"
                                name="horaRecogida"
                                class="<?php if (isset($_SESSION['errores_reserva']['horaRecogida'])) echo 'campoInvalido'; ?>"
                                value="<?php if (isset($_SESSION['actualizar_reserva']['horaRecogida'])) echo $_SESSION['actualizar_reserva']['horaRecogida']; ?>">
                            <?php
                            if (isset($_SESSION['errores_reserva']['horaRecogida'])) {
                                echo '<p class="error-message">' . $_SESSION['errores_reserva']['horaRecogida'] . '</p>';
                            }
                            ?>
                        </div>
                        <?php
                        if (isset($_SESSION['errores_reserva']['fechaRecogida'])) {
                            echo '<p class="error-message">' . $_SESSION['errores_reserva']['fechaRecogida'] . '</p>';
                        }
                        ?>
                    </div>

                    <div id="devolucionCuadro">
                        <div onclick="abrirCalendario('devolucionCuadro')"
                            class="<?php if (isset($_SESSION['errores_reserva']['fechaDevolucion'])) echo 'campoInvalido'; ?>">
                            <img alt="Calendario" src="img/Iconos/Calendario.svg">
                            <span id="devolucionFechaTexto">
                                <?php
                                if (isset($_SESSION['actualizar_reserva']['diaDevolucion']))
                                    echo $_SESSION['actualizar_reserva']['diaDevolucion'];
                                else
                                    echo 'Seleccionar fechas';
                                ?>
                            </span>
                        </div>
                        <div id="linea3" class="linea"></div>
                        <div>
                            <input type="time" id="horaDevolucionInput"
                                name="horaDevolucion"
                                class="<?php if (isset($_SESSION['errores_reserva']['horaDevolucion'])) echo 'campoInvalido'; ?>"
                                value="<?php if (isset($_SESSION['actualizar_reserva']['horaDevolucion'])) echo $_SESSION['actualizar_reserva']['horaDevolucion']; ?>">
                            <?php
                            if (isset($_SESSION['errores_reserva']['horaDevolucion'])) {
                                echo '<p class="error-message">' . $_SESSION['errores_reserva']['horaDevolucion'] . '</p>';
                            }
                            ?>
                        </div>
                        <?php
                        if (isset($_SESSION['errores_reserva']['fechaDevolucion'])) {
                            echo '<p class="error-message">' . $_SESSION['errores_reserva']['fechaDevolucion'] . '</p>';
                        }
                        ?>
                    </div>


                    <!-- Calendario oculto -->
                    <input type="text" id="flatpickrCalendar" />

                </nav>
                <div id='linea4' class="linea"></div>
                <button type="submit" id="seleccionarRecogidaBtn" class="aeropuerto-b" autocomplete="off">
                    Mostrar Coches</button>
            </form>

        </main>
        <?php
        unset($_SESSION['errores_reserva']);
        ?>

    </div>
</body>


</html>