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
            <form action="index.php" method="post" class="pagoFormulario">

                <div class="contenedorCentrado">
                    <button type="submit" name="accion" value="editarDatos" class="pagoInput">
                        Editar datos personales
                    </button>
                </div>

                <div class="contenedorCentrado">
                    <button type="submit" name="accion" value="cambiarContrasena" class="pagoInput">
                        Cambiar contraseña
                    </button>
                </div>

                <div class="contenedorCentrado">
                    <button type="submit" name="accion" value="historialReservas" class="pagoInput">
                        Historial de reservas
                    </button>
                </div>

                <div class="contenedorCentrado">
                    <button type="submit" name="btnCerrarSession" value="cerrarSesion" class="pagoInput cerrar">
                        Cerrar sesión
                    </button>
                </div>

                <div class="contenedorCentrado">
                    <button type="submit" name="accion" value="darBaja" class="pagoInput cerrar">
                        Darme de baja
                    </button>
                </div>

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