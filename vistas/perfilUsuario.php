<!DOCTYPE html>
<html lang="en">

<body>
    <div id="contenedorFijo">
        <header class="header">
            <div class="contenedorCentrado">
                <img alt="lupa" src='img/Iconos/UsuarioIniciado.svg' id="iconoSesIniciada">
            </div>
        </header>

        <main>

            <h1 class="titulos">Bienvenido <?= $_SESSION["datos_usuario_log"]["nombre"] ?></h1>
            <form action="<?= PUBLIC_PATH ?>index.php?vista=vistaEditarUsuario" method="post" class="pagoFormulario">
                <div class="contenedorCentrado">
                    <button type="submit" name="accion" value="editarDatos" class="pagoInput">
                        Editar datos personales
                    </button>
                </div>
            </form>

            <form action="<?= PUBLIC_PATH ?>index.php?vista=vistaReservas" method="post" class="pagoFormulario">
                <div class="contenedorCentrado">
                    <button type="submit" name="accion" value="gestionarReservas" class="pagoInput">
                        Gestionar mis reservas
                    </button>
                </div>
            </form>

            <form action="index.php" method="post" class="pagoFormulario">
                <div class="contenedorCentrado">
                    <button type="submit" name="btnCerrarSession" value="cerrarSesion" class="pagoInput cerrar">
                        Cerrar sesión
                    </button>
                </div>
            </form>

            <form action="index.php" method="post" class="pagoFormulario">
                <div class="contenedorCentrado">
                    <button type="submit" name="btnSalir" value="salir" class="botonConfirmarCuadrado">
                        Salir
                    </button>
                </div>
            </form>

        </main>

    </div>
</body>


</html>