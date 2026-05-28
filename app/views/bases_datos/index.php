<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('msg'); ?>
<div class="row mb-3">
    <div class="col-md-6"><h1>Bases de Datos</h1></div>
    <div class="col-md-6 text-end"><a href="<?php echo URLROOT; ?>/basesdatos/add" class="btn btn-primary">Agregar BD</a></div>
</div>
<table class="table table-striped">
    <thead><tr><th>Nombre</th><th>Servidor</th><th>Motor</th><th>Creador</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php foreach($data['bases'] as $base) : ?>
        <tr>
            <td><?php echo h($base->nombre); ?></td>
            <td><?php echo h($base->servidorNombre); ?></td>
            <td><?php echo h($base->motor); ?></td>
            <td><?php echo h($base->creatorName); ?></td>
            <td>
                <a href="<?php echo URLROOT; ?>/basesdatos/edit/<?php echo $base->bdId; ?>" class="btn btn-sm btn-warning">Editar</a>
                <form class="d-inline" action="<?php echo URLROOT; ?>/basesdatos/delete/<?php echo $base->bdId; ?>" method="post"><input type="submit" value="Borrar" class="btn btn-sm btn-danger"></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>
