<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/scripts" class="btn btn-light mb-3"><i class="fa fa-backward"></i> Volver</a>
<div class="card card-body bg-light">
    <h2>Registrar Script Aplicado</h2>
    <p>Ingrese la información del script aplicado al servidor</p>
    <form action="<?php echo URLROOT; ?>/scripts/add" method="post">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="servidor_id">Servidor: <sup>*</sup></label>
                <select name="servidor_id" class="form-control <?php echo (!empty($data['servidor_id_err'])) ? 'is-invalid' : ''; ?>">
                    <option value="">Seleccione servidor</option>
                    <?php foreach($data['servidores'] as $s) : ?>
                        <option value="<?php echo $s->id; ?>" <?php echo ($s->id == $data['servidor_id']) ? 'selected' : ''; ?>><?php echo $s->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="invalid-feedback"><?php echo $data['servidor_id_err']; ?></span>
            </div>
            <div class="col-md-6 mb-3">
                <label for="fecha_aplicacion">Fecha de Aplicación: <sup>*</sup></label>
                <input type="date" name="fecha_aplicacion" class="form-control <?php echo (!empty($data['fecha_aplicacion_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['fecha_aplicacion']; ?>">
                <span class="invalid-feedback"><?php echo $data['fecha_aplicacion_err']; ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="solicitante">Solicitante: <sup>*</sup></label>
                <input type="text" name="solicitante" class="form-control <?php echo (!empty($data['solicitante_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo h($data['solicitante']); ?>">
                <span class="invalid-feedback"><?php echo $data['solicitante_err']; ?></span>
            </div>
            <div class="col-md-6 mb-3">
                <label for="ejecutor">Ejecutor (Quien aplicó): <sup>*</sup></label>
                <input type="text" name="ejecutor" class="form-control <?php echo (!empty($data['ejecutor_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo h($data['ejecutor']); ?>">
                <span class="invalid-feedback"><?php echo $data['ejecutor_err']; ?></span>
            </div>
        </div>

        <div class="mb-3">
            <label for="codigo">Código del Script: <sup>*</sup></label>
            <textarea name="codigo" class="form-control <?php echo (!empty($data['codigo_err'])) ? 'is-invalid' : ''; ?>" style="height: 250px; font-family: 'Courier New', Courier, monospace;"><?php echo h($data['codigo']); ?></textarea>
            <span class="invalid-feedback"><?php echo $data['codigo_err']; ?></span>
        </div>

        <div class="mb-3">
            <label for="resultado">Resultado / Observaciones Importantes:</label>
            <textarea name="resultado" class="form-control" style="height: 100px;"><?php echo h($data['resultado']); ?></textarea>
        </div>

        <input type="submit" class="btn btn-success" value="Guardar">
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
