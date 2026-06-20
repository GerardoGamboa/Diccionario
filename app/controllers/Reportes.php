<?php
class Reportes extends Controller {
    public function __construct() {
        if(!isLoggedIn()) redirect('users/login');
        $this->reporteModel = $this->model('Reporte');
        $this->bdModel = $this->model('BaseDatos');
    }

    public function tablas() {
        $base_datos_id = isset($_GET['base_datos_id']) && !empty($_GET['base_datos_id']) ? $_GET['base_datos_id'] : null;

        $tablas_raw = $this->reporteModel->getTablasReporte($base_datos_id);
        $tablas = [];

        foreach($tablas_raw as $tabla) {
            $tabla->columnas = $this->reporteModel->getColumnasPorTabla($tabla->id);
            $tablas[] = $tabla;
        }

        $bases = $this->bdModel->getBasesDatos();

        $data = [
            'tablas' => $tablas,
            'bases' => $bases,
            'base_datos_id' => $base_datos_id
        ];

        if(isset($_GET['pdf'])) {
            $this->generatePdf('reportes/tablas_pdf', $data, 'Reporte_Diccionario.pdf');
        } else {
            $this->view('reportes/tablas', $data);
        }
    }

    public function objetos() {
        $base_datos_id = isset($_GET['base_datos_id']) && !empty($_GET['base_datos_id']) ? $_GET['base_datos_id'] : null;

        $procedimientos = $this->reporteModel->getProcedimientosReporte($base_datos_id);
        $funciones = $this->reporteModel->getFuncionesReporte($base_datos_id);
        $disparadores = $this->reporteModel->getDisparadoresReporte($base_datos_id);

        $bases = $this->bdModel->getBasesDatos();

        $data = [
            'procedimientos' => $procedimientos,
            'funciones' => $funciones,
            'disparadores' => $disparadores,
            'bases' => $bases,
            'base_datos_id' => $base_datos_id
        ];

        if(isset($_GET['pdf'])) {
            $this->generatePdf('reportes/objetos_pdf', $data, 'Reporte_Objetos.pdf');
        } else {
            $this->view('reportes/objetos', $data);
        }
    }

    private function generatePdf($view, $data, $filename) {
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->set_option('isRemoteEnabled', true);

        // Capture view output
        ob_start();
        $this->view($view, $data);
        $html = ob_get_clean();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($filename, ["Attachment" => true]);
        exit;
    }
}
