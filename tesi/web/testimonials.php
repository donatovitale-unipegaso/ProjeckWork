<?php
session_start();

// Evita che il browser riproponga versioni cache-izzate
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

require 'db.php';

// Carica feedback
$stmt = $pdo->query("SELECT username, rating, comment, submitted_at FROM feedback ORDER BY submitted_at DESC");
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Messaggio di successo post-invio feedback (flash)
$feedback_success = $_SESSION['feedback_success'] ?? null;
unset($_SESSION['feedback_success']);
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Dicono di noi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">

  <script>
    // Anti back/forward cache
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
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="testimonials.php">Dicono di noi</a></li>
      </ul>

      <div class="d-flex gap-2">
        <?php if (empty($_SESSION['username'])): ?>
          <a href="login.php" class="btn btn-sm btn-outline-light">Accedi</a>
          <a href="register.php" class="btn btn-sm btn-primary">Registrati</a>
        <?php else: ?>
          <span class="badge rounded-pill text-light badge-username">
            <?= htmlspecialchars($_SESSION['username']) ?>
          </span>
          <a href="dashboard.php" class="btn btn-sm btn-primary">Dashboard</a>
          <a href="logout.php" class="btn btn-sm btn-outline-danger">Logout</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<main class="app-main">
  <section class="app-section">
    <div class="container">
      <div class="app-card">
        <div class="app-card-inner">
          <h2 class="app-title mb-1">Dicono di noi</h2>
          <p class="app-subtitle mb-4">
            Qui trovi una raccolta dei feedback lasciati dagli utenti dopo aver completato il quiz.
          </p>

          <?php if ($feedback_success): ?>
            <div class="alert alert-success">
              <?= htmlspecialchars($feedback_success) ?>
            </div>
          <?php endif; ?>

          <?php if (!empty($feedbacks)): ?>
            <div class="list-group">
              <?php foreach ($feedbacks as $fb): ?>
                <div class="list-group-item feedback-item mb-2">
                  <div class="d-flex justify-content-between align-items-start">
                    <div>
                      <strong><?= htmlspecialchars($fb['username']) ?></strong>
                      <div class="mb-1">
                        <?php
                          $rating = (int)$fb['rating'];
                          for ($i = 1; $i <= 5; $i++):
                        ?>
                          <span class="star"><?= $i <= $rating ? '★' : '☆' ?></span>
                        <?php endfor; ?>
                      </div>
                      <?php if (trim((string)$fb['comment']) !== ''): ?>
                        <p class="mb-1"><?= nl2br(htmlspecialchars($fb['comment'])) ?></p>
                      <?php endif; ?>
                    </div>
                    <small class="text-muted">
                      <?= date('d/m/Y H:i', strtotime($fb['submitted_at'])) ?>
                    </small>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <div class="alert alert-secondary">
              Non è ancora stato inserito alcun feedback. Sii il primo a lasciare un commento!
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
