<!DOCTYPE html>
<html lang="es">

<body>
    <main>
        <div id="portada">
            <div id="buscadorFechasLugaresMovil">
                <div id="rectanguloBuscarCiudadMovil">
                    <form method="POST" action="<?= PUBLIC_PATH ?>index.php?vista=detallesAlquiler" class="formFechas">
                        <div class="search-wrapper">
                            <img src="img/Iconos/Lupa.svg" alt="Buscar">
                            <div class="inputWrapper">
                                <input type="text" id="ubicacionRecogidaMovil" class="aeropuerto inputBuscador escritorio <?php if (isset($_SESSION['errores_reserva']['ubicacionRecogida'])) echo 'campoInvalido'; ?>" name="ubicacionRecogida" autocomplete="off"
                                    data-sugerencias="sugerenciasSucursalRecogidaMovil"
                                    data-hidden-id="idSedeRecogidaMovil"
                                    placeholder="Aeropuerto, Ciudad, Estación..."
                                    value="<?php if (isset($_SESSION['periodo_reserva']['ubicacionRecogida'])) echo $_SESSION['periodo_reserva']['ubicacionRecogida']; ?>">
                                </input>
                                <?php
                                if (isset($_SESSION['errores_reserva']['ubicacionRecogida'])) {
                                    echo '<p class="error-message">' . $_SESSION['errores_reserva']['ubicacionRecogida'] . '</p>';
                                }
                                ?>

                                <div id="sugerenciasSucursalRecogidaMovil"></div>
                                <input type="hidden" id="idSedeRecogidaMovil" name="idSedeRecogida">
                            </div>
                        </div>
                        <button type="submit" id="seleccionarRecogidaBtn" class="aeropuerto-b" autocomplete="off">
                            Mostrar Coches</button>
                    </form>
                </div>
            </div>
            <div id="buscadorFechasLugares">
                <div id="rectanguloBuscarCiudadMovil">
                    <form method="POST" action="src/seleccionar_reserva.php" id="formFechas" class="formFechas">
                        <div class="search-wrapper">
                            <img src="img/Iconos/Lupa.svg" alt="Buscar">
                            <div class="inputWrapper">
                                <input type="text" id="ubicacionRecogida" class="aeropuerto inputBuscador <?php if (isset($_SESSION['errores_reserva']['ubicacionRecogida'])) echo 'campoInvalido'; ?>" name="ubicacionRecogida" autocomplete="off"
                                    data-sugerencias="sugerenciasSucursalRecogida"
                                    data-hidden-id="idSedeRecogida"
                                    placeholder="Aeropuerto, Ciudad, Estación..."
                                    value="<?php if (isset($_SESSION['periodo_reserva']['ubicacionRecogida'])) echo $_SESSION['periodo_reserva']['ubicacionRecogida']; ?>">
                                </input>

                                <div id="sugerenciasSucursalRecogida"></div>
                                <input type="hidden" id="idSedeRecogida" name="idSedeRecogida">

                                <?php
                                if (isset($_SESSION['errores_reserva']['ubicacionRecogida'])) {
                                    echo '<p class="error-message">' . $_SESSION['errores_reserva']['ubicacionRecogida'] . '</p>';
                                }
                                ?>
                            </div>
                            <img src="img/Iconos/Lupa.svg" alt="Buscar">
                            <input type="text" id="ubicacionDevolucion" class="aeropuerto inputBuscador <?php if (isset($_SESSION['errores_reserva']['ubicacionDevolucion'])) echo 'campoInvalido'; ?>" name="ubicacionDevolucion"
                                autocomplete="off" data-sugerencias="sugerenciasSucursalDevolucion" data-hidden-id="idSedeDevolucion" placeholder="Aeropuerto, Ciudad, Estación..."
                                value="<?php if (isset($_SESSION['periodo_reserva']['ubicacionDevolucion'])) echo $_SESSION['periodo_reserva']['ubicacionDevolucion']; ?>">
                            </input>

                            <?php
                            if (isset($_SESSION['errores_reserva']['ubicacionDevolucion'])) {
                                echo '<p class="error-message">' . $_SESSION['errores_reserva']['ubicacionDevolucion'] . '</p>';
                            }
                            ?>

                            <div id="sugerenciasSucursalDevolucion"></div>
                            <input type="hidden" id="idSedeDevolucion" name="idSedeDevolucion">

                        </div>


                        <!-- Inputs ocultos para enviar -->
                        <input type="hidden" name="fechaRecogida" id="fechaRecogida" value="<?php if (isset($_SESSION['periodo_reserva']['diaRecogida'])) echo $_SESSION['periodo_reserva']['diaRecogida']; ?>">
                        <input type="hidden" name="horaRecogida" id="horaRecogida">
                        <input type="hidden" name="fechaDevolucion" id="fechaDevolucion" value="<?php if (isset($_SESSION['periodo_reserva']['diaDevolucion'])) echo $_SESSION['periodo_reserva']['diaDevolucion']; ?>">
                        <input type="hidden" name="horaDevolucion" id="horaDevolucion">

                        <!-- Calendario visual -->
                        <div id="recogidaCuadroInicio">
                            <div onclick="abrirCalendario('recogidaCuadroInicio')"
                                class="<?php if (isset($_SESSION['errores_reserva']['fechaRecogida'])) echo 'campoInvalido'; ?>">
                                <img alt="Calendario" src="img/Iconos/Calendario.svg">
                                <span id="recogidaFechaTexto">
                                    <?php
                                    if (isset($_SESSION['periodo_reserva']['diaRecogida']))
                                        echo $_SESSION['periodo_reserva']['diaRecogida'];
                                    else
                                        echo 'Seleccionar fechas';
                                    ?>
                                </span>
                            </div>
                            <div id="linea2" class="linea"></div>
                            <div>
                                <input type="time" id="horaRecogidaInput"
                                    class="<?php if (isset($_SESSION['errores_reserva']['horaRecogida'])) echo 'campoInvalido'; ?>"
                                    min="07:00" max="21:00"
                                    name="horaRecogida"
                                    value="<?php if (isset($_SESSION['periodo_reserva']['horaRecogida'])) echo $_SESSION['periodo_reserva']['horaRecogida']; ?>">
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

                        <div id="devolucionCuadroInicio">
                            <div onclick="abrirCalendario('devolucionCuadroInicio')"
                                class="<?php if (isset($_SESSION['errores_reserva']['fechaDevolucion'])) echo 'campoInvalido'; ?>">
                                <img alt="Calendario" src="img/Iconos/Calendario.svg">
                                <span id="devolucionFechaTexto">
                                    <?php
                                    if (isset($_SESSION['periodo_reserva']['diaDevolucion']))
                                        echo $_SESSION['periodo_reserva']['diaDevolucion'];
                                    else
                                        echo 'Seleccionar fechas';
                                    ?>
                                </span>
                            </div>
                            <div id="linea3" class="linea"></div>
                            <div>
                                <input type="time" id="horaDevolucionInput"
                                    class="<?php if (isset($_SESSION['errores_reserva']['horaDevolucion'])) echo 'campoInvalido'; ?>"
                                    name="horaDevolucion"
                                    value="<?php if (isset($_SESSION['periodo_reserva']['horaDevolucion'])) echo $_SESSION['periodo_reserva']['horaDevolucion']; ?>"
                                    min="07:00" max="21:00">
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

                        <div id='linea4' class="linea"></div>
                        <button type="submit" id="seleccionarRecogidaBtn" class="aeropuerto-b" autocomplete="off">
                            Mostrar Coches</button>
                    </form>
                </div>
            </div>
        </div>
        <section id="seccion1">
            <h2 class="titulos">EXPLORA SIN LÍMITES, PAGA SIN PREOCUPACIONES</h2>
            <p>Alquiler de coches de calidad a precios accesibles. En toda España</p>
            <hr id="lineaNegra">
            <h2 class="titulos">EL COCHE PERFECTO PARA TU SIGUIENTE VIAJE TE ESTÁ ESPERANDO</h2>
            <ul id="lightSlider">
                <li><img src="img/Imagenes/Peugeot_208.png" alt="Imagen 1" class="coche"></li>
                <li><img src="img/Imagenes/BMW_serie_1.png" alt="Imagen 2" class="coche"></li>
                <li><img src="img/Imagenes/Volvo_EC40.png" alt="Imagen 3" class="coche"></li>
            </ul>

            <img src="img/Imagenes/Peugeot_208.png" alt="Imagen 1" class="coche imagenFija">
            <img src="img/Imagenes/BMW_serie_1.png" alt="Imagen 2" class="coche">
            <img src="img/Imagenes/Volvo_EC40.png" alt="Imagen 3" class="coche">
            <h2 class="titulos">ALQUILER DE COCHES EN ESPAÑA CON JOURNEY</h2>
            <p id="textoAlquiler">
                En Journey ofrecemos alquiler de coches en España, destacándonos por permitir la recogida y devolución
                en diferentes ciudades, brindando flexibilidad total a tus itinerarios. Nos enfocamos en ofrecer
                comodidad, confianza y un proceso de reserva sencillo, siempre con vehículos bien mantenidos.
            </p>
        </section>
    </main>

    <?php
    unset($_SESSION['errores_reserva']);
    ?>

</body>

</html>