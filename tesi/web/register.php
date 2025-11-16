<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Registrati</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="text-center">Registrati</h2>

  <div class="row justify-content-center mt-4">
    <div class="col-md-4">

      <?php if (!empty($_SESSION['register_error'])): ?>
        <div class="alert alert-danger">
          <?= htmlspecialchars($_SESSION['register_error']) ?>
        </div>
        <?php unset($_SESSION['register_error']); ?>
      <?php endif; ?>

      <?php if (!empty($_SESSION['register_success'])): ?>
        <div class="alert alert-success">
          <?= htmlspecialchars($_SESSION['register_success']) ?>
        </div>
        <?php unset($_SESSION['register_success']); ?>
      <?php endif; ?>

      <form action="register_action.php" method="post">
        <div class="mb-3">
          <input type="text"
                 name="username"
                 class="form-control"
                 placeholder="Username"
                 required>
        </div>

        <div class="mb-3">
          <input type="email"
                 name="email"
                 class="form-control"
                 placeholder="Email"
                 required>
        </div>

        <div class="mb-3">
          <input type="password"
                 name="password"
                 class="form-control"
                 placeholder="Password"
                 required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Crea account</button>
      </form>

      <p class="text-center mt-3">
        Hai già un account? <a href="login.php">Accedi</a>
      </p>
    </div>
  </div>
</div>
</body>
</html>
