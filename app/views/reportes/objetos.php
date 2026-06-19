<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row mb-3">
    <div class="col-md-6">
        <h1>Reporte de Objetos Programables</h1>
    </div>
</div>

<div class="card card-body bg-light mb-4">
    <form action="<?php echo URLROOT; ?>/reportes/objetos" method="get" class="row g-3 align-items-center">
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
            <a href="<?php echo URLROOT; ?>/reportes/objetos" class="btn btn-secondary">Limpiar</a>
        </div>
    </form>
</div>

<div class="row">
    <!-- Procedimientos -->
    <div class="col-md-12 mb-5">
        <h2 class="text-success border-bottom pb-2">Procedimientos Almacenados</h2>
        <?php if(empty($data['procedimientos'])) : ?>
            <div class="alert alert-light border text-muted">No hay procedimientos registrados.</div>
        <?php else : ?>
            <table class="table table-striped table-hover shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 25%;">Base de Datos</th>
                        <th style="width: 30%;">Nombre</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['procedimientos'] as $proc) : ?>
                        <tr>
                            <td><strong><?php echo h($proc->bdNombre); ?></strong></td>
                            <td><?php echo h($proc->nombre); ?></td>
                            <td><small><?php echo h($proc->descripcion); ?></small></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Funciones -->
    <div class="col-md-12 mb-5">
        <h2 class="text-info border-bottom pb-2">Funciones</h2>
        <?php if(empty($data['funciones'])) : ?>
            <div class="alert alert-light border text-muted">No hay funciones registradas.</div>
        <?php else : ?>
            <table class="table table-striped table-hover shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 25%;">Base de Datos</th>
                        <th style="width: 30%;">Nombre</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['funciones'] as $func) : ?>
                        <tr>
                            <td><strong><?php echo h($func->bdNombre); ?></strong></td>
                            <td><?php echo h($func->nombre); ?></td>
                            <td><small><?php echo h($func->descripcion); ?></small></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Disparadores -->
    <div class="col-md-12 mb-5">
        <h2 class="text-warning border-bottom pb-2">Disparadores (Triggers)</h2>
        <?php if(empty($data['disparadores'])) : ?>
            <div class="alert alert-light border text-muted">No hay disparadores registrados.</div>
        <?php else : ?>
            <table class="table table-striped table-hover shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 25%;">Base de Datos</th>
                        <th style="width: 20%;">Tabla</th>
                        <th style="width: 25%;">Nombre</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['disparadores'] as $disp) : ?>
                        <tr>
                            <td><strong><?php echo h($disp->bdNombre); ?></strong></td>
                            <td><?php echo h($disp->tablaNombre); ?></td>
                            <td><?php echo h($disp->nombre); ?></td>
                            <td><small><?php echo h($disp->descripcion); ?></small></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
