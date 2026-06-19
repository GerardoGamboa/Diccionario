<?php require APPROOT . '/views/inc/header.php'; ?>
  <a href="<?php echo URLROOT; ?>/users" class="btn btn-light"><i class="fa fa-backward"></i> Volver</a>
  <div class="card card-body bg-light mt-5">
    <h2>Agregar Usuario</h2>
    <p>Cree un nuevo usuario para el sistema</p>
    <form action="<?php echo URLROOT; ?>/users/add" method="post">
      <div class="mb-3">
        <label for="name">Nombre: <sup>*</sup></label>
        <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
        <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
      </div>
      <div class="mb-3">
        <label for="email">Email: <sup>*</sup></label>
        <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
      </div>
      <div class="mb-3">
        <label for="password">Contraseña: <sup>*</sup></label>
        <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
      </div>
      <div class="mb-3">
        <label for="confirm_password">Confirmar Contraseña: <sup>*</sup></label>
        <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>">
        <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
      </div>
      <input type="submit" class="btn btn-success" value="Guardar">
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
