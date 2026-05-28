<?php
class Basesdatos extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->bdModel = $this->model('BaseDatos');
        $this->servidorModel = $this->model('Servidor');
    }

    public function index() {
        $bases = $this->bdModel->getBasesDatos();
        $data = ['bases' => $bases];
        $this->view('bases_datos/index', $data);
    }

    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'servidor_id' => trim($_POST['servidor_id']),
                'nombre' => trim($_POST['nombre']),
                'descripcion' => trim($_POST['descripcion']),
                'user_id' => $_SESSION['user_id'],
                'servidor_id_err' => '',
                'nombre_err' => ''
            ];
            if(empty($data['servidor_id'])) $data['servidor_id_err'] = 'Seleccione servidor';
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['nombre_err']) && empty($data['servidor_id_err'])) {
                if($this->bdModel->addBaseDatos($data)) {
                    flash('msg', 'Base de Datos agregada');
                    redirect('basesdatos');
                } else die('Error');
            } else {
                $data['servidores'] = $this->servidorModel->getServidores();
                $this->view('bases_datos/add', $data);
            }
        } else {
            $servidores = $this->servidorModel->getServidores();
            $data = ['servidores' => $servidores, 'servidor_id' => '', 'nombre' => '', 'descripcion' => '', 'servidor_id_err' => '', 'nombre_err' => ''];
            $this->view('bases_datos/add', $data);
        }
    }

    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'id' => $id,
                'servidor_id' => trim($_POST['servidor_id']),
                'nombre' => trim($_POST['nombre']),
                'descripcion' => trim($_POST['descripcion']),
                'servidor_id_err' => '',
                'nombre_err' => ''
            ];
            if(empty($data['servidor_id'])) $data['servidor_id_err'] = 'Seleccione servidor';
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['nombre_err']) && empty($data['servidor_id_err'])) {
                if($this->bdModel->updateBaseDatos($data)) {
                    flash('msg', 'Base de Datos actualizada');
                    redirect('basesdatos');
                } else die('Error');
            } else {
                $data['servidores'] = $this->servidorModel->getServidores();
                $this->view('bases_datos/edit', $data);
            }
        } else {
            $base = $this->bdModel->getBaseDatosById($id);
            $servidores = $this->servidorModel->getServidores();
            $data = ['id' => $id, 'servidores' => $servidores, 'servidor_id' => $base->servidor_id, 'nombre' => $base->nombre, 'descripcion' => $base->descripcion, 'servidor_id_err' => '', 'nombre_err' => ''];
            $this->view('bases_datos/edit', $data);
        }
    }

    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->bdModel->deleteBaseDatos($id)) {
                flash('msg', 'Base de Datos eliminada');
                redirect('basesdatos');
            } else die('Error');
        } else redirect('basesdatos');
    }
}
