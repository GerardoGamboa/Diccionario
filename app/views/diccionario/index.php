<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php flash('post_message'); ?>
  <div class="row mb-3">
    <div class="col-md-6">
      <h1>Diccionario de Datos</h1>
    </div>
    <div class="col-md-6 text-end">
      <a href="<?php echo URLROOT; ?>/diccionario/add" class="btn btn-primary">
        <i class="fa fa-pencil"></i> Agregar Objeto
      </a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>Nombre</th>
          <th>Tipo</th>
          <th>Base de Datos</th>
          <th>Creado por</th>
          <th>Fecha</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($data['objetos'] as $objeto) : ?>
          <tr>
            <td><?php echo $objeto->nombre; ?></td>
            <td><?php echo $objeto->tipo; ?></td>
            <td><?php echo $objeto->base_datos; ?></td>
            <td><?php echo $objeto->name; ?></td>
            <td><?php echo $objeto->objetoCreated; ?></td>
            <td>
              <a href="<?php echo URLROOT; ?>/diccionario/edit/<?php echo $objeto->objetoId; ?>" class="btn btn-sm btn-warning">Editar</a>
              <form class="d-inline" action="<?php echo URLROOT; ?>/diccionario/delete/<?php echo $objeto->objetoId; ?>" method="post">
                <input type="submit" value="Borrar" class="btn btn-sm btn-danger">
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
