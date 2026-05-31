<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/columnas" class="btn btn-light">Volver</a>
<div class="card card-body bg-light mt-5">
    <h2>Editar Columna</h2>
    <form action="<?php echo URLROOT; ?>/columnas/edit/<?php echo $data['id']; ?>" method="post">
        <div class="mb-3"><label>Tabla: <sup>*</sup></label>
            <select name="tabla_id" class="form-control">
                <?php foreach($data['tablas'] as $t) : ?>
                    <option value="<?php echo $t->id; ?>" <?php echo ($t->id == $data['tabla_id']) ? 'selected' : ''; ?>><?php echo $t->nombre; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3"><label>Nombre: <sup>*</sup></label><input type="text" name="nombre" class="form-control <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo h($data['nombre']); ?>"><span class="invalid-feedback"><?php echo $data['nombre_err']; ?></span></div>
        <div class="mb-3"><label>Tipo de Dato:</label><input type="text" name="tipo_dato" class="form-control" value="<?php echo h($data['tipo_dato']); ?>"></div>
        <div class="mb-3"><label>Longitud:</label><input type="text" name="longitud" class="form-control" value="<?php echo h($data['longitud']); ?>"></div>
        <div class="mb-3 form-check"><input type="checkbox" name="permite_nulo" class="form-check-input" id="nulo" <?php echo $data['permite_nulo'] ? 'checked' : ''; ?>><label class="form-check-label" for="nulo">Permite Nulo</label></div>
        <div class="mb-3 form-check"><input type="checkbox" name="es_llave" class="form-check-input" id="llave" <?php echo $data['es_llave'] ? 'checked' : ''; ?>><label class="form-check-label" for="llave">Es Llave</label></div>
        <div class="mb-3"><label>Descripción:</label><textarea name="descripcion" class="form-control"><?php echo h($data['descripcion']); ?></textarea></div>
        <input type="submit" class="btn btn-success" value="Actualizar">
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
