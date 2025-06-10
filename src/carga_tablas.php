<form method="post">
    <label for="tabla_admin">Selecciona una tabla:</label>
    <select name="tabla_admin" id="tabla_admin" onchange="this.form.submit()">
        <option disabled <?= !isset($_POST["tabla_admin"]) ? "selected" : "" ?>>-- Elige una tabla --</option>
        <option value="reservas" <?= ($_POST["tabla_admin"] ?? '') === 'reservas' ? 'selected' : '' ?>>Reservas</option>
        <option value="vehiculos" <?= ($_POST["tabla_admin"] ?? '') === 'vehiculos' ? 'selected' : '' ?>>Vehiculos</option>
        <option value="sedes" <?= ($_POST["tabla_admin"] ?? '') === 'sedes' ? 'selected' : '' ?>>Sedes</option>
    </select>
</form>

<?php
require_once "funciones_CTES.php";

if (isset($_POST["tabla_admin"])) {
    $endpoint = match ($_POST["tabla_admin"]) {
        "reservas" => "/reservas",
        "vehiculos" => "/vehiculos",
        "sedes" => "/sedes",
        default => null
    };

    if ($endpoint) {
        $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
        $respuesta = consumir_servicios_JWT_REST(DIR_SERV . $endpoint, "GET", $headers);
        $json = json_decode($respuesta, true);
        if (isset($json["error"])) {
            echo "<p class='error'>" . htmlspecialchars($json["error"]) . "</p>";
        } elseif (!empty($json["datos"])) {
            echo "<table border='1'><thead><tr>";
            foreach (array_keys($json["datos"][0]) as $columna) {
                echo "<th>" . htmlspecialchars($columna) . "</th>";
            }
            echo "<th>Acciones</th></tr></thead><tbody>";

            foreach ($json["datos"] as $fila) {
                $clave_id = array_key_first($fila);
                $valor_id = $fila[$clave_id];

                // Fila en modo edición
                if (isset($_POST["accion"], $_POST["id"]) && $_POST["accion"] === "editar" && $_POST["id"] == $valor_id) {
                    echo "<tr><form method='post' action='src/acciones_admin.php'>";
                    foreach ($fila as $campo => $valor) {
                        echo "<td><input type='text' name='" . htmlspecialchars($campo) . "' value='" . htmlspecialchars($valor) . "'></td>";
                    }
                    echo "<td>
                        <input type='hidden' name='accion' value='guardar_edicion'>
                        <input type='hidden' name='id' value='" . htmlspecialchars($valor_id) . "'>
                        <input type='hidden' name='tabla' value='" . htmlspecialchars($_POST["tabla_admin"]) . "'>
                        <button type='submit'>Guardar</button>
                    </td></form></tr>";
                } else {
                    echo "<tr>";
                    foreach ($fila as $valor) {
                        echo "<td>" . htmlspecialchars($valor) . "</td>";
                    }
                    echo "<td>
                        <form method='post' style='display:inline'>
                            <input type='hidden' name='accion' value='editar'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($valor_id) . "'>
                            <input type='hidden' name='tabla_admin' value='" . htmlspecialchars($_POST["tabla_admin"]) . "'>
                            <button type='submit'>Editar</button>
                        </form>
                        <form method='post' action='src/acciones_admin.php' style='display:inline' onsubmit='return confirm(\"¿Eliminar este registro?\");'>
                            <input type='hidden' name='accion' value='eliminar'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($valor_id) . "'>
                            <input type='hidden' name='tabla' value='" . htmlspecialchars($_POST["tabla_admin"]) . "'>
                            <button type='submit'>Eliminar</button>
                        </form>
                    </td></tr>";
                }
            }

            // Fila para insertar nuevo registro
            echo "<tr><form method='post' action='src/acciones_admin.php'>";
            foreach (array_keys($json["datos"][0]) as $columna) {
                echo "<td><input type='text' name='" . htmlspecialchars($columna) . "'></td>";
            }
            echo "<td>
                <input type='hidden' name='accion' value='insertar'>
                <input type='hidden' name='tabla' value='" . htmlspecialchars($_POST["tabla_admin"]) . "'>
                <button type='submit'>Insertar</button>
            </td></form></tr>";

            echo "</tbody></table>";
        } else {
            echo "<p>No hay datos en la tabla seleccionada.</p>";
        }
    }
}

if (isset($_SESSION["mensaje_error"])) {
    echo "<p class='error'>" . $_SESSION["mensaje_error"] . "</p>";
    unset($_SESSION["mensaje_error"]);
}
if (isset($_SESSION["mensaje_info"])) {
    echo "<p class='info'>" . $_SESSION["mensaje_info"] . "</p>";
    unset($_SESSION["mensaje_info"]);
}
?>