<?php
class Funcion {
    private $db;
    public function __construct() { $this->db = new Database; }
    public function getFunciones() {
        $this->db->query('SELECT dic_funciones.*, dic_funciones.id as funcId, dic_bases_datos.nombre as bdNombre, dic_usuarios.name as creatorName
                          FROM dic_funciones
                          INNER JOIN dic_bases_datos ON dic_funciones.base_datos_id = dic_bases_datos.id
                          LEFT JOIN dic_usuarios ON dic_funciones.usuario_creador = dic_usuarios.id
                          ORDER BY dic_funciones.fecha_creacion DESC');
        return $this->db->resultSet();
    }
    public function addFuncion($data) {
        $this->db->query('INSERT INTO dic_funciones (base_datos_id, nombre, codigo, descripcion, usuario_creador) VALUES (:base_datos_id, :nombre, :codigo, :descripcion, :usuario_creador)');
        $this->db->bind(':base_datos_id', $data['base_datos_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':codigo', $data['codigo']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':usuario_creador', $data['user_id']);

        if($this->db->execute()){
            $objeto_id = $this->db->lastInsertId();
            return $this->addVersion($objeto_id, 'funcion', $data);
        } else {
            return false;
        }
    }
    public function getFuncionById($id) {
        $this->db->query('SELECT * FROM dic_funciones WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function updateFuncion($data) {
        $this->db->query('UPDATE dic_funciones SET base_datos_id = :base_datos_id, nombre = :nombre, codigo = :codigo, descripcion = :descripcion WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':base_datos_id', $data['base_datos_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':codigo', $data['codigo']);
        $this->db->bind(':descripcion', $data['descripcion']);

        if($this->db->execute()){
            return $this->addVersion($data['id'], 'funcion', $data);
        } else {
            return false;
        }
    }

    private function addVersion($objeto_id, $tipo, $data){
        // Get last consecutivo
        $this->db->query('SELECT MAX(consecutivo) as last_c FROM dic_versiones WHERE objeto_id = :objeto_id AND tipo_objeto = :tipo_objeto');
        $this->db->bind(':objeto_id', $objeto_id);
        $this->db->bind(':tipo_objeto', $tipo);
        $row = $this->db->single();
        $consecutivo = ($row->last_c) ? $row->last_c + 1 : 1;

        $this->db->query('INSERT INTO dic_versiones (objeto_id, tipo_objeto, consecutivo, codigo, descripcion, usuario_creador) VALUES (:objeto_id, :tipo_objeto, :consecutivo, :codigo, :descripcion, :usuario_creador)');
        $this->db->bind(':objeto_id', $objeto_id);
        $this->db->bind(':tipo_objeto', $tipo);
        $this->db->bind(':consecutivo', $consecutivo);
        $this->db->bind(':codigo', $data['codigo']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':usuario_creador', $_SESSION['user_id']);
        return $this->db->execute();
    }

    public function getVersions($id){
        $this->db->query('SELECT v.*, u.name as creatorName FROM dic_versiones v LEFT JOIN dic_usuarios u ON v.usuario_creador = u.id WHERE objeto_id = :objeto_id AND tipo_objeto = "funcion" ORDER BY consecutivo DESC');
        $this->db->bind(':objeto_id', $id);
        return $this->db->resultSet();
    }
    public function deleteFuncion($id) {
        $this->db->query('DELETE FROM dic_funciones WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
