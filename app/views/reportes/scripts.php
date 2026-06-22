<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row mb-3">
    <div class="col-md-6">
        <h1>Reporte de Scripts Aplicados</h1>
    </div>
    <div class="col-md-6 d-flex justify-content-end align-items-center">
        <a href="<?php echo URLROOT; ?>/reportes/scripts?filtro=<?php echo urlencode($data['filtro']); ?>&pdf=1" class="btn btn-danger">
            <i class="fa fa-file-pdf"></i> Descargar PDF
        </a>
    </div>
</div>

<div class="card card-body bg-light mb-4">
    <form action="<?php echo URLROOT; ?>/reportes/scripts" method="get" class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="filtro" class="col-form-label">Buscar en código del script:</label>
        </div>
        <div class="col-md-4">
            <input type="text" name="filtro" id="filtro" class="form-control" placeholder="Palabra clave..." value="<?php echo h($data['filtro']); ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="<?php echo URLROOT; ?>/reportes/scripts" class="btn btn-secondary">Limpiar</a>
        </div>
    </form>
</div>

<?php if(empty($data['scripts'])) : ?>
    <div class="alert alert-info">No se encontraron scripts que coincidan con el filtro.</div>
<?php else : ?>
    <?php foreach($data['scripts'] as $script) : ?>
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-dark text-white d-flex justify-content-between">
                <span><strong>Servidor: <?php echo h($script->servidorNombre); ?></strong></span>
                <span>Fecha Apl: <?php echo h($script->fecha_aplicacion); ?></span>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Solicitante:</strong> <?php echo h($script->solicitante); ?></div>
                    <div class="col-md-6 text-end"><strong>Ejecutor:</strong> <?php echo h($script->ejecutor); ?></div>
                </div>
                <h6 class="border-bottom pb-1">Código del Script:</h6>
                <pre class="bg-light p-3 border" style="font-family: 'Courier New', Courier, monospace; max-height: 300px; overflow-y: auto; white-space: pre-wrap;"><code><?php echo h($script->codigo); ?></code></pre>

                <?php if(!empty($script->resultado)) : ?>
                    <h6 class="mt-3 text-muted">Resultado / Observaciones:</h6>
                    <p class="mb-0 small italic"><?php echo h($script->resultado); ?></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>
