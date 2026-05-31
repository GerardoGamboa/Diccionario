<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('msg'); ?>
<div class="row mb-3">
    <div class="col-md-12 mb-3"><input type="text" id="searchInput" class="form-control" placeholder="Filtrar registros..."></div>
    <div class="col-md-6"><h1>Disparadores</h1></div>
    <div class="col-md-6 text-end"><a href="<?php echo URLROOT; ?>/disparadores/add" class="btn btn-primary">Agregar Disp</a></div>
</div>
<table class="table table-striped">
    <thead><tr><th>Nombre</th><th>Tabla</th><th>Evento</th><th>Creador</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php foreach($data['disparadores'] as $disp) : ?>
        <tr>
            <td><?php echo h($disp->nombre); ?></td>
            <td><?php echo h($disp->tablaNombre); ?></td>
            <td><?php echo h($disp->evento); ?></td>
            <td><?php echo h($disp->creatorName); ?></td>
            <td>
                <a href="<?php echo URLROOT; ?>/disparadores/versiones/<?php echo $disp->dispId; ?>" class="btn btn-sm btn-info">Versiones</a>
                <a href="<?php echo URLROOT; ?>/disparadores/edit/<?php echo $disp->dispId; ?>" class="btn btn-sm btn-warning">Editar</a>
                <form class="d-inline" action="<?php echo URLROOT; ?>/disparadores/delete/<?php echo $disp->dispId; ?>" method="post"><input type="submit" value="Borrar" class="btn btn-sm btn-danger"></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>
