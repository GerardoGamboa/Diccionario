<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('msg'); ?>
<div class="row mb-3">
    <div class="col-md-12 mb-3"><input type="text" id="searchInput" class="form-control" placeholder="Filtrar registros..."></div>
    <div class="col-md-6"><h1>Procedimientos</h1></div>
    <div class="col-md-6 text-end"><a href="<?php echo URLROOT; ?>/procedimientos/add" class="btn btn-primary">Agregar Proc</a></div>
</div>
<table class="table table-striped">
    <thead><tr><th>Nombre</th><th>Base de Datos</th><th>Creador</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php foreach($data['procedimientos'] as $p) : ?>
        <tr>
            <td><?php echo h($p->nombre); ?></td>
            <td><?php echo h($p->bdNombre); ?></td>
            <td><?php echo h($p->creatorName); ?></td>
            <td>
                <a href="<?php echo URLROOT; ?>/procedimientos/versiones/<?php echo $p->procId; ?>" class="btn btn-sm btn-info">Versiones</a>
                <a href="<?php echo URLROOT; ?>/procedimientos/edit/<?php echo $p->procId; ?>" class="btn btn-sm btn-warning">Editar</a>
                <form class="d-inline" action="<?php echo URLROOT; ?>/procedimientos/delete/<?php echo $p->procId; ?>" method="post"><input type="submit" value="Borrar" class="btn btn-sm btn-danger"></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>
