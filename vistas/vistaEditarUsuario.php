<!DOCTYPE html>
<html lang="en">

<body>
    <div id="contenedorFijo">
        <header class="header">
            <a href="<?= PUBLIC_PATH ?>index.php?vista=inicio">
                <img alt="salir" src="img/Iconos/Salir(X).svg" id="salir">
            </a>
            <div class="titulo">
                <span id="titulo">Registro de usuario</span>
            </div>
        </header>

        <main>
            <div class="pagoFormulario">
                <form method="post" action="<?= PUBLIC_PATH ?>src/editarUsuario.php">
                    <div class="contenedorInputs">
                        <input type="text" name="nombre" class="inputRegistro <?php if (isset($_SESSION['errores_formulario_editar_usuario']['nombre'])) echo 'campoInvalido'; ?>"
                            placeholder="Nombre completo" pattern="^[A-Za-zÁÉÍÓÚÑáéíóúñ ]{2,50}$"
                            title="Debe contener solo letras y espacios, entre 2 y 50 caracteres."
                            value="<?php echo $_SESSION['datos_usuario_log']['nombre'] ?? ''; ?>" required>
                        <?php
                        if (isset($_SESSION['errores_formulario_editar_usuario']['nombre'])) {
                            echo '<p class="error-message">' . $_SESSION['errores_formulario_editar_usuario']['nombre'] . '</p>';
                        }
                        ?>

                        <input type="text" name="usuario" class="inputRegistro <?php if (isset($_SESSION['errores_formulario_editar_usuario']['usuario'])) echo 'campoInvalido'; ?>"
                            placeholder="Nombre de usuario" pattern="^[a-zA-Z0-9_-]{4,20}$"
                            title="Debe tener entre 4 y 20 caracteres. Solo letras, números, guiones y guiones bajos."
                            value="<?php echo $_SESSION['datos_usuario_log']['usuario'] ?? ''; ?>" required>
                        <?php
                        if (isset($_SESSION['errores_formulario_editar_usuario']['usuario'])) {
                            echo '<p class="error-message">' . $_SESSION['errores_formulario_editar_usuario']['usuario'] . '</p>';
                        }
                        ?>

                        <input type="tel" name="telefono" class="inputRegistro <?php if (isset($_SESSION['errores_formulario_editar_usuario']['telefono'])) echo 'campoInvalido'; ?>"
                            placeholder="Teléfono" pattern="^[0-9]{9}$"
                            title="Debe contener exactamente 9 dígitos."
                            value="<?php echo $_SESSION['datos_usuario_log']['telefono'] ?? ''; ?>" required>
                        <?php
                        if (isset($_SESSION['errores_formulario_editar_usuario']['telefono'])) {
                            echo '<p class="error-message">' . $_SESSION['errores_formulario_editar_usuario']['telefono'] . '</p>';
                        }
                        ?>

                        <input type="email" name="email" class="inputRegistro <?php if (isset($_SESSION['errores_formulario_editar_usuario']['email'])) echo 'campoInvalido'; ?>"
                            placeholder="Correo electrónico" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,7}$"
                            title="Ingrese un correo válido, ejemplo: usuario@ejemplo.com"
                            value="<?php echo $_SESSION['datos_usuario_log']['email'] ?? ''; ?>" required>
                        <?php
                        if (isset($_SESSION['errores_formulario_editar_usuario']['email'])) {
                            echo '<p class="error-message">' . $_SESSION['errores_formulario_editar_usuario']['email'] . '</p>';
                        }
                        ?>

                        <input type="password" name="clave" class="inputRegistro <?php if (isset($_SESSION['errores_formulario_editar_usuario']['clave'])) echo 'campoInvalido'; ?>"
                            placeholder="Contraseña" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$"
                            title="Debe tener mínimo 8 caracteres, al menos una letra y un número" required>
                        <?php
                        if (isset($_SESSION['errores_formulario_editar_usuario']['clave'])) {
                            echo '<p class="error-message">' . $_SESSION['errores_formulario_editar_usuario']['clave'] . '</p>';
                        }
                        ?>
                    </div>

                    <div class="contenedorCentrado">
                        <button type="submit" class="botonConfirmarCuadrado">Siguiente</button>
                    </div>
                </form>

                <?php
                if (isset($_SESSION['clave_incorrecta'])) {
                    echo '<p class="error-message">' . $_SESSION['clave_incorrecta'] . '</p>';
                    unset($_SESSION['clave_incorrecta']);
                }
                ?>
            </div>
        </main>

    </div>
</body>


</html>

<?php
unset($_SESSION['errores_formulario_editar_usuario']);
unset($_SESSION['old_datos']);
?>