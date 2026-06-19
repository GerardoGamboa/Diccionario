<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/disparadores" class="btn btn-light">Volver</a>
<div class="card card-body bg-light mt-5">
    <h2>Agregar Disparador</h2>
    <form action="<?php echo URLROOT; ?>/disparadores/add" method="post">
        <div class="mb-3"><label>Servidor: <sup>*</sup></label>
            <select name="servidor_id" id="servidor_id" class="form-control <?php echo (!empty($data['servidor_id_err'])) ? 'is-invalid' : ''; ?>">
                <option value="">Seleccione servidor</option>
                <?php foreach($data['servidores'] as $s) : ?>
                    <option value="<?php echo $s->id; ?>" <?php echo ($s->id == $data['servidor_id']) ? 'selected' : ''; ?>><?php echo $s->nombre; ?></option>
                <?php endforeach; ?>
            </select>
            <span class="invalid-feedback"><?php echo $data['servidor_id_err']; ?></span>
        </div>
        <div class="mb-3"><label>Base de Datos: <sup>*</sup></label>
            <select name="base_datos_id" id="base_datos_id" class="form-control <?php echo (!empty($data['base_datos_id_err'])) ? 'is-invalid' : ''; ?>">
                <option value="">Seleccione base de datos</option>
                <?php foreach($data['bases'] as $b) : ?>
                    <option value="<?php echo $b->id; ?>" <?php echo ($b->id == $data['base_datos_id']) ? 'selected' : ''; ?>><?php echo $b->nombre; ?></option>
                <?php endforeach; ?>
            </select>
            <span class="invalid-feedback"><?php echo $data['base_datos_id_err']; ?></span>
        </div>
        <div class="mb-3"><label>Tabla: <sup>*</sup></label>
            <select name="tabla_id" id="tabla_id" class="form-control <?php echo (!empty($data['tabla_id_err'])) ? 'is-invalid' : ''; ?>">
                <option value="">Seleccione tabla</option>
                <?php foreach($data['tablas'] as $t) : ?>
                    <option value="<?php echo $t->id; ?>" <?php echo ($t->id == $data['tabla_id']) ? 'selected' : ''; ?>><?php echo $t->nombre; ?></option>
                <?php endforeach; ?>
            </select>
            <span class="invalid-feedback"><?php echo $data['tabla_id_err']; ?></span>
        </div>
        <div class="mb-3"><label>Nombre: <sup>*</sup></label><input type="text" name="nombre" class="form-control <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo h($data['nombre']); ?>"><span class="invalid-feedback"><?php echo $data['nombre_err']; ?></span></div>
        <div class="mb-3"><label>Evento:</label><input type="text" name="evento" class="form-control" value="<?php echo h($data['evento']); ?>"></div>
        <div class="mb-3"><label>Código:</label><textarea name="codigo" class="form-control" style="height: 250px; font-family: 'Courier New', Courier, monospace;"><?php echo h($data['codigo']); ?></textarea></div>
        <div class="mb-3"><label>Descripción:</label><textarea name="descripcion" class="form-control"><?php echo h($data['descripcion']); ?></textarea></div>
        <input type="submit" class="btn btn-success" value="Guardar">
    </form>
</div>
<script>
document.getElementById('servidor_id').addEventListener('change', function() {
    let servidorId = this.value;
    let baseSelect = document.getElementById('base_datos_id');
    let tablaSelect = document.getElementById('tabla_id');
    baseSelect.innerHTML = '<option value="">Cargando...</option>';
    tablaSelect.innerHTML = '<option value="">Seleccione tabla</option>';

    if(servidorId) {
        fetch('<?php echo URLROOT; ?>/basesdatos/getByServidor/' + servidorId)
            .then(response => response.json())
            .then(data => {
                baseSelect.innerHTML = '<option value="">Seleccione base de datos</option>';
                data.forEach(base => {
                    let option = document.createElement('option');
                    option.value = base.id;
                    option.textContent = base.nombre;
                    baseSelect.appendChild(option);
                });
            });
    } else {
        baseSelect.innerHTML = '<option value="">Seleccione base de datos</option>';
    }
});

document.getElementById('base_datos_id').addEventListener('change', function() {
    let baseId = this.value;
    let tablaSelect = document.getElementById('tabla_id');
    tablaSelect.innerHTML = '<option value="">Cargando...</option>';

    if(baseId) {
        fetch('<?php echo URLROOT; ?>/tablas/getByBaseDatos/' + baseId)
            .then(response => response.json())
            .then(data => {
                tablaSelect.innerHTML = '<option value="">Seleccione tabla</option>';
                data.forEach(tabla => {
                    let option = document.createElement('option');
                    option.value = tabla.id;
                    option.textContent = tabla.nombre;
                    tablaSelect.appendChild(option);
                });
            });
    } else {
        tablaSelect.innerHTML = '<option value="">Seleccione tabla</option>';
    }
});
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
