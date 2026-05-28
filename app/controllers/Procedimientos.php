<?php
class Procedimientos extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->procModel = $this->model('Procedimiento');
        $this->bdModel = $this->model('BaseDatos');
    }
    public function index() {
        $procedimientos = $this->procModel->getProcedimientos();
        $this->view('procedimientos/index', ['procedimientos' => $procedimientos]);
    }
    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = ['base_datos_id' => trim($_POST['base_datos_id']), 'nombre' => trim($_POST['nombre']), 'codigo' => trim($_POST['codigo']), 'descripcion' => trim($_POST['descripcion']), 'user_id' => $_SESSION['user_id'], 'nombre_err' => ''];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['nombre_err'])) {
                if($this->procModel->addProcedimiento($data)) { flash('msg', 'Procedimiento agregado'); redirect('procedimientos'); } else die('Error');
            } else { $data['bases'] = $this->bdModel->getBasesDatos(); $this->view('procedimientos/add', $data); }
        } else {
            $data = ['bases' => $this->bdModel->getBasesDatos(), 'base_datos_id' => '', 'nombre' => '', 'codigo' => '', 'descripcion' => '', 'nombre_err' => ''];
            $this->view('procedimientos/add', $data);
        }
    }
    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = ['id' => $id, 'base_datos_id' => trim($_POST['base_datos_id']), 'nombre' => trim($_POST['nombre']), 'codigo' => trim($_POST['codigo']), 'descripcion' => trim($_POST['descripcion']), 'nombre_err' => ''];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['nombre_err'])) {
                if($this->procModel->updateProcedimiento($data)) { flash('msg', 'Procedimiento actualizado'); redirect('procedimientos'); } else die('Error');
            } else { $data['bases'] = $this->bdModel->getBasesDatos(); $this->view('procedimientos/edit', $data); }
        } else {
            $proc = $this->procModel->getProcedimientoById($id);
            $data = ['id' => $id, 'bases' => $this->bdModel->getBasesDatos(), 'base_datos_id' => $proc->base_datos_id, 'nombre' => $proc->nombre, 'codigo' => $proc->codigo, 'descripcion' => $proc->descripcion, 'nombre_err' => ''];
            $this->view('procedimientos/edit', $data);
        }
    }
    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { if($this->procModel->deleteProcedimiento($id)) { flash('msg', 'Procedimiento eliminado'); redirect('procedimientos'); } else die('Error'); } else redirect('procedimientos');
    }
}
