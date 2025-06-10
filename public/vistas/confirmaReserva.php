<!DOCTYPE html>
<html lang="en">

<body>
    <div id="contenedorFijo">
        <header class="header">
            <div class="titulo">
                <h2 class="pagoTitulo">¡MUCHAS GRACIAS POR SU RESERVA!</h2>
            </div>
        </header>

        <main>
            <div class="contenedorCentrado" id='textoReserva'>

                <span class="pagoInput" id="confirmacionInput">Podrá gestionar su reserva en el apartado de
                    su perfil del menu principal</span>

            </div>
            <div class="contenedorCentrado">
                <a  href="<?= PUBLIC_PATH ?>index.php?vista=perfilUsuario" class="botonConfirmarCuadrado">
                    VER TU RESERVA
                </a>
            </div>
            <div class="contenedorCentrado">
                <a  href="<?= PUBLIC_PATH ?>index.php?vista=inicio" class="botonConfirmarCuadrado">
                    VOLVER AL INICIO
                </a>
            </div>

        </main>

    </div>
</body>

<?php
unset($_SESSION['reserva_completada']);
?>
</html>