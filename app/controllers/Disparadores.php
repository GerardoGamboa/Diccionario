<?php
class Disparadores extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->dispModel = $this->model('Disparador');
        $this->tablaModel = $this->model('Tabla');
        $this->bdModel = $this->model('BaseDatos');
        $this->servidorModel = $this->model('Servidor');
    }
    public function index() {
        $disparadores = $this->dispModel->getDisparadores();
        $this->view('disparadores/index', ['disparadores' => $disparadores]);
    }
    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'servidor_id' => trim($_POST['servidor_id']),
                'base_datos_id' => trim($_POST['base_datos_id']),
                'tabla_id' => trim($_POST['tabla_id']),
                'nombre' => trim($_POST['nombre']),
                'evento' => trim($_POST['evento']),
                'codigo' => trim($_POST['codigo']),
                'descripcion' => trim($_POST['descripcion']),
                'user_id' => $_SESSION['user_id'],
                'nombre_err' => '',
                'tabla_id_err' => '',
                'base_datos_id_err' => '',
                'servidor_id_err' => ''
            ];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['tabla_id'])) $data['tabla_id_err'] = 'Seleccione tabla';
            if(empty($data['base_datos_id'])) $data['base_datos_id_err'] = 'Seleccione base de datos';
            if(empty($data['servidor_id'])) $data['servidor_id_err'] = 'Seleccione servidor';

            if(empty($data['nombre_err']) && empty($data['tabla_id_err']) && empty($data['base_datos_id_err']) && empty($data['servidor_id_err'])) {
                if($this->dispModel->addDisparador($data)) { flash('msg', 'Disparador agregado'); redirect('disparadores'); } else die('Error');
            } else {
                $data['servidores'] = $this->servidorModel->getServidores();
                $data['bases'] = !empty($data['servidor_id']) ? $this->bdModel->getBasesDatosByServidor($data['servidor_id']) : [];
                $data['tablas'] = !empty($data['base_datos_id']) ? $this->tablaModel->getTablasByBaseDatos($data['base_datos_id']) : [];
                $this->view('disparadores/add', $data);
            }
        } else {
            $data = [
                'servidores' => $this->servidorModel->getServidores(),
                'bases' => [],
                'tablas' => [],
                'servidor_id' => '',
                'base_datos_id' => '',
                'tabla_id' => '',
                'nombre' => '',
                'evento' => '',
                'codigo' => '',
                'descripcion' => '',
                'nombre_err' => '',
                'tabla_id_err' => '',
                'base_datos_id_err' => '',
                'servidor_id_err' => ''
            ];
            $this->view('disparadores/add', $data);
        }
    }
    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'id' => $id,
                'servidor_id' => trim($_POST['servidor_id']),
                'base_datos_id' => trim($_POST['base_datos_id']),
                'tabla_id' => trim($_POST['tabla_id']),
                'nombre' => trim($_POST['nombre']),
                'evento' => trim($_POST['evento']),
                'codigo' => trim($_POST['codigo']),
                'descripcion' => trim($_POST['descripcion']),
                'nombre_err' => '',
                'tabla_id_err' => '',
                'base_datos_id_err' => '',
                'servidor_id_err' => ''
            ];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['tabla_id'])) $data['tabla_id_err'] = 'Seleccione tabla';
            if(empty($data['base_datos_id'])) $data['base_datos_id_err'] = 'Seleccione base de datos';
            if(empty($data['servidor_id'])) $data['servidor_id_err'] = 'Seleccione servidor';

            if(empty($data['nombre_err']) && empty($data['tabla_id_err']) && empty($data['base_datos_id_err']) && empty($data['servidor_id_err'])) {
                if($this->dispModel->updateDisparador($data)) { flash('msg', 'Disparador actualizado'); redirect('disparadores'); } else die('Error');
            } else {
                $data['servidores'] = $this->servidorModel->getServidores();
                $data['bases'] = !empty($data['servidor_id']) ? $this->bdModel->getBasesDatosByServidor($data['servidor_id']) : [];
                $data['tablas'] = !empty($data['base_datos_id']) ? $this->tablaModel->getTablasByBaseDatos($data['base_datos_id']) : [];
                $this->view('disparadores/edit', $data);
            }
        } else {
            $disp = $this->dispModel->getDisparadorById($id);
            $tabla = $this->tablaModel->getTablaById($disp->tabla_id);
            $base = $this->bdModel->getBaseDatosById($tabla->base_datos_id);
            $data = [
                'id' => $id,
                'servidores' => $this->servidorModel->getServidores(),
                'bases' => $this->bdModel->getBasesDatosByServidor($base->servidor_id),
                'tablas' => $this->tablaModel->getTablasByBaseDatos($base->id),
                'servidor_id' => $base->servidor_id,
                'base_datos_id' => $base->id,
                'tabla_id' => $disp->tabla_id,
                'nombre' => $disp->nombre,
                'evento' => $disp->evento,
                'codigo' => $disp->codigo,
                'descripcion' => $disp->descripcion,
                'nombre_err' => '',
                'tabla_id_err' => '',
                'base_datos_id_err' => '',
                'servidor_id_err' => ''
            ];
            $this->view('disparadores/edit', $data);
        }
    }
    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { if($this->dispModel->deleteDisparador($id)) { flash('msg', 'Disparador eliminado'); redirect('disparadores'); } else die('Error'); } else redirect('disparadores');
    }

    public function versiones($id){
        $disparador = $this->dispModel->getDisparadorById($id);
        $versiones = $this->dispModel->getVersions($id);
        $data = [
            'objeto' => $disparador,
            'versiones' => $versiones,
            'titulo' => 'Versiones del Disparador'
        ];
        $this->view('disparadores/versiones', $data);
    }
}
