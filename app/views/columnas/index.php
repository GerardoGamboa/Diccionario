<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('msg'); ?>
<div class="row mb-3">
    <div class="col-md-12 mb-3"><input type="text" id="searchInput" class="form-control" placeholder="Filtrar registros..."></div>
    <div class="col-md-6"><h1>Columnas</h1></div>
    <div class="col-md-6 text-end"><a href="<?php echo URLROOT; ?>/columnas/add" class="btn btn-primary">Agregar Columna</a></div>
</div>
<table class="table table-striped">
    <thead><tr><th>Nombre</th><th>Tabla</th><th>Tipo</th><th>Longitud</th><th>Nulo</th><th>Llave</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php foreach($data['columnas'] as $columna) : ?>
        <tr>
            <td><?php echo h($columna->nombre); ?></td>
            <td><?php echo h($columna->tablaNombre); ?></td>
            <td><?php echo h($columna->tipo_dato); ?></td>
            <td><?php echo h($columna->longitud); ?></td>
            <td><?php echo ($columna->permite_nulo) ? 'SI' : 'NO'; ?></td>
            <td><?php echo ($columna->es_llave) ? 'SI' : 'NO'; ?></td>
            <td>
                <a href="<?php echo URLROOT; ?>/columnas/edit/<?php echo $columna->columnaId; ?>" class="btn btn-sm btn-warning">Editar</a>
                <form class="d-inline" action="<?php echo URLROOT; ?>/columnas/delete/<?php echo $columna->columnaId; ?>" method="post"><input type="submit" value="Borrar" class="btn btn-sm btn-danger"></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>
