<!DOCTYPE html>
<html lang="en">

<body>
    <div class="header">

        <div class="titulo">
            <span id="titulo">Coches para su viaje</span>
        </div>
    </div>

    <main>
        <?php
        if (isset($_SESSION['periodo_reserva']['ubicacionRecogida'])) {
        ?>
            <a id="editarReserva">
                <nav class="volverDetalles">
                    <span><?php echo $_SESSION['periodo_reserva']['ubicacionRecogida'];
                            if (isset($_SESSION['periodo_reserva']['ubicacionDevolucion'])) echo ' - ' . $_SESSION['periodo_reserva']['ubicacionDevolucion'] ?></span>
                    <img alt="editar" src="img/Iconos/LapizEditar.svg" id="editar">
                    <span class="subtitulo">
                        <?php
                        $fechaRecogidaFormateada = date("d M", strtotime($_SESSION["periodo_reserva"]["diaRecogida"]));
                        $fechaDevolucionFormateada = date("d M", strtotime($_SESSION["periodo_reserva"]["diaDevolucion"]));

                        echo "{$fechaRecogidaFormateada} | {$_SESSION["periodo_reserva"]["horaRecogida"]} - {$fechaDevolucionFormateada} | {$_SESSION["periodo_reserva"]["horaDevolucion"]}";
                        ?>
                    </span>

                    

                </nav>
            </a>
        <?php
        }
        ?>

        <?php
        require "constructores/contructor_coche.php";
        ?>

    </main>
    </div>
</body>

</html>