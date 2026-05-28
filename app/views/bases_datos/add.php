<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/basesdatos" class="btn btn-light">Volver</a>
<div class="card card-body bg-light mt-5">
    <h2>Agregar Base de Datos</h2>
    <form action="<?php echo URLROOT; ?>/basesdatos/add" method="post">
        <div class="mb-3"><label>Servidor: <sup>*</sup></label>
            <select name="servidor_id" class="form-control <?php echo (!empty($data['servidor_id_err'])) ? 'is-invalid' : ''; ?>">
                <option value="">Seleccione Servidor</option>
                <?php foreach($data['servidores'] as $s) : ?>
                    <option value="<?php echo $s->id; ?>"><?php echo $s->nombre; ?></option>
                <?php endforeach; ?>
            </select>
            <span class="invalid-feedback"><?php echo $data['servidor_id_err']; ?></span>
        </div>
        <div class="mb-3"><label>Nombre: <sup>*</sup></label><input type="text" name="nombre" class="form-control <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['nombre']; ?>"><span class="invalid-feedback"><?php echo $data['nombre_err']; ?></span></div>
        <div class="mb-3"><label>Motor:</label><input type="text" name="motor" class="form-control" value="<?php echo $data['motor']; ?>"></div>
        <div class="mb-3"><label>Descripción:</label><textarea name="descripcion" class="form-control"><?php echo $data['descripcion']; ?></textarea></div>
        <input type="submit" class="btn btn-success" value="Guardar">
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
