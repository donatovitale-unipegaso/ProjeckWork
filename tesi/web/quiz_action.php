<?php
session_start();

// Evita cache intermedia
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

require 'db.php';

$username = $_SESSION['username'];

// Carico le risposte corrette dal DB
$stmt = $pdo->query("SELECT id, correct_option FROM quiz_questions ORDER BY id");
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$correctMap = [];
foreach ($questions as $q) {
    $correctMap[(int)$q['id']] = (int)$q['correct_option'];
}

$score = 0;
$total = 0;

// Scorro tutte le risposte inviate dal form
foreach ($_POST as $key => $answer) {
    if (preg_match('/^q(\d+)$/', $key, $matches)) {
        $qid = (int)$matches[1];

        if (isset($correctMap[$qid])) {
            $total++;

            $given = (int)$answer; // 1..4
            if ($given === $correctMap[$qid]) {
                $score++;
            }
        }
    }
}

// Se non ci sono domande conteggiate, evito insert "strane"
if ($total > 0) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO quiz_results (username, score, total_questions)
            VALUES (:username, :score, :total)
        ");
        $stmt->execute([
            ':username' => $username,
            ':score'    => $score,
            ':total'    => $total,
        ]);
    } catch (PDOException $e) {
        // In caso di errore non blocco l'utente, logica minimale:
    }
}

$_SESSION['feedback_score'] = "Hai totalizzato $score su $total.";
header("Location: feedback.php");
exit;

