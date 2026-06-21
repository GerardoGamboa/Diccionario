<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php flash('msg'); ?>
  <div class="row mb-3">
    <div class="col-md-6">
      <h1>Scripts Aplicados</h1>
    </div>
    <div class="col-md-6 d-flex justify-content-end align-items-center">
      <a href="<?php echo URLROOT; ?>/scripts/add" class="btn btn-primary">
        <i class="fa fa-pencil"></i> Registrar Script
      </a>
    </div>
  </div>

  <div class="mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Buscar scripts...">
  </div>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Servidor</th>
        <th>Fecha Apl.</th>
        <th>Solicitante</th>
        <th>Ejecutor</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody id="tableBody">
      <?php foreach($data['scripts'] as $script) : ?>
        <tr>
          <td><?php echo h($script->servidorNombre); ?></td>
          <td><?php echo h($script->fecha_aplicacion); ?></td>
          <td><?php echo h($script->solicitante); ?></td>
          <td><?php echo h($script->ejecutor); ?></td>
          <td>
            <div class="d-flex">
                <a href="<?php echo URLROOT; ?>/scripts/edit/<?php echo $script->scriptId; ?>" class="btn btn-dark btn-sm me-2">Detalles / Editar</a>
                <form action="<?php echo URLROOT; ?>/scripts/delete/<?php echo $script->scriptId; ?>" method="post" onsubmit="return confirm('¿Está seguro?')">
                    <input type="submit" value="Eliminar" class="btn btn-danger btn-sm">
                </form>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php require APPROOT . '/views/inc/footer.php'; ?>
