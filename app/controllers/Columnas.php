<?php
class Columnas extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->columnaModel = $this->model('Columna');
        $this->tablaModel = $this->model('Tabla');
        $this->bdModel = $this->model('BaseDatos');
        $this->servidorModel = $this->model('Servidor');
    }
    public function index() {
        $columnas = $this->columnaModel->getColumnas();
        $this->view('columnas/index', ['columnas' => $columnas]);
    }
    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'servidor_id' => trim($_POST['servidor_id']),
                'base_datos_id' => trim($_POST['base_datos_id']),
                'tabla_id' => trim($_POST['tabla_id']),
                'nombre' => trim($_POST['nombre']),
                'tipo_dato' => trim($_POST['tipo_dato']),
                'longitud' => trim($_POST['longitud']),
                'permite_nulo' => isset($_POST['permite_nulo']) ? 1 : 0,
                'es_llave' => isset($_POST['es_llave']) ? 1 : 0,
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
                if($this->columnaModel->addColumna($data)) { flash('msg', 'Columna agregada'); redirect('columnas'); } else die('Error');
            } else {
                $data['servidores'] = $this->servidorModel->getServidores();
                $data['bases'] = !empty($data['servidor_id']) ? $this->bdModel->getBasesDatosByServidor($data['servidor_id']) : [];
                $data['tablas'] = !empty($data['base_datos_id']) ? $this->tablaModel->getTablasByBaseDatos($data['base_datos_id']) : [];
                $this->view('columnas/add', $data);
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
                'tipo_dato' => '',
                'longitud' => '',
                'permite_nulo' => 1,
                'es_llave' => 0,
                'descripcion' => '',
                'nombre_err' => '',
                'tabla_id_err' => '',
                'base_datos_id_err' => '',
                'servidor_id_err' => ''
            ];
            $this->view('columnas/add', $data);
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
                'tipo_dato' => trim($_POST['tipo_dato']),
                'longitud' => trim($_POST['longitud']),
                'permite_nulo' => isset($_POST['permite_nulo']) ? 1 : 0,
                'es_llave' => isset($_POST['es_llave']) ? 1 : 0,
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
                if($this->columnaModel->updateColumna($data)) { flash('msg', 'Columna actualizada'); redirect('columnas'); } else die('Error');
            } else {
                $data['servidores'] = $this->servidorModel->getServidores();
                $data['bases'] = !empty($data['servidor_id']) ? $this->bdModel->getBasesDatosByServidor($data['servidor_id']) : [];
                $data['tablas'] = !empty($data['base_datos_id']) ? $this->tablaModel->getTablasByBaseDatos($data['base_datos_id']) : [];
                $this->view('columnas/edit', $data);
            }
        } else {
            $columna = $this->columnaModel->getColumnaById($id);
            $tabla = $this->tablaModel->getTablaById($columna->tabla_id);
            $base = $this->bdModel->getBaseDatosById($tabla->base_datos_id);
            $data = [
                'id' => $id,
                'servidores' => $this->servidorModel->getServidores(),
                'bases' => $this->bdModel->getBasesDatosByServidor($base->servidor_id),
                'tablas' => $this->tablaModel->getTablasByBaseDatos($base->id),
                'servidor_id' => $base->servidor_id,
                'base_datos_id' => $base->id,
                'tabla_id' => $columna->tabla_id,
                'nombre' => $columna->nombre,
                'tipo_dato' => $columna->tipo_dato,
                'longitud' => $columna->longitud,
                'permite_nulo' => $columna->permite_nulo,
                'es_llave' => $columna->es_llave,
                'descripcion' => $columna->descripcion,
                'nombre_err' => '',
                'tabla_id_err' => '',
                'base_datos_id_err' => '',
                'servidor_id_err' => ''
            ];
            $this->view('columnas/edit', $data);
        }
    }
    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { if($this->columnaModel->deleteColumna($id)) { flash('msg', 'Columna eliminada'); redirect('columnas'); } else die('Error'); } else redirect('columnas');
    }
}
