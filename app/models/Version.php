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
}
