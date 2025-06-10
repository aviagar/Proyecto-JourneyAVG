<?php
session_name("Journey");
session_start();

require_once "funciones_CTES.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $nombreCompleto = trim($_POST['nombreCompleto'] ?? '');
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
        $_SESSION['errores_formulario_registro'] = $errores;

        $_SESSION['old_datos'] = [
            'usuario' => $usuario,
            'nombreCompleto' => $nombreCompleto,
            'telefono' => $telefono,
            'email' => $email
        ];

        header("Location: index.php?vista=registro");
        exit;
    }



    $url = DIR_SERV . "/registro";
    $datos_env = [
        "usuario" => $usuario,
        "nombreCompleto" => $nombreCompleto,
        "email" => $email,
        "telefono" => $telefono,
        "clave" => md5($clave)
    ];

    $respuesta = consumir_servicios_REST($url, "POST", $datos_env);
    $json_registro = json_decode($respuesta, true);

    if (!$json_registro || isset($json_registro["error"])) {
        $_SESSION['error'] = $json_registro["error"] ?? "Error en el registro";
        header("Location: index.php?vista=registro");
        exit;
    }

    if (isset($json_registro["usuario_existente"])) {
        $_SESSION['error'] = $json_registro["usuario_existente"];
        header("Location: index.php?vista=registro");
        exit;
    }

    if (isset($json_registro["mensaje"])) {
        $_SESSION['mensaje'] = $json_registro["mensaje"];
        header("Location: index.php?vista=inicioSesion");
        exit;
    }

    // Por si acaso
    $_SESSION['error'] = "No se pudo completar el registro";
    header("Location: index.php?vista=registro");
    exit;
}
