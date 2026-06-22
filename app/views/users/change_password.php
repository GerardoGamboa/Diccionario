<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5 shadow-sm">
            <h2>Cambiar Contraseña</h2>
            <p>Por favor complete el formulario para cambiar su contraseña</p>
            <form action="<?php echo URLROOT; ?>/users/change_password" method="post">
                <div class="mb-3">
                    <label for="current_password">Contraseña Actual: <sup>*</sup></label>
                    <input type="password" name="current_password" class="form-control form-control-lg <?php echo (!empty($data['current_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['current_password']; ?>">
                    <span class="invalid-feedback"><?php echo $data['current_password_err']; ?></span>
                </div>
                <div class="mb-3">
                    <label for="new_password">Nueva Contraseña: <sup>*</sup></label>
                    <input type="password" name="new_password" class="form-control form-control-lg <?php echo (!empty($data['new_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['new_password']; ?>">
                    <span class="invalid-feedback"><?php echo $data['new_password_err']; ?></span>
                </div>
                <div class="mb-3">
                    <label for="confirm_password">Confirmar Nueva Contraseña: <sup>*</sup></label>
                    <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>">
                    <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Cambiar Contraseña" class="btn btn-success w-100">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
