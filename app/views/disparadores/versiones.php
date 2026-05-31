<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/disparadores" class="btn btn-light mb-3">Volver</a>
<div class="row mb-3">
    <div class="col-md-12">
        <h1><?php echo $data['titulo']; ?>: <?php echo h($data['objeto']->nombre); ?></h1>
    </div>
</div>

<?php foreach($data['versiones'] as $v) : ?>
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between">
            <span><strong>Versión #<?php echo $v->consecutivo; ?></strong></span>
            <span>Fecha: <?php echo $v->fecha_creacion; ?> | Por: <?php echo h($v->creatorName); ?></span>
        </div>
        <div class="card-body">
            <h5>Código:</h5>
            <pre class="bg-dark text-light p-3"><code><?php echo h($v->codigo); ?></code></pre>
            <?php if(!empty($v->descripcion)) : ?>
                <h5>Descripción:</h5>
                <p><?php echo h($v->descripcion); ?></p>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>

<?php if(empty($data['versiones'])) : ?>
    <p>No hay versiones registradas para este objeto.</p>
<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>
