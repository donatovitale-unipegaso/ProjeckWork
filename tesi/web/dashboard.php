<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Area Riservata</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
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
        <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
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
          <h2 class="app-title mb-1">Benvenuto nell’area riservata</h2>
          <p class="app-subtitle mb-4">
            Da qui puoi scaricare la documentazione, avviare il quiz e successivamente lasciare un feedback.
          </p>

          <div class="row g-4">
            <div class="col-md-6">
              <div class="dashboard-card p-4 border rounded-3 h-100">
                <h3 class="mb-2">Sezione documentazione</h3>
                <p class="text-secondary mb-3">
                  Scarica il documento informativo messo a disposizione dall’azienda:
                </p>
                <a href="download/Guida_al_Calcolo_del_Fattore_di_Rischio_nella_Sicurezza_Aziendale.pdf"
                   class="btn btn-primary"
                   download="Guida_sicurezza.pdf">
                   Scarica documento
                </a>
              </div>
            </div>

            <div class="col-md-6">
              <div class="dashboard-card p-4 border rounded-3 h-100">
                <h3 class="mb-2">Quiz di consapevolezza</h3>
                <p class="text-secondary mb-3">
                  Metti alla prova le tue conoscenze:
                </p>
                <a href="quiz.php" class="btn btn-warning">
                  Avvia il quiz
                </a>
              </div>
            </div>
          </div>

          <hr class="my-4">

          <p class="text-secondary mb-0">
            Al termine del quiz potrai lasciare un feedback con valutazione a stelle:
            questo aiuta a migliorare i contenuti formativi nel tempo.
          </p>
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
