<?php
session_start();

// Evita cache/riapparizioni
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// In questa pagina voglio SOLO il form (non il messaggio di successo post-invio)
unset($_SESSION['feedback_success']);

$feedback_score = $_SESSION['feedback_score'] ?? null;
unset($_SESSION['feedback_score']);


// Recupero eventuali valori precedenti (in caso di errore di validazione)
$old_comment = $_SESSION['feedback_old_comment'] ?? '';
$old_rating  = $_SESSION['feedback_old_rating'] ?? '';
// Li tolgo (flash)
unset($_SESSION['feedback_old_comment'], $_SESSION['feedback_old_rating']);
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Lascia un feedback</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">

  <script>
    // Anti back/forward cache
    window.addEventListener('pageshow', e => { if (e.persisted) location.reload(); });
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
    <div class="container" style="max-width: 600px;">
      <div class="app-card">
        <div class="app-card-inner app-form">
          <h2 class="app-title mb-1">Lascia un feedback</h2>
          <p class="app-subtitle mb-4">
            Il tuo parere ci aiuta a migliorare la qualità del quiz e dei contenuti formativi.
          </p>

          <?php if ($feedback_score): ?>
            <div class="alert alert-info text-center">
          <?= htmlspecialchars($feedback_score) ?>
           </div>
          <?php endif; ?>


          <?php if (!empty($_SESSION['feedback_error'])): ?>
            <div class="alert alert-danger">
              <?= htmlspecialchars($_SESSION['feedback_error']) ?>
            </div>
            <?php unset($_SESSION['feedback_error']); ?>
          <?php endif; ?>

          <form action="feedback_submit.php" method="post" novalidate>
            <div class="mb-3">
              <label class="form-label d-block mb-2">Valutazione</label>
              <div class="rating">
                <?php for ($i = 5; $i >= 1; $i--): ?>
                  <input
                    type="radio"
                    id="star<?= $i ?>"
                    name="rating"
                    value="<?= $i ?>"
                    <?= ((int)$old_rating === $i) ? 'checked' : '' ?>
                  >
                  <label for="star<?= $i ?>">★</label>
                <?php endfor; ?>
              </div>
              <div class="form-text mt-1">
                1 = molto insoddisfatto, 5 = molto soddisfatto.
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Commento (opzionale)</label>
              <textarea
                name="comment"
                class="form-control"
                rows="3"
                placeholder="Aggiungi un commento..."
              ><?= htmlspecialchars($old_comment) ?></textarea>
            </div>

            <div class="d-flex flex-wrap gap-2">
              <button type="submit" class="btn btn-primary">
                Invia feedback
              </button>
              <a href="<?= !empty($_SESSION['username']) ? 'dashboard.php' : 'index.php' ?>"
                 class="btn btn-outline-light">
                Torna alla Home
              </a>
            </div>
          </form>
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
