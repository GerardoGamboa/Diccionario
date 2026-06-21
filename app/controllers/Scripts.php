<?php
class Scripts extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->scriptModel = $this->model('Script');
        $this->servidorModel = $this->model('Servidor');
    }

    public function index() {
        $scripts = $this->scriptModel->getScripts();
        $this->view('scripts/index', ['scripts' => $scripts]);
    }

    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'servidor_id' => trim($_POST['servidor_id']),
                'fecha_aplicacion' => trim($_POST['fecha_aplicacion']),
                'solicitante' => trim($_POST['solicitante']),
                'codigo' => trim($_POST['codigo']),
                'resultado' => trim($_POST['resultado']),
                'ejecutor' => trim($_POST['ejecutor']),
                'servidor_id_err' => '',
                'fecha_aplicacion_err' => '',
                'solicitante_err' => '',
                'codigo_err' => '',
                'ejecutor_err' => ''
            ];

            if(empty($data['servidor_id'])) $data['servidor_id_err'] = 'Seleccione servidor';
            if(empty($data['fecha_aplicacion'])) $data['fecha_aplicacion_err'] = 'Ingrese fecha';
            if(empty($data['solicitante'])) $data['solicitante_err'] = 'Ingrese solicitante';
            if(empty($data['codigo'])) $data['codigo_err'] = 'Ingrese código';
            if(empty($data['ejecutor'])) $data['ejecutor_err'] = 'Ingrese ejecutor';

            if(empty($data['servidor_id_err']) && empty($data['fecha_aplicacion_err']) && empty($data['solicitante_err']) && empty($data['codigo_err']) && empty($data['ejecutor_err'])) {
                if($this->scriptModel->addScript($data)) {
                    flash('msg', 'Script registrado');
                    redirect('scripts');
                } else die('Error');
            } else {
                $data['servidores'] = $this->servidorModel->getServidores();
                $this->view('scripts/add', $data);
            }
        } else {
            $data = [
                'servidores' => $this->servidorModel->getServidores(),
                'servidor_id' => '',
                'fecha_aplicacion' => date('Y-m-d'),
                'solicitante' => '',
                'codigo' => '',
                'resultado' => '',
                'ejecutor' => '',
                'servidor_id_err' => '',
                'fecha_aplicacion_err' => '',
                'solicitante_err' => '',
                'codigo_err' => '',
                'ejecutor_err' => ''
            ];
            $this->view('scripts/add', $data);
        }
    }

    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'id' => $id,
                'servidor_id' => trim($_POST['servidor_id']),
                'fecha_aplicacion' => trim($_POST['fecha_aplicacion']),
                'solicitante' => trim($_POST['solicitante']),
                'codigo' => trim($_POST['codigo']),
                'resultado' => trim($_POST['resultado']),
                'ejecutor' => trim($_POST['ejecutor']),
                'servidor_id_err' => '',
                'fecha_aplicacion_err' => '',
                'solicitante_err' => '',
                'codigo_err' => '',
                'ejecutor_err' => ''
            ];

            if(empty($data['servidor_id'])) $data['servidor_id_err'] = 'Seleccione servidor';
            if(empty($data['fecha_aplicacion'])) $data['fecha_aplicacion_err'] = 'Ingrese fecha';
            if(empty($data['solicitante'])) $data['solicitante_err'] = 'Ingrese solicitante';
            if(empty($data['codigo'])) $data['codigo_err'] = 'Ingrese código';
            if(empty($data['ejecutor'])) $data['ejecutor_err'] = 'Ingrese ejecutor';

            if(empty($data['servidor_id_err']) && empty($data['fecha_aplicacion_err']) && empty($data['solicitante_err']) && empty($data['codigo_err']) && empty($data['ejecutor_err'])) {
                if($this->scriptModel->updateScript($data)) {
                    flash('msg', 'Script actualizado');
                    redirect('scripts');
                } else die('Error');
            } else {
                $data['servidores'] = $this->servidorModel->getServidores();
                $this->view('scripts/edit', $data);
            }
        } else {
            $script = $this->scriptModel->getScriptById($id);
            $data = [
                'id' => $id,
                'servidores' => $this->servidorModel->getServidores(),
                'servidor_id' => $script->servidor_id,
                'fecha_aplicacion' => $script->fecha_aplicacion,
                'solicitante' => $script->solicitante,
                'codigo' => $script->codigo,
                'resultado' => $script->resultado,
                'ejecutor' => $script->ejecutor,
                'servidor_id_err' => '',
                'fecha_aplicacion_err' => '',
                'solicitante_err' => '',
                'codigo_err' => '',
                'ejecutor_err' => ''
            ];
            $this->view('scripts/edit', $data);
        }
    }

    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->scriptModel->deleteScript($id)) {
                flash('msg', 'Script eliminado');
                redirect('scripts');
            } else die('Error');
        } else redirect('scripts');
    }
}
