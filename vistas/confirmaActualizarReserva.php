<!DOCTYPE html>
<html lang="en">

<body>
    <div id="contenedorFijo">
        <header class="header">
            <div class="titulo">
                <h2 class="pagoTitulo">Reserva actualizada</h2>
            </div>
        </header>

        <main>
            <div class="contenedorCentrado" id='textoReserva'>
                <span class="pagoInput" id="confirmacionInput">En unos dias recibira los detalles por correo electronico</span>
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