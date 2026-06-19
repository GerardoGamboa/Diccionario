<?php
class Vistas extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->vistaModel = $this->model('Vista');
        $this->bdModel = $this->model('BaseDatos');
        $this->servidorModel = $this->model('Servidor');
    }
    public function index() {
        $vistas = $this->vistaModel->getVistas();
        $this->view('vistas/index', ['vistas' => $vistas]);
    }
    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'servidor_id' => trim($_POST['servidor_id']),
                'base_datos_id' => trim($_POST['base_datos_id']),
                'nombre' => trim($_POST['nombre']),
                'codigo' => trim($_POST['codigo']),
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
                if($this->vistaModel->addVista($data)) { flash('msg', 'Vista agregada'); redirect('vistas'); } else die('Error');
            } else {
                $data['servidores'] = $this->servidorModel->getServidores();
                $data['bases'] = !empty($data['servidor_id']) ? $this->bdModel->getBasesDatosByServidor($data['servidor_id']) : [];
                $this->view('vistas/add', $data);
            }
        } else {
            $data = [
                'servidores' => $this->servidorModel->getServidores(),
                'bases' => [],
                'servidor_id' => '',
                'base_datos_id' => '',
                'nombre' => '',
                'codigo' => '',
                'descripcion' => '',
                'nombre_err' => '',
                'base_datos_id_err' => '',
                'servidor_id_err' => ''
            ];
            $this->view('vistas/add', $data);
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
                'codigo' => trim($_POST['codigo']),
                'descripcion' => trim($_POST['descripcion']),
                'nombre_err' => '',
                'base_datos_id_err' => '',
                'servidor_id_err' => ''
            ];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['base_datos_id'])) $data['base_datos_id_err'] = 'Seleccione base de datos';
            if(empty($data['servidor_id'])) $data['servidor_id_err'] = 'Seleccione servidor';

            if(empty($data['nombre_err']) && empty($data['base_datos_id_err']) && empty($data['servidor_id_err'])) {
                if($this->vistaModel->updateVista($data)) { flash('msg', 'Vista actualizada'); redirect('vistas'); } else die('Error');
            } else {
                $data['servidores'] = $this->servidorModel->getServidores();
                $data['bases'] = !empty($data['servidor_id']) ? $this->bdModel->getBasesDatosByServidor($data['servidor_id']) : [];
                $this->view('vistas/edit', $data);
            }
        } else {
            $vista = $this->vistaModel->getVistaById($id);
            $base = $this->bdModel->getBaseDatosById($vista->base_datos_id);
            $data = [
                'id' => $id,
                'servidores' => $this->servidorModel->getServidores(),
                'bases' => $this->bdModel->getBasesDatosByServidor($base->servidor_id),
                'servidor_id' => $base->servidor_id,
                'base_datos_id' => $vista->base_datos_id,
                'nombre' => $vista->nombre,
                'codigo' => $vista->codigo,
                'descripcion' => $vista->descripcion,
                'nombre_err' => '',
                'base_datos_id_err' => '',
                'servidor_id_err' => ''
            ];
            $this->view('vistas/edit', $data);
        }
    }
    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { if($this->vistaModel->deleteVista($id)) { flash('msg', 'Vista eliminada'); redirect('vistas'); } else die('Error'); } else redirect('vistas');
    }

    public function versiones($id){
        $vista = $this->vistaModel->getVistaById($id);
        $versiones = $this->vistaModel->getVersions($id);
        $data = [
            'objeto' => $vista,
            'versiones' => $versiones,
            'titulo' => 'Versiones de la Vista'
        ];
        $this->view('vistas/versiones', $data);
    }
}
