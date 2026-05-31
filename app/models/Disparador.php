<?php
class Disparador {
    private $db;
    public function __construct() { $this->db = new Database; }
    public function getDisparadores() {
        $this->db->query('SELECT dic_disparadores.*, dic_disparadores.id as dispId, dic_tablas.nombre as tablaNombre, dic_usuarios.name as creatorName
                          FROM dic_disparadores
                          INNER JOIN dic_tablas ON dic_disparadores.tabla_id = dic_tablas.id
                          LEFT JOIN dic_usuarios ON dic_disparadores.usuario_creador = dic_usuarios.id
                          ORDER BY dic_disparadores.fecha_creacion DESC');
        return $this->db->resultSet();
    }
    public function addDisparador($data) {
        $this->db->query('INSERT INTO dic_disparadores (tabla_id, nombre, evento, codigo, descripcion, usuario_creador) VALUES (:tabla_id, :nombre, :evento, :codigo, :descripcion, :usuario_creador)');
        $this->db->bind(':tabla_id', $data['tabla_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':evento', $data['evento']);
        $this->db->bind(':codigo', $data['codigo']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':usuario_creador', $data['user_id']);

        if($this->db->execute()){
            $objeto_id = $this->db->lastInsertId();
            return $this->addVersion($objeto_id, 'disparador', $data);
        } else {
            return false;
        }
    }
    public function getDisparadorById($id) {
        $this->db->query('SELECT * FROM dic_disparadores WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function updateDisparador($data) {
        $this->db->query('UPDATE dic_disparadores SET tabla_id = :tabla_id, nombre = :nombre, evento = :evento, codigo = :codigo, descripcion = :descripcion WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':tabla_id', $data['tabla_id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':evento', $data['evento']);
        $this->db->bind(':codigo', $data['codigo']);
        $this->db->bind(':descripcion', $data['descripcion']);

        if($this->db->execute()){
            return $this->addVersion($data['id'], 'disparador', $data);
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
        $this->db->query('SELECT v.*, u.name as creatorName FROM dic_versiones v LEFT JOIN dic_usuarios u ON v.usuario_creador = u.id WHERE objeto_id = :objeto_id AND tipo_objeto = "disparador" ORDER BY consecutivo DESC');
        $this->db->bind(':objeto_id', $id);
        return $this->db->resultSet();
    }
    public function deleteDisparador($id) {
        $this->db->query('DELETE FROM dic_disparadores WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
