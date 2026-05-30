<?php
class BaseDatos {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getBasesDatos() {
        $this->db->query('SELECT dic_bases_datos.*, dic_bases_datos.id as bdId, dic_servidores.nombre as servidorNombre, dic_users.name as creatorName
                          FROM dic_bases_datos
                          INNER JOIN dic_servidores ON dic_bases_datos.servidor_id = dic_servidores.id
                          LEFT JOIN dic_users ON dic_bases_datos.usuario_creador = dic_users.id
                          ORDER BY dic_bases_datos.fecha_creacion DESC');
        return $this->db->resultSet();
    }

    public function addBaseDatos($data) {
        $this->db->query('INSERT INTO dic_bases_datos (servidor_id, nombre, descripcion, usuario_creador)
                          VALUES (:servidor_id, :nombre, :descripcion, :usuario_creador)');
        $this->db->bind(':servidor_id', $data['servidor_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':usuario_creador', $data['user_id']);
        return $this->db->execute();
    }

    public function getBaseDatosById($id) {
        $this->db->query('SELECT * FROM dic_bases_datos WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateBaseDatos($data) {
        $this->db->query('UPDATE dic_bases_datos SET servidor_id = :servidor_id, nombre = :nombre, descripcion = :descripcion WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':servidor_id', $data['servidor_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':descripcion', $data['descripcion']);
        return $this->db->execute();
    }

    public function deleteBaseDatos($id) {
        $this->db->query('DELETE FROM dic_bases_datos WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
