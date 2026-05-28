<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/disparadores" class="btn btn-light">Volver</a>
<div class="card card-body bg-light mt-5">
    <h2>Editar Disparador</h2>
    <form action="<?php echo URLROOT; ?>/disparadores/edit/<?php echo $data['id']; ?>" method="post">
        <div class="mb-3"><label>Tabla: <sup>*</sup></label>
            <select name="tabla_id" class="form-control">
                <?php foreach($data['tablas'] as $t) : ?>
                    <option value="<?php echo $t->id; ?>" <?php echo ($t->id == $data['tabla_id']) ? 'selected' : ''; ?>><?php echo $t->nombre; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3"><label>Nombre: <sup>*</sup></label><input type="text" name="nombre" class="form-control <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['nombre']; ?>"><span class="invalid-feedback"><?php echo $data['nombre_err']; ?></span></div>
        <div class="mb-3"><label>Evento:</label><input type="text" name="evento" class="form-control" value="<?php echo $data['evento']; ?>"></div>
        <div class="mb-3"><label>Definición:</label><textarea name="definicion" class="form-control"><?php echo $data['definicion']; ?></textarea></div>
        <div class="mb-3"><label>Descripción:</label><textarea name="descripcion" class="form-control"><?php echo $data['descripcion']; ?></textarea></div>
        <input type="submit" class="btn btn-success" value="Actualizar">
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
