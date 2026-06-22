<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <title><?php echo SITENAME; ?></title>
  <style>
    html, body { height: 100%; }
    body { display: flex; flex-direction: column; }
    .content-wrapper { flex: 1 0 auto; }
    .footer { flex-shrink: 0; }
  </style>
</head>
<body>
  <div class="content-wrapper">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
  <div style="width: 96%; margin-left: 2%; margin-right: 2%;" class="d-flex align-items-center">
      <a class="navbar-brand me-3" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>

      <div class="collapse navbar-collapse d-lg-flex" id="navbarsExampleDefault">
        <ul class="navbar-nav me-auto">
          <?php if(isset($_SESSION['user_id'])) : ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="config" role="button" data-bs-toggle="dropdown" aria-expanded="false">Configuración</a>
              <ul class="dropdown-menu" aria-labelledby="config">
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/users">Usuarios</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/users/logout">Salir</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="objects" role="button" data-bs-toggle="dropdown" aria-expanded="false">Objetos</a>
              <ul class="dropdown-menu" aria-labelledby="objects">
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/servidores">Servidores</a></li>
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/basesdatos">Bases de Datos</a></li>
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/tablas">Tablas</a></li>
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/columnas">Columnas</a></li>
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/disparadores">Disparadores</a></li>
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/vistas">Vistas</a></li>
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/procedimientos">Procedimientos Almacenados</a></li>
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/funciones">Funciones</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/scripts">Scripts Aplicados</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="reports" role="button" data-bs-toggle="dropdown" aria-expanded="false">Reportes</a>
              <ul class="dropdown-menu" aria-labelledby="reports">
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/reportes/tablas">Diccionario de Datos</a></li>
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/reportes/objetos">Objetos Programables</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/reportes/scripts">Scripts Aplicados</a></li>
              </ul>
            </li>
          <?php endif; ?>
        </ul>

        <ul class="navbar-nav ms-auto">
          <?php if(isset($_SESSION['user_id'])) : ?>
          <li class="nav-item">
              <a class="nav-link disabled" href="#">Bienvenido <?php echo $_SESSION['user_name']; ?></a>
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
  <div style="width: 96%; margin-left: 2%; margin-right: 2%;">
