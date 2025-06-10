<?php
session_name("Journey");
session_start();

require_once "funciones_CTES.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $clave = trim($_POST['clave'] ?? '');

    $errores = [];

    if (!$usuario) {
        $errores['usuario'] = "El nombre de usuario es obligatorio.";
    }

    if (!$clave) {
        $errores['clave'] = "La contraseña es obligatoria.";
    }

    if (!empty($errores)) {
        $_SESSION['errores_formulario_login'] = $errores;
        $_SESSION['old_datos_login'] = [
            'usuario' => $usuario
        ];
        header("Location: /index.php?vista=inicioSesion");
        exit;
    }

    $url = DIR_SERV . "/login";
    $datos_env = ["usuario" => $usuario, "clave" => md5($clave)];

    $respuesta = consumir_servicios_REST($url, "POST", $datos_env);
    $json_login = json_decode($respuesta, true);

    if (!$json_login || isset($json_login["error"])) {
        $_SESSION['errores_formulario_login'] = ['general' => $json_login["error"] ?? "Error en el login"];
        $_SESSION['old_datos_login'] = ['usuario' => $usuario];
        header("Location: /index.php?vista=inicioSesion");
        exit;
    }

    if (isset($json_login["usuario"])) {
        $_SESSION["ultm_accion"] = time();
        $_SESSION["token"] = $json_login["token"];
        $_SESSION["datos_usuario_log"] = $json_login["usuario"];

        if ($_SESSION["datos_usuario_log"]["tipo"] == "admin") {
            header("Location: /index.php?vista=vistaAdmin");
            exit;
        }

        if ((isset($_SESSION["periodo_reserva"]["ubicacionRecogida"])) && (isset($_SESSION["coche_seleccionado"])) && (isset($_SESSION["periodo_reserva"]["plan"]))) {
            header("Location: /index.php?vista=pago");
            exit;
        } else {
            header("Location: /index.php?vista=perfilUsuario");
            exit;
        }
    }

    $_SESSION['errores_formulario_login'] = ['general' => "Usuario o contraseña incorrectos"];
    $_SESSION['old_datos_login'] = ['usuario' => $usuario];
    header("Location: /index.php?vista=inicioSesion");
    exit;
}
