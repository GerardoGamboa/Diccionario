<?php
class Columnas extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->columnaModel = $this->model('Columna');
        $this->tablaModel = $this->model('Tabla');
    }
    public function index() {
        $columnas = $this->columnaModel->getColumnas();
        $this->view('columnas/index', ['columnas' => $columnas]);
    }
    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data = [
                'tabla_id' => trim($_POST['tabla_id']),
                'nombre' => trim($_POST['nombre']),
                'tipo_dato' => trim($_POST['tipo_dato']),
                'longitud' => trim($_POST['longitud']),
                'permite_nulo' => isset($_POST['permite_nulo']) ? 1 : 0,
                'es_llave' => isset($_POST['es_llave']) ? 1 : 0,
                'descripcion' => trim($_POST['descripcion']),
                'user_id' => $_SESSION['user_id'],
                'nombre_err' => ''
            ];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['nombre_err'])) {
                if($this->columnaModel->addColumna($data)) { flash('msg', 'Columna agregada'); redirect('columnas'); } else die('Error');
            } else { $data['tablas'] = $this->tablaModel->getTablas(); $this->view('columnas/add', $data); }
        } else {
            $data = [
                'tablas' => $this->tablaModel->getTablas(),
                'tabla_id' => '',
                'nombre' => '',
                'tipo_dato' => '',
                'longitud' => '',
                'permite_nulo' => 1,
                'es_llave' => 0,
                'descripcion' => '',
                'nombre_err' => ''
            ];
            $this->view('columnas/add', $data);
        }
    }
    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data = [
                'id' => $id,
                'tabla_id' => trim($_POST['tabla_id']),
                'nombre' => trim($_POST['nombre']),
                'tipo_dato' => trim($_POST['tipo_dato']),
                'longitud' => trim($_POST['longitud']),
                'permite_nulo' => isset($_POST['permite_nulo']) ? 1 : 0,
                'es_llave' => isset($_POST['es_llave']) ? 1 : 0,
                'descripcion' => trim($_POST['descripcion']),
                'nombre_err' => ''
            ];
            if(empty($data['nombre'])) $data['nombre_err'] = 'Ingrese nombre';
            if(empty($data['nombre_err'])) {
                if($this->columnaModel->updateColumna($data)) { flash('msg', 'Columna actualizada'); redirect('columnas'); } else die('Error');
            } else { $data['tablas'] = $this->tablaModel->getTablas(); $this->view('columnas/edit', $data); }
        } else {
            $columna = $this->columnaModel->getColumnaById($id);
            $data = [
                'id' => $id,
                'tablas' => $this->tablaModel->getTablas(),
                'tabla_id' => $columna->tabla_id,
                'nombre' => $columna->nombre,
                'tipo_dato' => $columna->tipo_dato,
                'longitud' => $columna->longitud,
                'permite_nulo' => $columna->permite_nulo,
                'es_llave' => $columna->es_llave,
                'descripcion' => $columna->descripcion,
                'nombre_err' => ''
            ];
            $this->view('columnas/edit', $data);
        }
    }
    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { if($this->columnaModel->deleteColumna($id)) { flash('msg', 'Columna eliminada'); redirect('columnas'); } else die('Error'); } else redirect('columnas');
    }
}
