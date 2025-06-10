<?php
session_name("Journey");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['plan'])) {
    $_SESSION['periodo_reserva']['plan'] = $_POST['plan'];
    
    if ($_SESSION['periodo_reserva']['plan'] === 'basico') {
        $_SESSION['periodo_reserva']['total_reserva'] = $_SESSION['periodo_reserva']['total_reserva'] + 80;
    }elseif ($_SESSION['periodo_reserva']['plan'] === 'extra') {
        $_SESSION['periodo_reserva']['total_reserva'] = $_SESSION['periodo_reserva']['total_reserva'] + 150;
    } else {
        $_SESSION['periodo_reserva']['total_reserva'] = $_SESSION['periodo_reserva']['total_reserva'] + 300;
    }

    if (isset($_SESSION["token"])) {
            header("Location: index.php?vista=pago");
            exit;
        } else {
            header("Location: index.php?vista=perfilUsuario");
            exit;
        }
}
