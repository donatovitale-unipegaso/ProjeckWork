<?php
session_start();

// Evita cache/riapparizioni di risultati precedenti
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Messaggio risultato (flash) mostrato una sola volta
$quiz_result = $_SESSION['quiz_result'] ?? null;
unset($_SESSION['quiz_result']);

require 'db.php';

// Carichiamo tutte le domande
$stmt = $pdo->query("SELECT id, question, option1, option2, option3, option4 FROM quiz_questions ORDER BY id");
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Quiz</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">

  <script>
    // Anti back/forward cache: se la pagina è ripristinata dalla cache, ricarica
    window.addEventListener('pageshow', function (e) { if (e.persisted) location.reload(); });
  </script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark app-navbar">
  <div class="container">
    <a class="navbar-brand" href="index.php">Security Training</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="testimonials.php">Dicono di noi</a></li>
      </ul>

      <div class="d-flex align-items-center gap-2">
        <span class="badge rounded-pill text-light badge-username">
          <?= htmlspecialchars($_SESSION['username']) ?>
        </span>
        <a href="logout.php" class="btn btn-sm btn-outline-danger">Logout</a>
      </div>
    </div>
  </div>
</nav>

<main class="app-main">
  <section class="app-section">
    <div class="container">
      <div class="app-card">
        <div class="app-card-inner">
          <h2 class="app-title mb-1">Quiz di consapevolezza</h2>
          <p class="app-subtitle mb-4">
            Rispondi alle domande scegliendo l’opzione corretta. Al termine verrai reindirizzato alla pagina
            dove potrai lasciare un feedback sull’esperienza.
          </p>

          <?php if (!empty($questions)): ?>
            <form action="quiz_action.php" method="post">
              <?php foreach ($questions as $q): ?>
                <div class="card quiz-card mb-3">
                  <div class="card-body">
                    <h5 class="card-title mb-1">
                      Domanda <?= (int)$q['id'] ?>
                    </h5>
                    <p class="card-text mb-3">
                      <?= htmlspecialchars($q['question']) ?>
                    </p>

                    <?php for ($i = 1; $i <= 4; $i++): ?>
                      <div class="form-check mb-1">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="q<?= (int)$q['id'] ?>"
                          id="q<?= (int)$q['id'] . '_' . $i ?>"
                          value="<?= $i ?>"
                          required
                        >
                        <label class="form-check-label" for="q<?= (int)$q['id'] . '_' . $i ?>">
                          <?= htmlspecialchars($q["option{$i}"]) ?>
                        </label>
                      </div>
                    <?php endfor; ?>
                  </div>
                </div>
              <?php endforeach; ?>

              <div class="d-flex flex-wrap gap-2 mt-3">
                <button type="submit" class="btn btn-success">
                  Invia risposte
                </button>
                <a href="<?= !empty($_SESSION['username']) ? 'dashboard.php' : 'index.php' ?>"
                   class="btn btn-outline-light">
                  Torna alla Home
                </a>
              </div>
            </form>
          <?php else: ?>
            <div class="alert alert-warning">
              Nessuna domanda disponibile nel database.
            </div>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </section>
</main>

<footer class="app-footer text-center py-3">
  &copy; <?= date('Y') ?> Security Training
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
