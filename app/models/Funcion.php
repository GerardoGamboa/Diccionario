<?php
class Funcion {
    private $db;
    public function __construct() { $this->db = new Database; }
    public function getFunciones() {
        $this->db->query('SELECT funciones.*, funciones.id as funcId, bases_datos.nombre as bdNombre, users.name as creatorName
                          FROM funciones
                          INNER JOIN bases_datos ON funciones.base_datos_id = bases_datos.id
                          LEFT JOIN users ON funciones.usuario_creador = users.id
                          ORDER BY funciones.fecha_creacion DESC');
        return $this->db->resultSet();
    }
    public function addFuncion($data) {
        $this->db->query('INSERT INTO funciones (base_datos_id, nombre, definicion, descripcion, usuario_creador) VALUES (:base_datos_id, :nombre, :definicion, :descripcion, :usuario_creador)');
        $this->db->bind(':base_datos_id', $data['base_datos_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':definicion', $data['definicion']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':usuario_creador', $data['user_id']);
        return $this->db->execute();
    }
    public function getFuncionById($id) {
        $this->db->query('SELECT * FROM funciones WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function updateFuncion($data) {
        $this->db->query('UPDATE funciones SET base_datos_id = :base_datos_id, nombre = :nombre, definicion = :definicion, descripcion = :descripcion WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':base_datos_id', $data['base_datos_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':definicion', $data['definicion']);
        $this->db->bind(':descripcion', $data['descripcion']);
        return $this->db->execute();
    }
    public function deleteFuncion($id) {
        $this->db->query('DELETE FROM funciones WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
