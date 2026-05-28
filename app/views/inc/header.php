<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <title><?php echo SITENAME; ?></title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
  <div class="container">
      <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav me-auto">
          <?php if(isset($_SESSION['user_id'])) : ?>
            <li class="nav-item"><a class="nav-link" href="<?php echo URLROOT; ?>/servidores">Servidores</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URLROOT; ?>/basesdatos">BDs</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URLROOT; ?>/tablas">Tablas</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URLROOT; ?>/columnas">Columnas</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="others" role="button" data-bs-toggle="dropdown" aria-expanded="false">Otros</a>
              <ul class="dropdown-menu" aria-labelledby="others">
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/vistas">Vistas</a></li>
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/procedimientos">Procedimientos</a></li>
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/funciones">Funciones</a></li>
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/disparadores">Disparadores</a></li>
              </ul>
            </li>
          <?php endif; ?>
        </ul>

        <ul class="navbar-nav ms-auto">
          <?php if(isset($_SESSION['user_id'])) : ?>
          <li class="nav-item">
              <a class="nav-link" href="#">Bienvenido <?php echo $_SESSION['user_name']; ?></a>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">Logout</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Login</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
