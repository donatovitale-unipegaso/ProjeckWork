<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit;
        }
    }

    $_SESSION['login_error'] = "Credenziali non valide.";
    header("Location: login.php");
    exit;
} else {
    header("Location: login.php");
    exit;
}
