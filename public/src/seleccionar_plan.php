<?php
session_name("Journey");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['plan'])) {

    $_SESSION['periodo_reserva']['plan'] = $_POST['plan'];

    if (isset($_SESSION["token"])) {
            header("Location: /JOURNEY/public/index.php?vista=pago");
            exit;
        } else {
            header("Location: /JOURNEY/public/index.php?vista=perfilUsuario");
            exit;
        }
}
