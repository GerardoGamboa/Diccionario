<?php
class Servidores extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->servidorModel = $this->model('Servidor');
    }

    public function index() {
        $servidores = $this->servidorModel->getServidores();
        $data = ['servidores' => $servidores];
        $this->view('servidores/index', $data);
    }

    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'nombre' => trim($_POST['nombre']),
                'ip' => trim($_POST['ip']),
                'puerto' => trim($_POST['puerto']),
                'descripcion' => trim($_POST['descripcion']),
                'user_id' => $_SESSION['user_id'],
                'nombre_err' => ''
            ];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['nombre_err'])) {
                if($this->servidorModel->addServidor($data)) {
                    flash('msg', 'Servidor agregado');
                    redirect('servidores');
                } else die('Error');
            } else $this->view('servidores/add', $data);
        } else {
            $data = ['nombre' => '', 'ip' => '', 'puerto' => '', 'descripcion' => ''];
            $this->view('servidores/add', $data);
        }
    }

    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'id' => $id,
                'nombre' => trim($_POST['nombre']),
                'ip' => trim($_POST['ip']),
                'puerto' => trim($_POST['puerto']),
                'descripcion' => trim($_POST['descripcion']),
                'nombre_err' => ''
            ];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['nombre_err'])) {
                if($this->servidorModel->updateServidor($data)) {
                    flash('msg', 'Servidor actualizado');
                    redirect('servidores');
                } else die('Error');
            } else $this->view('servidores/edit', $data);
        } else {
            $servidor = $this->servidorModel->getServidorById($id);
            $data = ['id' => $id, 'nombre' => $servidor->nombre, 'ip' => $servidor->ip, 'puerto' => $servidor->puerto, 'descripcion' => $servidor->descripcion];
            $this->view('servidores/edit', $data);
        }
    }

    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->servidorModel->deleteServidor($id)) {
                flash('msg', 'Servidor eliminado');
                redirect('servidores');
            } else die('Error');
        } else redirect('servidores');
    }
}
