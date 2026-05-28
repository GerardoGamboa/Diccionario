<?php
class Columna {
    private $db;
    public function __construct() { $this->db = new Database; }
    public function getColumnas() {
        $this->db->query('SELECT columnas.*, columnas.id as columnaId, tablas.nombre as tablaNombre, users.name as creatorName
                          FROM columnas
                          INNER JOIN tablas ON columnas.tabla_id = tablas.id
                          LEFT JOIN users ON columnas.usuario_creador = users.id
                          ORDER BY columnas.fecha_creacion DESC');
        return $this->db->resultSet();
    }
    public function addColumna($data) {
        $this->db->query('INSERT INTO columnas (tabla_id, nombre, tipo_dato, longitud, permite_nulo, descripcion, usuario_creador)
                          VALUES (:tabla_id, :nombre, :tipo_dato, :longitud, :permite_nulo, :descripcion, :usuario_creador)');
        $this->db->bind(':tabla_id', $data['tabla_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':tipo_dato', $data['tipo_dato']);
        $this->db->bind(':longitud', $data['longitud']);
        $this->db->bind(':permite_nulo', $data['permite_nulo']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':usuario_creador', $data['user_id']);
        return $this->db->execute();
    }
    public function getColumnaById($id) {
        $this->db->query('SELECT * FROM columnas WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function updateColumna($data) {
        $this->db->query('UPDATE columnas SET tabla_id = :tabla_id, nombre = :nombre, tipo_dato = :tipo_dato, longitud = :longitud, permite_nulo = :permite_nulo, descripcion = :descripcion WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':tabla_id', $data['tabla_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':tipo_dato', $data['tipo_dato']);
        $this->db->bind(':longitud', $data['longitud']);
        $this->db->bind(':permite_nulo', $data['permite_nulo']);
        $this->db->bind(':descripcion', $data['descripcion']);
        return $this->db->execute();
    }
    public function deleteColumna($id) {
        $this->db->query('DELETE FROM columnas WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
