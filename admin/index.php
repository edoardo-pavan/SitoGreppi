<?php
// admin/index.php - Punto di ingresso della dashboard
session_start();

// Se non autenticato, redirect a login
if (!isset($_SESSION['autenticato']) || $_SESSION['autenticato'] !== true) {
    header('Location: login.php');
    exit();
}

// Se autenticato, redirect a dashboard
header('Location: dashboard.php');
exit();
?>