<?php
class Reporte {
    private $db;
    public function __construct() { $this->db = new Database; }

    public function getTablasReporte($base_datos_id = null) {
        $sql = 'SELECT t.*, bd.nombre as bdNombre, s.nombre as servidorNombre
                FROM dic_tablas t
                INNER JOIN dic_bases_datos bd ON t.base_datos_id = bd.id
                INNER JOIN dic_servidores s ON bd.servidor_id = s.id';
        if($base_datos_id) {
            $sql .= ' WHERE t.base_datos_id = :base_datos_id';
        }
        $sql .= ' ORDER BY bd.nombre, t.nombre';
        $this->db->query($sql);
        if($base_datos_id) $this->db->bind(':base_datos_id', $base_datos_id);
        return $this->db->resultSet();
    }

    public function getColumnasPorTabla($tabla_id) {
        $this->db->query('SELECT * FROM dic_columnas WHERE tabla_id = :tabla_id ORDER BY id ASC');
        $this->db->bind(':tabla_id', $tabla_id);
        return $this->db->resultSet();
    }

    public function getProcedimientosReporte($base_datos_id = null) {
        $sql = 'SELECT p.*, bd.nombre as bdNombre FROM dic_procedimientos p
                INNER JOIN dic_bases_datos bd ON p.base_datos_id = bd.id';
        if($base_datos_id) $sql .= ' WHERE p.base_datos_id = :base_datos_id';
        $sql .= ' ORDER BY bd.nombre, p.nombre';
        $this->db->query($sql);
        if($base_datos_id) $this->db->bind(':base_datos_id', $base_datos_id);
        return $this->db->resultSet();
    }

    public function getFuncionesReporte($base_datos_id = null) {
        $sql = 'SELECT f.*, bd.nombre as bdNombre FROM dic_funciones f
                INNER JOIN dic_bases_datos bd ON f.base_datos_id = bd.id';
        if($base_datos_id) $sql .= ' WHERE f.base_datos_id = :base_datos_id';
        $sql .= ' ORDER BY bd.nombre, f.nombre';
        $this->db->query($sql);
        if($base_datos_id) $this->db->bind(':base_datos_id', $base_datos_id);
        return $this->db->resultSet();
    }

    public function getDisparadoresReporte($base_datos_id = null) {
        $sql = 'SELECT d.*, t.nombre as tablaNombre, bd.nombre as bdNombre
                FROM dic_disparadores d
                INNER JOIN dic_tablas t ON d.tabla_id = t.id
                INNER JOIN dic_bases_datos bd ON t.base_datos_id = bd.id';
        if($base_datos_id) $sql .= ' WHERE t.base_datos_id = :base_datos_id';
        $sql .= ' ORDER BY bd.nombre, d.nombre';
        $this->db->query($sql);
        if($base_datos_id) $this->db->bind(':base_datos_id', $base_datos_id);
        return $this->db->resultSet();
    }

    public function getScriptsReporte($filtro_codigo = null) {
        $sql = 'SELECT s.*, serv.nombre as servidorNombre
                FROM dic_scripts s
                INNER JOIN dic_servidores serv ON s.servidor_id = serv.id';
        if($filtro_codigo) {
            $sql .= ' WHERE s.codigo LIKE :filtro';
        }
        $sql .= ' ORDER BY s.fecha_aplicacion DESC';
        $this->db->query($sql);
        if($filtro_codigo) $this->db->bind(':filtro', '%' . $filtro_codigo . '%');
        return $this->db->resultSet();
    }
}
