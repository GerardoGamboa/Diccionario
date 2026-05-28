<?php
class Tablas extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->tablaModel = $this->model('Tabla');
        $this->bdModel = $this->model('BaseDatos');
    }
    public function index() {
        $tablas = $this->tablaModel->getTablas();
        $this->view('tablas/index', ['tablas' => $tablas]);
    }
    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = ['base_datos_id' => trim($_POST['base_datos_id']), 'nombre' => trim($_POST['nombre']), 'descripcion' => trim($_POST['descripcion']), 'user_id' => $_SESSION['user_id'], 'nombre_err' => ''];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['nombre_err'])) {
                if($this->tablaModel->addTabla($data)) { flash('msg', 'Tabla agregada'); redirect('tablas'); } else die('Error');
            } else { $data['bases'] = $this->bdModel->getBasesDatos(); $this->view('tablas/add', $data); }
        } else {
            $data = ['bases' => $this->bdModel->getBasesDatos(), 'base_datos_id' => '', 'nombre' => '', 'descripcion' => ''];
            $this->view('tablas/add', $data);
        }
    }
    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = ['id' => $id, 'base_datos_id' => trim($_POST['base_datos_id']), 'nombre' => trim($_POST['nombre']), 'descripcion' => trim($_POST['descripcion']), 'nombre_err' => ''];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['nombre_err'])) {
                if($this->tablaModel->updateTabla($data)) { flash('msg', 'Tabla actualizada'); redirect('tablas'); } else die('Error');
            } else { $data['bases'] = $this->bdModel->getBasesDatos(); $this->view('tablas/edit', $data); }
        } else {
            $tabla = $this->tablaModel->getTablaById($id);
            $data = ['id' => $id, 'bases' => $this->bdModel->getBasesDatos(), 'base_datos_id' => $tabla->base_datos_id, 'nombre' => $tabla->nombre, 'descripcion' => $tabla->descripcion];
            $this->view('tablas/edit', $data);
        }
    }
    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { if($this->tablaModel->deleteTabla($id)) { flash('msg', 'Tabla eliminada'); redirect('tablas'); } else die('Error'); } else redirect('tablas');
    }
}
