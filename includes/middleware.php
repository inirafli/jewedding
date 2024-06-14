<?php
session_start();

function checkRole($role) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
        header('Location: /jewedding/login.php');
        exit();
    }
}
?>
