<?php
class Tablas extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->tablaModel = $this->model('Tabla');
        $this->bdModel = $this->model('BaseDatos');
        $this->servidorModel = $this->model('Servidor');
    }
    public function index() {
        $tablas = $this->tablaModel->getTablas();
        $this->view('tablas/index', ['tablas' => $tablas]);
    }
    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'servidor_id' => trim($_POST['servidor_id']),
                'base_datos_id' => trim($_POST['base_datos_id']),
                'nombre' => trim($_POST['nombre']),
                'descripcion' => trim($_POST['descripcion']),
                'user_id' => $_SESSION['user_id'],
                'nombre_err' => '',
                'base_datos_id_err' => '',
                'servidor_id_err' => ''
            ];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['base_datos_id'])) $data['base_datos_id_err'] = 'Seleccione base de datos';
            if(empty($data['servidor_id'])) $data['servidor_id_err'] = 'Seleccione servidor';

            if(empty($data['nombre_err']) && empty($data['base_datos_id_err']) && empty($data['servidor_id_err'])) {
                if($this->tablaModel->addTabla($data)) { flash('msg', 'Tabla agregada'); redirect('tablas'); } else die('Error');
            } else {
                $data['servidores'] = $this->servidorModel->getServidores();
                $data['bases'] = !empty($data['servidor_id']) ? $this->bdModel->getBasesDatosByServidor($data['servidor_id']) : [];
                $this->view('tablas/add', $data);
            }
        } else {
            $data = [
                'servidores' => $this->servidorModel->getServidores(),
                'bases' => [],
                'servidor_id' => '',
                'base_datos_id' => '',
                'nombre' => '',
                'descripcion' => '',
                'nombre_err' => '',
                'base_datos_id_err' => '',
                'servidor_id_err' => ''
            ];
            $this->view('tablas/add', $data);
        }
    }
    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'id' => $id,
                'servidor_id' => trim($_POST['servidor_id']),
                'base_datos_id' => trim($_POST['base_datos_id']),
                'nombre' => trim($_POST['nombre']),
                'descripcion' => trim($_POST['descripcion']),
                'nombre_err' => '',
                'base_datos_id_err' => '',
                'servidor_id_err' => ''
            ];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['base_datos_id'])) $data['base_datos_id_err'] = 'Seleccione base de datos';
            if(empty($data['servidor_id'])) $data['servidor_id_err'] = 'Seleccione servidor';

            if(empty($data['nombre_err']) && empty($data['base_datos_id_err']) && empty($data['servidor_id_err'])) {
                if($this->tablaModel->updateTabla($data)) { flash('msg', 'Tabla actualizada'); redirect('tablas'); } else die('Error');
            } else {
                $data['servidores'] = $this->servidorModel->getServidores();
                $data['bases'] = !empty($data['servidor_id']) ? $this->bdModel->getBasesDatosByServidor($data['servidor_id']) : [];
                $this->view('tablas/edit', $data);
            }
        } else {
            $tabla = $this->tablaModel->getTablaById($id);
            $base = $this->bdModel->getBaseDatosById($tabla->base_datos_id);
            $data = [
                'id' => $id,
                'servidores' => $this->servidorModel->getServidores(),
                'bases' => $this->bdModel->getBasesDatosByServidor($base->servidor_id),
                'servidor_id' => $base->servidor_id,
                'base_datos_id' => $tabla->base_datos_id,
                'nombre' => $tabla->nombre,
                'descripcion' => $tabla->descripcion,
                'nombre_err' => '',
                'base_datos_id_err' => '',
                'servidor_id_err' => ''
            ];
            $this->view('tablas/edit', $data);
        }
    }
    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { if($this->tablaModel->deleteTabla($id)) { flash('msg', 'Tabla eliminada'); redirect('tablas'); } else die('Error'); } else redirect('tablas');
    }

    public function getByBaseDatos($base_datos_id) {
        $tablas = $this->tablaModel->getTablasByBaseDatos($base_datos_id);
        header('Content-Type: application/json');
        echo json_encode($tablas);
    }
}
