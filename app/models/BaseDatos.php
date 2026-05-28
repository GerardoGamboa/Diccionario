<?php
class BaseDatos {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getBasesDatos() {
        $this->db->query('SELECT bases_datos.*, bases_datos.id as bdId, servidores.nombre as servidorNombre, users.name as creatorName
                          FROM bases_datos
                          INNER JOIN servidores ON bases_datos.servidor_id = servidores.id
                          LEFT JOIN users ON bases_datos.usuario_creador = users.id
                          ORDER BY bases_datos.fecha_creacion DESC');
        return $this->db->resultSet();
    }

    public function addBaseDatos($data) {
        $this->db->query('INSERT INTO bases_datos (servidor_id, nombre, descripcion, usuario_creador)
                          VALUES (:servidor_id, :nombre, :descripcion, :usuario_creador)');
        $this->db->bind(':servidor_id', $data['servidor_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':usuario_creador', $data['user_id']);
        return $this->db->execute();
    }

    public function getBaseDatosById($id) {
        $this->db->query('SELECT * FROM bases_datos WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateBaseDatos($data) {
        $this->db->query('UPDATE bases_datos SET servidor_id = :servidor_id, nombre = :nombre, descripcion = :descripcion WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':servidor_id', $data['servidor_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':descripcion', $data['descripcion']);
        return $this->db->execute();
    }

    public function deleteBaseDatos($id) {
        $this->db->query('DELETE FROM bases_datos WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
