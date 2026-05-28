<?php
class Disparador {
    private $db;
    public function __construct() { $this->db = new Database; }
    public function getDisparadores() {
        $this->db->query('SELECT disparadores.*, disparadores.id as dispId, tablas.nombre as tablaNombre, users.name as creatorName
                          FROM disparadores
                          INNER JOIN tablas ON disparadores.tabla_id = tablas.id
                          LEFT JOIN users ON disparadores.usuario_creador = users.id
                          ORDER BY disparadores.fecha_creacion DESC');
        return $this->db->resultSet();
    }
    public function addDisparador($data) {
        $this->db->query('INSERT INTO disparadores (tabla_id, nombre, evento, codigo, descripcion, usuario_creador) VALUES (:tabla_id, :nombre, :evento, :codigo, :descripcion, :usuario_creador)');
        $this->db->bind(':tabla_id', $data['tabla_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':evento', $data['evento']);
        $this->db->bind(':codigo', $data['codigo']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':usuario_creador', $data['user_id']);
        return $this->db->execute();
    }
    public function getDisparadorById($id) {
        $this->db->query('SELECT * FROM disparadores WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function updateDisparador($data) {
        $this->db->query('UPDATE disparadores SET tabla_id = :tabla_id, nombre = :nombre, evento = :evento, codigo = :codigo, descripcion = :descripcion WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':tabla_id', $data['tabla_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':evento', $data['evento']);
        $this->db->bind(':codigo', $data['codigo']);
        $this->db->bind(':descripcion', $data['descripcion']);
        return $this->db->execute();
    }
    public function deleteDisparador($id) {
        $this->db->query('DELETE FROM disparadores WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
