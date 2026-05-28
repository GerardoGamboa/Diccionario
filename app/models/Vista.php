<?php
class Vista {
    private $db;
    public function __construct() { $this->db = new Database; }
    public function getVistas() {
        $this->db->query('SELECT vistas.*, vistas.id as vistaId, bases_datos.nombre as bdNombre, users.name as creatorName
                          FROM vistas
                          INNER JOIN bases_datos ON vistas.base_datos_id = bases_datos.id
                          LEFT JOIN users ON vistas.usuario_creador = users.id
                          ORDER BY vistas.fecha_creacion DESC');
        return $this->db->resultSet();
    }
    public function addVista($data) {
        $this->db->query('INSERT INTO vistas (base_datos_id, nombre, codigo, descripcion, usuario_creador) VALUES (:base_datos_id, :nombre, :codigo, :descripcion, :usuario_creador)');
        $this->db->bind(':base_datos_id', $data['base_datos_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':codigo', $data['codigo']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':usuario_creador', $data['user_id']);
        return $this->db->execute();
    }
    public function getVistaById($id) {
        $this->db->query('SELECT * FROM vistas WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function updateVista($data) {
        $this->db->query('UPDATE vistas SET base_datos_id = :base_datos_id, nombre = :nombre, codigo = :codigo, descripcion = :descripcion WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':base_datos_id', $data['base_datos_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':codigo', $data['codigo']);
        $this->db->bind(':descripcion', $data['descripcion']);
        return $this->db->execute();
    }
    public function deleteVista($id) {
        $this->db->query('DELETE FROM vistas WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
