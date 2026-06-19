<?php
class Funciones extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->funcModel = $this->model('Funcion');
        $this->bdModel = $this->model('BaseDatos');
        $this->servidorModel = $this->model('Servidor');
    }
    public function index() {
        $funciones = $this->funcModel->getFunciones();
        $this->view('funciones/index', ['funciones' => $funciones]);
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
                if($this->funcModel->addFuncion($data)) { flash('msg', 'Función agregada'); redirect('funciones'); } else die('Error');
            } else {
                $data['servidores'] = $this->servidorModel->getServidores();
                $data['bases'] = !empty($data['servidor_id']) ? $this->bdModel->getBasesDatosByServidor($data['servidor_id']) : [];
                $this->view('funciones/add', $data);
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
            $this->view('funciones/add', $data);
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
                if($this->funcModel->updateFuncion($data)) { flash('msg', 'Función actualizada'); redirect('funciones'); } else die('Error');
            } else {
                $data['servidores'] = $this->servidorModel->getServidores();
                $data['bases'] = !empty($data['servidor_id']) ? $this->bdModel->getBasesDatosByServidor($data['servidor_id']) : [];
                $this->view('funciones/edit', $data);
            }
        } else {
            $func = $this->funcModel->getFuncionById($id);
            $base = $this->bdModel->getBaseDatosById($func->base_datos_id);
            $data = [
                'id' => $id,
                'servidores' => $this->servidorModel->getServidores(),
                'bases' => $this->bdModel->getBasesDatosByServidor($base->servidor_id),
                'servidor_id' => $base->servidor_id,
                'base_datos_id' => $func->base_datos_id,
                'nombre' => $func->nombre,
                'codigo' => $func->codigo,
                'descripcion' => $func->descripcion,
                'nombre_err' => '',
                'base_datos_id_err' => '',
                'servidor_id_err' => ''
            ];
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
