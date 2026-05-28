<?php
class Servidor {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getServidores() {
        $this->db->query('SELECT *, servidores.id as servidorId, users.name as creatorName
                          FROM servidores
                          LEFT JOIN users ON servidores.usuario_creador = users.id
                          ORDER BY servidores.fecha_creacion DESC');
        return $this->db->resultSet();
    }

    public function addServidor($data) {
        $this->db->query('INSERT INTO servidores (nombre, ip, puerto, motor, descripcion, usuario_creador)
                          VALUES (:nombre, :ip, :puerto, :motor, :descripcion, :usuario_creador)');
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':ip', $data['ip']);
        $this->db->bind(':puerto', $data['puerto']);
        $this->db->bind(':motor', $data['motor']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':usuario_creador', $data['user_id']);
        return $this->db->execute();
    }

    public function getServidorById($id) {
        $this->db->query('SELECT * FROM servidores WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateServidor($data) {
        $this->db->query('UPDATE servidores SET nombre = :nombre, ip = :ip, puerto = :puerto, motor = :motor, descripcion = :descripcion WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':ip', $data['ip']);
        $this->db->bind(':puerto', $data['puerto']);
        $this->db->bind(':motor', $data['motor']);
        $this->db->bind(':descripcion', $data['descripcion']);
        return $this->db->execute();
    }

    public function deleteServidor($id) {
        $this->db->query('DELETE FROM servidores WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
