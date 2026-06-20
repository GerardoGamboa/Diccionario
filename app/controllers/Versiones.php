<?php
class Versiones extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->versionModel = $this->model('Version');
    }

    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get version info to know where to redirect
            $version = $this->versionModel->getVersionById($id);
            if(!$version) die('Versión no encontrada');

            $objeto_id = $version->objeto_id;
            $tipo = $version->tipo_objeto; // procedimiento, funcion, disparador, vista

            // Check if it is the last version
            if($this->versionModel->isLastVersion($objeto_id, $tipo, $version->consecutivo)) {
                flash('msg', 'No se puede eliminar la última versión del objeto', 'alert alert-danger');
                $this->redirectByType($tipo, $objeto_id);
                return;
            }

            if($this->versionModel->deleteVersion($id)) {
                flash('msg', 'Versión eliminada');
                $this->redirectByType($tipo, $objeto_id);
            } else {
                die('Error al eliminar');
            }
        } else {
            redirect('pages/index');
        }
    }

    private function redirectByType($tipo, $objeto_id) {
        switch($tipo) {
            case 'procedimiento': redirect('procedimientos/versiones/' . $objeto_id); break;
            case 'funcion': redirect('funciones/versiones/' . $objeto_id); break;
            case 'disparador': redirect('disparadores/versiones/' . $objeto_id); break;
            case 'vista': redirect('vistas/versiones/' . $objeto_id); break;
            default: redirect('pages/index');
        }
    }
}
