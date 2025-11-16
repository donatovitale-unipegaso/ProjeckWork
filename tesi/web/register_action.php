<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: register.php");
    exit;
}

$username = trim($_POST['username'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $email === '' || $password === '') {
    $_SESSION['register_error'] = "Compila tutti i campi.";
    header("Location: register.php");
    exit;
}

// Controllo formato email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['register_error'] = "Inserisci un'email valida.";
    header("Location: register.php");
    exit;
}

try {
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT INTO users (username, email, password)
        VALUES (:username, :email, :password)
    ");
    $stmt->execute([
        ':username' => $username,
        ':email'    => $email,
        ':password' => $hash,
    ]);

    $_SESSION['register_success'] = "Registrazione completata. Ora puoi effettuare il login.";
} catch (PDOException $e) {
    // 23505 = unique_violation (username o email già usati)
    if ($e->getCode() === '23505') {
        $_SESSION['register_error'] = "Username o email già esistenti.";
    } else {
        $_SESSION['register_error'] = "Errore durante la registrazione. Riprova.";
    }
}

header("Location: register.php");
exit;
