<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php flash('msg'); ?>
  <div class="row mb-3">
    <div class="col-md-6">
      <h1>Usuarios</h1>
    </div>
    <div class="col-md-6 d-flex justify-content-end align-items-center">
      <a href="<?php echo URLROOT; ?>/users/add" class="btn btn-primary">
        <i class="fa fa-pencil"></i> Agregar Usuario
      </a>
    </div>
  </div>

  <div class="mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Buscar usuarios...">
  </div>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Email</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody id="tableBody">
      <?php foreach($data['users'] as $user) : ?>
        <tr>
          <td><?php echo h($user->name); ?></td>
          <td><?php echo h($user->email); ?></td>
          <td>
            <div class="d-flex">
                <a href="<?php echo URLROOT; ?>/users/edit/<?php echo $user->id; ?>" class="btn btn-dark btn-sm me-2">Editar</a>
                <form action="<?php echo URLROOT; ?>/users/delete/<?php echo $user->id; ?>" method="post">
                    <input type="submit" value="Eliminar" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro?')">
                </form>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php require APPROOT . '/views/inc/footer.php'; ?>
