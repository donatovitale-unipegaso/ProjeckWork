<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Benvenuto</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- CSS personalizzato -->
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
        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="testimonials.php">Dicono di noi</a></li>
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
      <div class="row justify-content-center align-items-center g-4">
        <div class="col-lg-7">
          <div class="app-card">
            <div class="app-card-inner text-center text-lg-start">
              <button class="btn btn-soft mb-3" type="button">
                Formazione &amp; consapevolezza sulla sicurezza
              </button>

              <h1 class="hero-title mb-3">
                Valuta le conoscenze del personale
                <span class="hero-highlight">in modo semplice e guidato.</span>
              </h1>

              <p class="hero-subtitle mb-4">
                Una piattaforma pensata per aziende che vogliono misurare il livello di consapevolezza
                sui temi della sicurezza sul lavoro, raccogliere feedback e migliorare i propri percorsi
                di formazione interna.
              </p>

              <div class="hero-actions d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                <?php if (empty($_SESSION['username'])): ?>
                  <a href="register.php" class="btn btn-primary btn-lg">
                    Inizia ora
                  </a>
                  <a href="testimonials.php" class="btn btn-outline-light btn-lg">
                    Vedi cosa dicono gli utenti
                  </a>
                <?php else: ?>
                  <a href="dashboard.php" class="btn btn-primary btn-lg">
                    Vai alla Dashboard
                  </a>
                  <a href="testimonials.php" class="btn btn-outline-light btn-lg">
                    Dicono di noi
                  </a>
                <?php endif; ?>
              </div>

              <p class="mt-4 mb-0 text-secondary small">
                Nessuna installazione sul client: tutto viene eseguito in ambiente isolato
                tramite container Docker e database PostgreSQL.
              </p>
            </div>
          </div>
        </div>

        <div class="col-lg-5 d-none d-lg-block">
          <div class="app-card h-100">
            <div class="app-card-inner d-flex flex-column justify-content-center h-100">
              <h2 class="app-title mb-3">Cosa puoi fare</h2>
              <ul class="list-unstyled mb-0">
                <li class="mb-2">• Erogare un quiz strutturato sulla sicurezza sul lavoro.</li>
                <li class="mb-2">• Raccogliere i punteggi dei partecipanti.</li>
                <li class="mb-2">• Lasciare e consultare feedback con valutazione a stelle.</li>
                <li>• Scaricare documentazione messa a disposizione dall’azienda.</li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</main>

<footer class="app-footer text-center py-3">
  &copy; <?= date('Y') ?> Security Training – Progetto dimostrativo
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
