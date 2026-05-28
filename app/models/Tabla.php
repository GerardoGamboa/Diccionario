<?php
class Tabla {
    private $db;
    public function __construct() { $this->db = new Database; }
    public function getTablas() {
        $this->db->query('SELECT tablas.*, tablas.id as tablaId, bases_datos.nombre as bdNombre, users.name as creatorName
                          FROM tablas
                          INNER JOIN bases_datos ON tablas.base_datos_id = bases_datos.id
                          LEFT JOIN users ON tablas.usuario_creador = users.id
                          ORDER BY tablas.fecha_creacion DESC');
        return $this->db->resultSet();
    }
    public function addTabla($data) {
        $this->db->query('INSERT INTO tablas (base_datos_id, nombre, descripcion, usuario_creador) VALUES (:base_datos_id, :nombre, :descripcion, :usuario_creador)');
        $this->db->bind(':base_datos_id', $data['base_datos_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':usuario_creador', $data['user_id']);
        return $this->db->execute();
    }
    public function getTablaById($id) {
        $this->db->query('SELECT * FROM tablas WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function updateTabla($data) {
        $this->db->query('UPDATE tablas SET base_datos_id = :base_datos_id, nombre = :nombre, descripcion = :descripcion WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':base_datos_id', $data['base_datos_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':descripcion', $data['descripcion']);
        return $this->db->execute();
    }
    public function deleteTabla($id) {
        $this->db->query('DELETE FROM tablas WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
