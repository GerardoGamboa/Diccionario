<?php require APPROOT . '/views/inc/header.php'; ?>
  <a href="<?php echo URLROOT; ?>/diccionario" class="btn btn-light"><i class="fa fa-backward"></i> Volver</a>
  <div class="card card-body bg-light mt-5">
    <h2>Agregar Objeto al Diccionario</h2>
    <p>Crea un nuevo objeto para el control del DBA</p>
    <form action="<?php echo URLROOT; ?>/diccionario/add" method="post">
      <div class="mb-3">
        <label for="nombre">Nombre: <sup>*</sup></label>
        <input type="text" name="nombre" class="form-control form-control-lg <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['nombre']; ?>">
        <span class="invalid-feedback"><?php echo $data['nombre_err']; ?></span>
      </div>
      <div class="mb-3">
        <label for="tipo">Tipo (Tabla, Vista, Procedimiento, etc): <sup>*</sup></label>
        <input type="text" name="tipo" class="form-control form-control-lg <?php echo (!empty($data['tipo_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['tipo']; ?>">
        <span class="invalid-feedback"><?php echo $data['tipo_err']; ?></span>
      </div>
      <div class="mb-3">
        <label for="base_datos">Base de Datos:</label>
        <input type="text" name="base_datos" class="form-control form-control-lg" value="<?php echo $data['base_datos']; ?>">
      </div>
      <div class="mb-3">
        <label for="descripcion">Descripción: </label>
        <textarea name="descripcion" class="form-control form-control-lg"><?php echo $data['descripcion']; ?></textarea>
      </div>
      <input type="submit" class="btn btn-success" value="Guardar">
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
