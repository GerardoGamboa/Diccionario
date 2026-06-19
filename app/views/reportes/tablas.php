<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row mb-3">
    <div class="col-md-6">
        <h1>Reporte de Diccionario de Datos</h1>
    </div>
</div>

<div class="card card-body bg-light mb-4">
    <form action="<?php echo URLROOT; ?>/reportes/tablas" method="get" class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="base_datos_id" class="col-form-label">Filtrar por Base de Datos:</label>
        </div>
        <div class="col-auto">
            <select name="base_datos_id" id="base_datos_id" class="form-control">
                <option value="">-- Todas las Bases de Datos --</option>
                <?php foreach($data['bases'] as $base) : ?>
                    <option value="<?php echo $base->id; ?>" <?php echo ($data['base_datos_id'] == $base->id) ? 'selected' : ''; ?>>
                        <?php echo h($base->nombre); ?> (<?php echo h($base->servidorNombre); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="<?php echo URLROOT; ?>/reportes/tablas" class="btn btn-secondary">Limpiar</a>
        </div>
    </form>
</div>

<?php if(empty($data['tablas'])) : ?>
    <div class="alert alert-info">No se encontraron tablas para los criterios seleccionados.</div>
<?php else : ?>
    <?php
    $current_db = '';
    foreach($data['tablas'] as $tabla) :
        if($current_db != $tabla->bdNombre) :
            $current_db = $tabla->bdNombre;
    ?>
        <h2 class="mt-5 text-primary border-bottom pb-2">Base de Datos: <?php echo h($current_db); ?> <small class="text-muted">(<?php echo h($tabla->servidorNombre); ?>)</small></h2>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Tabla: <?php echo h($tabla->nombre); ?></h4>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 20%;">Columna</th>
                        <th style="width: 15%;">Tipo</th>
                        <th style="width: 10%;">Longitud</th>
                        <th style="width: 10%;">Nulo</th>
                        <th style="width: 10%;">Llave</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($tabla->columnas)) : ?>
                        <tr><td colspan="6" class="text-center italic">No hay columnas registradas para esta tabla.</td></tr>
                    <?php else : ?>
                        <?php foreach($tabla->columnas as $columna) : ?>
                            <tr>
                                <td><strong><?php echo h($columna->nombre); ?></strong></td>
                                <td><?php echo h($columna->tipo_dato); ?></td>
                                <td><?php echo h($columna->longitud); ?></td>
                                <td><?php echo $columna->permite_nulo ? 'Sí' : 'No'; ?></td>
                                <td><?php echo $columna->es_llave ? '<span class="badge bg-warning text-dark">PK/FK</span>' : 'No'; ?></td>
                                <td><small><?php echo h($columna->descripcion); ?></small></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>
