<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('msg'); ?>
<div class="row mb-3">
    <div class="col-md-6"><h1>Servidores</h1></div>
    <div class="col-md-6 text-end"><a href="<?php echo URLROOT; ?>/servidores/add" class="btn btn-primary">Agregar Servidor</a></div>
</div>
<table class="table table-striped">
    <thead><tr><th>Nombre</th><th>IP</th><th>Puerto</th><th>Motor</th><th>Creador</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php foreach($data['servidores'] as $servidor) : ?>
        <tr>
            <td><?php echo $servidor->nombre; ?></td>
            <td><?php echo $servidor->ip; ?></td>
            <td><?php echo $servidor->puerto; ?></td>
            <td><?php echo h($servidor->motor); ?></td>
            <td><?php echo $servidor->creatorName; ?></td>
            <td>
                <a href="<?php echo URLROOT; ?>/servidores/edit/<?php echo $servidor->servidorId; ?>" class="btn btn-sm btn-warning">Editar</a>
                <form class="d-inline" action="<?php echo URLROOT; ?>/servidores/delete/<?php echo $servidor->servidorId; ?>" method="post"><input type="submit" value="Borrar" class="btn btn-sm btn-danger"></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>
