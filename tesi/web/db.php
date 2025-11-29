<?php
// Legge le variabili d'ambiente (sia in locale che su Render)
$host    = getenv('DB_HOST') ?: 'localhost';
$db      = getenv('DB_NAME') ?: 'tesi';
$user    = getenv('DB_USER') ?: 'postgres';
$pass    = getenv('DB_PASS') ?: 'postgres';
$port    = getenv('DB_PORT') ?: '5432';      // default 5432
$sslmode = getenv('DB_SSLMODE');             // su Render sarà "require"

// Costruisce il DSN per PDO
$dsn = "pgsql:host=$host;port=$port;dbname=$db";
if ($sslmode) {
    $dsn .= ";sslmode=$sslmode";
}

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $e) {
    die("Errore connessione DB: " . $e->getMessage());
}
?>
