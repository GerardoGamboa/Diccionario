<?php
class Procedimiento {
    private $db;
    public function __construct() { $this->db = new Database; }
    public function getProcedimientos() {
        $this->db->query('SELECT dic_procedimientos.*, dic_procedimientos.id as procId, dic_bases_datos.nombre as bdNombre, dic_users.name as creatorName
                          FROM dic_procedimientos
                          INNER JOIN dic_bases_datos ON dic_procedimientos.base_datos_id = dic_bases_datos.id
                          LEFT JOIN dic_users ON dic_procedimientos.usuario_creador = dic_users.id
                          ORDER BY dic_procedimientos.fecha_creacion DESC');
        return $this->db->resultSet();
    }
    public function addProcedimiento($data) {
        $this->db->query('INSERT INTO dic_procedimientos (base_datos_id, nombre, codigo, descripcion, usuario_creador) VALUES (:base_datos_id, :nombre, :codigo, :descripcion, :usuario_creador)');
        $this->db->bind(':base_datos_id', $data['base_datos_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':codigo', $data['codigo']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':usuario_creador', $data['user_id']);
        return $this->db->execute();
    }
    public function getProcedimientoById($id) {
        $this->db->query('SELECT * FROM dic_procedimientos WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function updateProcedimiento($data) {
        $this->db->query('UPDATE dic_procedimientos SET base_datos_id = :base_datos_id, nombre = :nombre, codigo = :codigo, descripcion = :descripcion WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':base_datos_id', $data['base_datos_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':codigo', $data['codigo']);
        $this->db->bind(':descripcion', $data['descripcion']);
        return $this->db->execute();
    }
    public function deleteProcedimiento($id) {
        $this->db->query('DELETE FROM dic_procedimientos WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
