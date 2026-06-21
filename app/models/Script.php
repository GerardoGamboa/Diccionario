<?php
class Script {
    private $db;
    public function __construct() { $this->db = new Database; }

    public function getScripts() {
        $this->db->query('SELECT s.*, s.id as scriptId, serv.nombre as servidorNombre, u.name as creatorName
                          FROM dic_scripts s
                          INNER JOIN dic_servidores serv ON s.servidor_id = serv.id
                          LEFT JOIN dic_usuarios u ON s.usuario_creador = u.id
                          ORDER BY s.fecha_registro DESC');
        return $this->db->resultSet();
    }

    public function addScript($data) {
        $this->db->query('INSERT INTO dic_scripts (servidor_id, fecha_aplicacion, solicitante, codigo, resultado, ejecutor, usuario_creador)
                          VALUES (:servidor_id, :fecha_aplicacion, :solicitante, :codigo, :resultado, :ejecutor, :usuario_creador)');
        $this->db->bind(':servidor_id', $data['servidor_id']);
        $this->db->bind(':fecha_aplicacion', $data['fecha_aplicacion']);
        $this->db->bind(':solicitante', $data['solicitante']);
        $this->db->bind(':codigo', $data['codigo']);
        $this->db->bind(':resultado', $data['resultado']);
        $this->db->bind(':ejecutor', $data['ejecutor']);
        $this->db->bind(':usuario_creador', $_SESSION['user_id']);
        return $this->db->execute();
    }

    public function getScriptById($id) {
        $this->db->query('SELECT * FROM dic_scripts WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateScript($data) {
        $this->db->query('UPDATE dic_scripts SET servidor_id = :servidor_id, fecha_aplicacion = :fecha_aplicacion, solicitante = :solicitante, codigo = :codigo, resultado = :resultado, ejecutor = :ejecutor WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':servidor_id', $data['servidor_id']);
        $this->db->bind(':fecha_aplicacion', $data['fecha_aplicacion']);
        $this->db->bind(':solicitante', $data['solicitante']);
        $this->db->bind(':codigo', $data['codigo']);
        $this->db->bind(':resultado', $data['resultado']);
        $this->db->bind(':ejecutor', $data['ejecutor']);
        return $this->db->execute();
    }

    public function deleteScript($id) {
        $this->db->query('DELETE FROM dic_scripts WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
