<?php
class Vistas extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->vistaModel = $this->model('Vista');
        $this->bdModel = $this->model('BaseDatos');
    }
    public function index() {
        $vistas = $this->vistaModel->getVistas();
        $this->view('vistas/index', ['vistas' => $vistas]);
    }
    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data = ['base_datos_id' => trim($_POST['base_datos_id']), 'nombre' => trim($_POST['nombre']), 'codigo' => trim($_POST['codigo']), 'descripcion' => trim($_POST['descripcion']), 'user_id' => $_SESSION['user_id'], 'nombre_err' => ''];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['nombre_err'])) {
                if($this->vistaModel->addVista($data)) { flash('msg', 'Vista agregada'); redirect('vistas'); } else die('Error');
            } else { $data['bases'] = $this->bdModel->getBasesDatos(); $this->view('vistas/add', $data); }
        } else {
            $data = ['bases' => $this->bdModel->getBasesDatos(), 'base_datos_id' => '', 'nombre' => '', 'codigo' => '', 'descripcion' => '', 'nombre_err' => ''];
            $this->view('vistas/add', $data);
        }
    }
    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data = ['id' => $id, 'base_datos_id' => trim($_POST['base_datos_id']), 'nombre' => trim($_POST['nombre']), 'codigo' => trim($_POST['codigo']), 'descripcion' => trim($_POST['descripcion']), 'nombre_err' => ''];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['nombre_err'])) {
                if($this->vistaModel->updateVista($data)) { flash('msg', 'Vista actualizada'); redirect('vistas'); } else die('Error');
            } else { $data['bases'] = $this->bdModel->getBasesDatos(); $this->view('vistas/edit', $data); }
        } else {
            $vista = $this->vistaModel->getVistaById($id);
            $data = ['id' => $id, 'bases' => $this->bdModel->getBasesDatos(), 'base_datos_id' => $vista->base_datos_id, 'nombre' => $vista->nombre, 'codigo' => $vista->codigo, 'descripcion' => $vista->descripcion, 'nombre_err' => ''];
            $this->view('vistas/edit', $data);
        }
    }
    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { if($this->vistaModel->deleteVista($id)) { flash('msg', 'Vista eliminada'); redirect('vistas'); } else die('Error'); } else redirect('vistas');
    }
}
