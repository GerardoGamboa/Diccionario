<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/funciones" class="btn btn-light">Volver</a>
<div class="card card-body bg-light mt-5">
    <h2>Editar Función</h2>
    <form action="<?php echo URLROOT; ?>/funciones/edit/<?php echo $data['id']; ?>" method="post">
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
        <div class="mb-3"><label>Nombre: <sup>*</sup></label><input type="text" name="nombre" class="form-control <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo h($data['nombre']); ?>"><span class="invalid-feedback"><?php echo $data['nombre_err']; ?></span></div>
        <div class="mb-3"><label>Código:</label><textarea name="codigo" class="form-control" style="height: 250px; font-family: 'Courier New', Courier, monospace;"><?php echo h($data['codigo']); ?></textarea></div>
        <div class="mb-3"><label>Descripción:</label><textarea name="descripcion" class="form-control"><?php echo h($data['descripcion']); ?></textarea></div>
        <input type="submit" class="btn btn-success" value="Actualizar">
    </form>
</div>
<script>
document.getElementById('servidor_id').addEventListener('change', function() {
    let servidorId = this.value;
    let baseSelect = document.getElementById('base_datos_id');
    baseSelect.innerHTML = '<option value="">Cargando...</option>';

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
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
