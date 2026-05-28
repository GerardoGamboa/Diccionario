<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('msg'); ?>
<div class="row mb-3">
    <div class="col-md-6"><h1>Funciones</h1></div>
    <div class="col-md-6 text-end"><a href="<?php echo URLROOT; ?>/funciones/add" class="btn btn-primary">Agregar Función</a></div>
</div>
<table class="table table-striped">
    <thead><tr><th>Nombre</th><th>Base de Datos</th><th>Creador</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php foreach($data['funciones'] as $f) : ?>
        <tr>
            <td><?php echo h($f->nombre); ?></td>
            <td><?php echo h($f->bdNombre); ?></td>
            <td><?php echo h($f->creatorName); ?></td>
            <td>
                <a href="<?php echo URLROOT; ?>/funciones/edit/<?php echo $f->funcId; ?>" class="btn btn-sm btn-warning">Editar</a>
                <form class="d-inline" action="<?php echo URLROOT; ?>/funciones/delete/<?php echo $f->funcId; ?>" method="post"><input type="submit" value="Borrar" class="btn btn-sm btn-danger"></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>
