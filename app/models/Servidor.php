<?php
class Servidor {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getServidores() {
        $this->db->query('SELECT *, dic_servidores.id as servidorId, dic_usuarios.name as creatorName
                          FROM dic_servidores
                          LEFT JOIN dic_usuarios ON dic_servidores.usuario_creador = dic_usuarios.id
                          ORDER BY dic_servidores.fecha_creacion DESC');
        return $this->db->resultSet();
    }

    public function addServidor($data) {
        $this->db->query('INSERT INTO dic_servidores (nombre, ip, puerto, motor, descripcion, usuario_creador)
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
        $this->db->query('SELECT * FROM dic_servidores WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateServidor($data) {
        $this->db->query('UPDATE dic_servidores SET nombre = :nombre, ip = :ip, puerto = :puerto, motor = :motor, descripcion = :descripcion WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':ip', $data['ip']);
        $this->db->bind(':puerto', $data['puerto']);
        $this->db->bind(':motor', $data['motor']);
        $this->db->bind(':descripcion', $data['descripcion']);
        return $this->db->execute();
    }

    public function deleteServidor($id) {
        $this->db->query('DELETE FROM dic_servidores WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
