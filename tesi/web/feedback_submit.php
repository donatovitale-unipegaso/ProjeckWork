<?php
session_start();

// Evita cache su risposte intermedie 
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

require 'db.php';

$username = $_SESSION['username'];
$comment  = trim($_POST['comment'] ?? '');
$rating   = $_POST['rating'] ?? null;

// Validazione rating (1-5)
if ($rating === null || !ctype_digit((string)$rating) || (int)$rating < 1 || (int)$rating > 5) {
    $_SESSION['feedback_error'] = "Seleziona da 1 a 5 stelle.";
    $_SESSION['feedback_old_comment'] = $comment;
    $_SESSION['feedback_old_rating']  = (int)($rating ?? 0);
    header("Location: feedback.php"); // torna al form con errore
    exit;
}
$rating = (int)$rating;

// Inserimento
try {
    $stmt = $pdo->prepare("INSERT INTO feedback (username, rating, comment) VALUES (?, ?, ?)");
    $stmt->execute([$username, $rating, $comment]);

    // Successo: porta l’utente alla lista (testimonials) e mostra un messaggio lì
    $_SESSION['feedback_success'] = "Grazie! Il tuo feedback è stato inviato.";
    unset($_SESSION['feedback_old_comment'], $_SESSION['feedback_old_rating']);
    header("Location: testimonials.php");
    exit;

} catch (PDOException $e) {
    // Es. vincoli DB
    $_SESSION['feedback_error'] = "Errore nel salvataggio del feedback. Riprova.";
    $_SESSION['feedback_old_comment'] = $comment;
    $_SESSION['feedback_old_rating']  = (int)$rating;
    header("Location: feedback.php");
    exit;
}
