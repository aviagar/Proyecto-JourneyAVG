<?php
session_name("Journey");
session_start();
file_put_contents("debug_sesion_vista.txt", print_r($_SESSION, true));


require_once "funciones_CTES.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $nombreCompleto = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $clave = trim($_POST['clave'] ?? '');

    $errores = [];

    if (!$usuario) {
        $errores['usuario'] = "El nombre de usuario es obligatorio.";
    }

    if (!$nombreCompleto) {
        $errores['nombreCompleto'] = "El nombre completo es obligatorio.";
    }

    if (!$telefono) {
        $errores['telefono'] = "El teléfono es obligatorio.";
    }

    if (!$email) {
        $errores['email'] = "El correo electrónico es obligatorio.";
    }

    if (!$clave) {
        $errores['clave'] = "La contraseña es obligatoria.";
    }

    if (!empty($errores)) {
        $_SESSION['errores_formulario_editar_usuario'] = $errores;

        $_SESSION['old_datos'] = [
            'usuario' => $usuario,
            'nombreCompleto' => $nombreCompleto,
            'telefono' => $telefono,
            'email' => $email
        ];

        header("Location: /index.php?vista=vistaEditarUsuario");
        exit;
    }

    if ($_SESSION["datos_usuario_log"]["clave"] == md5($clave)) {

        $url = DIR_SERV . "/actualizarUsuario";
        $datos_env = [
            "id_usuario" => $_SESSION["datos_usuario_log"]["id_usuario"],
            "usuario" => $usuario,
            "nombre" => $nombreCompleto,
            "email" => $email,
            "telefono" => $telefono,
        ];

        $headers = ['Authorization: Bearer ' . $_SESSION["token"]];
        $respuesta = consumir_servicios_JWT_REST($url, "PUT",$headers, $datos_env);
        $json_actualizar = json_decode($respuesta, true);

        if (!$json_actualizar || isset($json_actualizar["error"])) {
            $_SESSION['error'] = $json_actualizar["error"] ?? "Error en el registro";
            header("Location: /index.php?vista=vistaEditarUsuario");
            exit;
        }

        if (isset($json_actualizar["mensaje"])) {
            $_SESSION['mensaje'] = $json_actualizar["mensaje"];
            header("Location: /index.php?vista=perfilUsuario");
            exit;
        }

        // Por si acaso
        $_SESSION['error'] = "No se pudo completar el registro";
        header("Location: /index.php?vista=registro");
        exit;
    } else {
        $_SESSION['clave_incorrecta'] = "La contraseña es incorrecta";
        header("Location: /index.php?vista=vistaEditarUsuario");
        exit;
    }
}
