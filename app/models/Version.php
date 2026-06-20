<?php
class Version {
    private $db;
    public function __construct() { $this->db = new Database; }

    public function getVersionById($id) {
        $this->db->query('SELECT * FROM dic_versiones WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function deleteVersion($id) {
        $this->db->query('DELETE FROM dic_versiones WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function isLastVersion($objeto_id, $tipo, $consecutivo) {
        $this->db->query('SELECT MAX(consecutivo) as max_c FROM dic_versiones WHERE objeto_id = :objeto_id AND tipo_objeto = :tipo_objeto');
        $this->db->bind(':objeto_id', $objeto_id);
        $this->db->bind(':tipo_objeto', $tipo);
        $row = $this->db->single();
        return $consecutivo == $row->max_c;
    }
}
