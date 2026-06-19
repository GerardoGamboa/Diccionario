<?php
class Procedimientos extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->procModel = $this->model('Procedimiento');
        $this->bdModel = $this->model('BaseDatos');
        $this->servidorModel = $this->model('Servidor');
    }
    public function index() {
        $procedimientos = $this->procModel->getProcedimientos();
        $this->view('procedimientos/index', ['procedimientos' => $procedimientos]);
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
                if($this->procModel->addProcedimiento($data)) { flash('msg', 'Procedimiento agregado'); redirect('procedimientos'); } else die('Error');
            } else {
                $data['servidores'] = $this->servidorModel->getServidores();
                $data['bases'] = !empty($data['servidor_id']) ? $this->bdModel->getBasesDatosByServidor($data['servidor_id']) : [];
                $this->view('procedimientos/add', $data);
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
            $this->view('procedimientos/add', $data);
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
                if($this->procModel->updateProcedimiento($data)) { flash('msg', 'Procedimiento actualizado'); redirect('procedimientos'); } else die('Error');
            } else {
                $data['servidores'] = $this->servidorModel->getServidores();
                $data['bases'] = !empty($data['servidor_id']) ? $this->bdModel->getBasesDatosByServidor($data['servidor_id']) : [];
                $this->view('procedimientos/edit', $data);
            }
        } else {
            $proc = $this->procModel->getProcedimientoById($id);
            $base = $this->bdModel->getBaseDatosById($proc->base_datos_id);
            $data = [
                'id' => $id,
                'servidores' => $this->servidorModel->getServidores(),
                'bases' => $this->bdModel->getBasesDatosByServidor($base->servidor_id),
                'servidor_id' => $base->servidor_id,
                'base_datos_id' => $proc->base_datos_id,
                'nombre' => $proc->nombre,
                'codigo' => $proc->codigo,
                'descripcion' => $proc->descripcion,
                'nombre_err' => '',
                'base_datos_id_err' => '',
                'servidor_id_err' => ''
            ];
            $this->view('procedimientos/edit', $data);
        }
    }
    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { if($this->procModel->deleteProcedimiento($id)) { flash('msg', 'Procedimiento eliminado'); redirect('procedimientos'); } else die('Error'); } else redirect('procedimientos');
    }

    public function versiones($id){
        $procedimiento = $this->procModel->getProcedimientoById($id);
        $versiones = $this->procModel->getVersions($id);
        $data = [
            'objeto' => $procedimiento,
            'versiones' => $versiones,
            'titulo' => 'Versiones del Procedimiento'
        ];
        $this->view('procedimientos/versiones', $data);
    }
}
