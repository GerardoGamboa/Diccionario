<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('msg'); ?>
<div class="row mb-3">
    <div class="col-md-6"><h1>Tablas</h1></div>
    <div class="col-md-6 text-end"><a href="<?php echo URLROOT; ?>/tablas/add" class="btn btn-primary">Agregar Tabla</a></div>
</div>
<table class="table table-striped">
    <thead><tr><th>Nombre</th><th>Base de Datos</th><th>Creador</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php foreach($data['tablas'] as $tabla) : ?>
        <tr>
            <td><?php echo h($tabla->nombre); ?></td>
            <td><?php echo h($tabla->bdNombre); ?></td>
            <td><?php echo h($tabla->creatorName); ?></td>
            <td>
                <a href="<?php echo URLROOT; ?>/tablas/edit/<?php echo $tabla->tablaId; ?>" class="btn btn-sm btn-warning">Editar</a>
                <form class="d-inline" action="<?php echo URLROOT; ?>/tablas/delete/<?php echo $tabla->tablaId; ?>" method="post"><input type="submit" value="Borrar" class="btn btn-sm btn-danger"></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>
