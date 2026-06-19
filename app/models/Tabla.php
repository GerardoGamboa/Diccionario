<?php
class Tabla {
    private $db;
    public function __construct() { $this->db = new Database; }
    public function getTablas() {
        $this->db->query('SELECT dic_tablas.*, dic_tablas.id as tablaId, dic_bases_datos.nombre as bdNombre, dic_usuarios.name as creatorName
                          FROM dic_tablas
                          INNER JOIN dic_bases_datos ON dic_tablas.base_datos_id = dic_bases_datos.id
                          LEFT JOIN dic_usuarios ON dic_tablas.usuario_creador = dic_usuarios.id
                          ORDER BY dic_tablas.fecha_creacion DESC');
        return $this->db->resultSet();
    }
    public function addTabla($data) {
        $this->db->query('INSERT INTO dic_tablas (base_datos_id, nombre, descripcion, usuario_creador) VALUES (:base_datos_id, :nombre, :descripcion, :usuario_creador)');
        $this->db->bind(':base_datos_id', $data['base_datos_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':usuario_creador', $data['user_id']);
        return $this->db->execute();
    }
    public function getTablaById($id) {
        $this->db->query('SELECT * FROM dic_tablas WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getTablasByBaseDatos($base_datos_id) {
        $this->db->query('SELECT * FROM dic_tablas WHERE base_datos_id = :base_datos_id ORDER BY nombre ASC');
        $this->db->bind(':base_datos_id', $base_datos_id);
        return $this->db->resultSet();
    }
    public function updateTabla($data) {
        $this->db->query('UPDATE dic_tablas SET base_datos_id = :base_datos_id, nombre = :nombre, descripcion = :descripcion WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':base_datos_id', $data['base_datos_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':descripcion', $data['descripcion']);
        return $this->db->execute();
    }
    public function deleteTabla($id) {
        $this->db->query('DELETE FROM dic_tablas WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
