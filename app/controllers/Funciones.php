<?php
class Funciones extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->funcModel = $this->model('Funcion');
        $this->bdModel = $this->model('BaseDatos');
    }
    public function index() {
        $funciones = $this->funcModel->getFunciones();
        $this->view('funciones/index', ['funciones' => $funciones]);
    }
    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = ['base_datos_id' => trim($_POST['base_datos_id']), 'nombre' => trim($_POST['nombre']), 'codigo' => trim($_POST['codigo']), 'descripcion' => trim($_POST['descripcion']), 'user_id' => $_SESSION['user_id'], 'nombre_err' => ''];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['nombre_err'])) {
                if($this->funcModel->addFuncion($data)) { flash('msg', 'Función agregada'); redirect('funciones'); } else die('Error');
            } else { $data['bases'] = $this->bdModel->getBasesDatos(); $this->view('funciones/add', $data); }
        } else {
            $data = ['bases' => $this->bdModel->getBasesDatos(), 'base_datos_id' => '', 'nombre' => '', 'codigo' => '', 'descripcion' => '', 'nombre_err' => ''];
            $this->view('funciones/add', $data);
        }
    }
    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = ['id' => $id, 'base_datos_id' => trim($_POST['base_datos_id']), 'nombre' => trim($_POST['nombre']), 'codigo' => trim($_POST['codigo']), 'descripcion' => trim($_POST['descripcion']), 'nombre_err' => ''];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['nombre_err'])) {
                if($this->funcModel->updateFuncion($data)) { flash('msg', 'Función actualizada'); redirect('funciones'); } else die('Error');
            } else { $data['bases'] = $this->bdModel->getBasesDatos(); $this->view('funciones/edit', $data); }
        } else {
            $func = $this->funcModel->getFuncionById($id);
            $data = ['id' => $id, 'bases' => $this->bdModel->getBasesDatos(), 'base_datos_id' => $func->base_datos_id, 'nombre' => $func->nombre, 'codigo' => $func->codigo, 'descripcion' => $func->descripcion, 'nombre_err' => ''];
            $this->view('funciones/edit', $data);
        }
    }
    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { if($this->funcModel->deleteFuncion($id)) { flash('msg', 'Función eliminada'); redirect('funciones'); } else die('Error'); } else redirect('funciones');
    }

    public function versiones($id){
        $funcion = $this->funcModel->getFuncionById($id);
        $versiones = $this->funcModel->getVersions($id);
        $data = [
            'objeto' => $funcion,
            'versiones' => $versiones,
            'titulo' => 'Versiones de la Función'
        ];
        $this->view('funciones/versiones', $data);
    }
}
