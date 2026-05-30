<?php
class Columna {
    private $db;
    public function __construct() { $this->db = new Database; }
    public function getColumnas() {
        $this->db->query('SELECT dic_columnas.*, dic_columnas.id as columnaId, dic_tablas.nombre as tablaNombre, dic_users.name as creatorName
                          FROM dic_columnas
                          INNER JOIN dic_tablas ON dic_columnas.tabla_id = dic_tablas.id
                          LEFT JOIN dic_users ON dic_columnas.usuario_creador = dic_users.id
                          ORDER BY dic_columnas.fecha_creacion DESC');
        return $this->db->resultSet();
    }
    public function addColumna($data) {
        $this->db->query('INSERT INTO dic_columnas (tabla_id, nombre, tipo_dato, longitud, permite_nulo, es_llave, descripcion, usuario_creador)
                          VALUES (:tabla_id, :nombre, :tipo_dato, :longitud, :permite_nulo, :es_llave, :descripcion, :usuario_creador)');
        $this->db->bind(':tabla_id', $data['tabla_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':tipo_dato', $data['tipo_dato']);
        $this->db->bind(':longitud', $data['longitud']);
        $this->db->bind(':permite_nulo', $data['permite_nulo']);
        $this->db->bind(':es_llave', $data['es_llave']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':usuario_creador', $data['user_id']);
        return $this->db->execute();
    }
    public function getColumnaById($id) {
        $this->db->query('SELECT * FROM dic_columnas WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function updateColumna($data) {
        $this->db->query('UPDATE dic_columnas SET tabla_id = :tabla_id, nombre = :nombre, tipo_dato = :tipo_dato, longitud = :longitud, permite_nulo = :permite_nulo, es_llave = :es_llave, descripcion = :descripcion WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':tabla_id', $data['tabla_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':tipo_dato', $data['tipo_dato']);
        $this->db->bind(':longitud', $data['longitud']);
        $this->db->bind(':permite_nulo', $data['permite_nulo']);
        $this->db->bind(':es_llave', $data['es_llave']);
        $this->db->bind(':descripcion', $data['descripcion']);
        return $this->db->execute();
    }
    public function deleteColumna($id) {
        $this->db->query('DELETE FROM dic_columnas WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
