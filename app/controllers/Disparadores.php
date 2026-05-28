<?php
class Disparadores extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->dispModel = $this->model('Disparador');
        $this->tablaModel = $this->model('Tabla');
    }
    public function index() {
        $disparadores = $this->dispModel->getDisparadores();
        $this->view('disparadores/index', ['disparadores' => $disparadores]);
    }
    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = ['tabla_id' => trim($_POST['tabla_id']), 'nombre' => trim($_POST['nombre']), 'evento' => trim($_POST['evento']), 'codigo' => trim($_POST['codigo']), 'descripcion' => trim($_POST['descripcion']), 'user_id' => $_SESSION['user_id'], 'nombre_err' => ''];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['nombre_err'])) {
                if($this->dispModel->addDisparador($data)) { flash('msg', 'Disparador agregado'); redirect('disparadores'); } else die('Error');
            } else { $data['tablas'] = $this->tablaModel->getTablas(); $this->view('disparadores/add', $data); }
        } else {
            $data = ['tablas' => $this->tablaModel->getTablas(), 'tabla_id' => '', 'nombre' => '', 'evento' => '', 'codigo' => '', 'descripcion' => '', 'nombre_err' => ''];
            $this->view('disparadores/add', $data);
        }
    }
    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = ['id' => $id, 'tabla_id' => trim($_POST['tabla_id']), 'nombre' => trim($_POST['nombre']), 'evento' => trim($_POST['evento']), 'codigo' => trim($_POST['codigo']), 'descripcion' => trim($_POST['descripcion']), 'nombre_err' => ''];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['nombre_err'])) {
                if($this->dispModel->updateDisparador($data)) { flash('msg', 'Disparador actualizado'); redirect('disparadores'); } else die('Error');
            } else { $data['tablas'] = $this->tablaModel->getTablas(); $this->view('disparadores/edit', $data); }
        } else {
            $disp = $this->dispModel->getDisparadorById($id);
            $data = ['id' => $id, 'tablas' => $this->tablaModel->getTablas(), 'tabla_id' => $disp->tabla_id, 'nombre' => $disp->nombre, 'evento' => $disp->evento, 'codigo' => $disp->codigo, 'descripcion' => $disp->descripcion, 'nombre_err' => ''];
            $this->view('disparadores/edit', $data);
        }
    }
    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { if($this->dispModel->deleteDisparador($id)) { flash('msg', 'Disparador eliminado'); redirect('disparadores'); } else die('Error'); } else redirect('disparadores');
    }
}
