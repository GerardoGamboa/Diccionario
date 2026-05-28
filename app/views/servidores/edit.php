<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/servidores" class="btn btn-light">Volver</a>
<div class="card card-body bg-light mt-5">
    <h2>Editar Servidor</h2>
    <form action="<?php echo URLROOT; ?>/servidores/edit/<?php echo $data['id']; ?>" method="post">
        <div class="mb-3"><label>Nombre: <sup>*</sup></label><input type="text" name="nombre" class="form-control <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['nombre']; ?>"><span class="invalid-feedback"><?php echo $data['nombre_err']; ?></span></div>
        <div class="mb-3"><label>IP:</label><input type="text" name="ip" class="form-control" value="<?php echo $data['ip']; ?>"></div>
        <div class="mb-3"><label>Puerto:</label><input type="number" name="puerto" class="form-control" value="<?php echo $data['puerto']; ?>"></div>
        <div class="mb-3"><label>Descripción:</label><textarea name="descripcion" class="form-control"><?php echo $data['descripcion']; ?></textarea></div>
        <input type="submit" class="btn btn-success" value="Actualizar">
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
