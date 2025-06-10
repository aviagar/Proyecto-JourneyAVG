<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Journey - Admin</title>
</head>

<body>
    <h1>Panel de Administración</h1>
    <div class="contenedorCentrado">
        <?php require "src/carga_tablas.php"; ?>

        <form action="index.php" method="post" class="pagoFormulario">
            <div class="contenedorCentrado">
                <button type="submit" name="btnCerrarSession" value="cerrarSesion" class="pagoInput cerrar">
                    Cerrar sesión
                </button>
            </div>
        </form>
    </div>
</body>

</html>