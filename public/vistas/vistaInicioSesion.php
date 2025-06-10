<!DOCTYPE html>
<html lang="en">

<body>
    <div id="contenedorFijo">
        <header class="header">
            <a href="<?= PUBLIC_PATH ?>index.php?vista=inicio">
                <img alt="salir" src="img/Iconos/Salir(X).svg" id="salir">
            </a>
            <div class="titulo">
                <span id="titulo">Inicio de sesion</span>
            </div>
        </header>
        <main>
            <div class="pagoFormulario">
                <form id="loginForm" method="post" action="<?= PUBLIC_PATH ?>src/login.php">
                    <div class="campoFormulario">
                        <input type="text" name="usuario" class="pagoInput <?php if (isset($_SESSION['errores_formulario_login']['usuario'])) echo 'campoInvalido'; ?>"
                            placeholder="Nombre de usuario" pattern="^[a-zA-Z0-9_-]{4,20}$"
                            title="Debe tener entre 4 y 20 caracteres. Solo letras, números, guiones y guiones bajos."
                            value="<?php echo $_SESSION['old_datos_login']['usuario'] ?? ''; ?>" required>
                        <?php
                        if (isset($_SESSION['errores_formulario_login']['usuario'])) {
                            echo '<p class="error-message">' . $_SESSION['errores_formulario_login']['usuario'] . '</p>';
                        }
                        ?>
                    </div>

                    <div class="campoFormulario">
                        <input type="password" name="clave" id="clave" class="pagoInput <?php if (isset($_SESSION['errores_formulario_login']['clave'])) echo 'campoInvalido'; ?>"
                            placeholder="Contraseña" title="Debe tener mínimo 8 caracteres, al menos una letra y un número" required>
                        <?php
                        if (isset($_SESSION['errores_formulario_login']['clave'])) {
                            echo '<p class="error-message">' . $_SESSION['errores_formulario_login']['clave'] . '</p>';
                        }
                        ?>
                    </div>

                    <?php
                    if (isset($_SESSION['errores_formulario_login']['general'])) {
                        echo '<p class="error-message general-error">' . $_SESSION['errores_formulario_login']['general'] . '</p>';
                    }
                    ?>

                    <div class="contenedorCentrado">
                        <span>¿No tiene cuenta?
                            <a href="<?= PUBLIC_PATH ?>index.php?vista=registro" class="subrayadoNegro">Regístrese</a>
                        </span>
                    </div>

                    <div class="contenedorCentrado">
                        <button type="submit" class="botonConfirmarCuadrado">Siguiente</button>
                    </div>
                </form>

                <?php
                unset($_SESSION['errores_formulario_login']);
                unset($_SESSION['old_datos_login']);
                ?>

            </div>

        </main>

    </div>
</body>


</html>