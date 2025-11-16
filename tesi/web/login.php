<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
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
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="testimonials.php">Dicono di noi</a></li>
      </ul>
      <div class="d-flex gap-2">
        <a href="register.php" class="btn btn-sm btn-outline-light">Registrati</a>
      </div>
    </div>
  </div>
</nav>

<main class="app-main">
  <section class="app-section">
    <div class="container" style="max-width: 480px;">
      <div class="app-card">
        <div class="app-card-inner app-form">
          <h2 class="app-title text-center mb-1">Accedi al portale</h2>
          <p class="app-subtitle text-center mb-4">
            Inserisci le tue credenziali per accedere all’area riservata.
          </p>

          <?php if (!empty($_SESSION['login_error'])): ?>
            <div class="alert alert-danger">
              <?= htmlspecialchars($_SESSION['login_error']) ?>
            </div>
            <?php unset($_SESSION['login_error']); ?>
          <?php endif; ?>

          <form action="login_action.php" method="post" novalidate>
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" placeholder="Inserisci username" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Inserisci password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
          </form>

          <p class="text-center mb-0">
            Non hai un account?
            <a href="register.php">Registrati</a><br>
            <a href="testimonials.php">Dicono di noi</a>
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
