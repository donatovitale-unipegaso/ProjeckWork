<?php
$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
} catch (PDOException $e) {
    die("Errore connessione DB: " . $e->getMessage());
}
?>