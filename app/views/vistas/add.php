<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/vistas" class="btn btn-light">Volver</a>
<div class="card card-body bg-light mt-5">
    <h2>Agregar Vista</h2>
    <form action="<?php echo URLROOT; ?>/vistas/add" method="post">
        <div class="mb-3"><label>Base de Datos: <sup>*</sup></label>
            <select name="base_datos_id" class="form-control">
                <?php foreach($data['bases'] as $b) : ?>
                    <option value="<?php echo $b->id; ?>"><?php echo $b->nombre; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3"><label>Nombre: <sup>*</sup></label><input type="text" name="nombre" class="form-control <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo h($data['nombre']); ?>"><span class="invalid-feedback"><?php echo $data['nombre_err']; ?></span></div>
        <div class="mb-3"><label>Código:</label><textarea name="codigo" class="form-control" style="height: 250px; font-family: 'Courier New', Courier, monospace;"><?php echo h($data['codigo']); ?></textarea></div>
        <div class="mb-3"><label>Descripción:</label><textarea name="descripcion" class="form-control"><?php echo h($data['descripcion']); ?></textarea></div>
        <input type="submit" class="btn btn-success" value="Guardar">
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
