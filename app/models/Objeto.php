<?php
  class Objeto {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function getObjetos(){
      $this->db->query('SELECT *,
                        objetos.id as objetoId,
                        users.id as userId,
                        objetos.fecha_creacion as objetoCreated
                        FROM objetos
                        INNER JOIN users
                        ON objetos.usuario_creador = users.id
                        ORDER BY objetos.fecha_creacion DESC
                        ');

      $results = $this->db->resultSet();

      return $results;
    }

    public function addObjeto($data){
      $this->db->query('INSERT INTO objetos (nombre, tipo, descripcion, base_datos, usuario_creador) VALUES(:nombre, :tipo, :descripcion, :base_datos, :usuario_creador)');
      // Bind values
      $this->db->bind(':nombre', $data['nombre']);
      $this->db->bind(':tipo', $data['tipo']);
      $this->db->bind(':descripcion', $data['descripcion']);
      $this->db->bind(':base_datos', $data['base_datos']);
      $this->db->bind(':usuario_creador', $data['user_id']);

      // Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function updateObjeto($data){
      $this->db->query('UPDATE objetos SET nombre = :nombre, tipo = :tipo, descripcion = :descripcion, base_datos = :base_datos WHERE id = :id');
      // Bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':nombre', $data['nombre']);
      $this->db->bind(':tipo', $data['tipo']);
      $this->db->bind(':descripcion', $data['descripcion']);
      $this->db->bind(':base_datos', $data['base_datos']);

      // Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function getObjetoById($id){
      $this->db->query('SELECT * FROM objetos WHERE id = :id');
      $this->db->bind(':id', $id);

      $row = $this->db->single();

      return $row;
    }

    public function deleteObjeto($id){
      $this->db->query('DELETE FROM objetos WHERE id = :id');
      // Bind values
      $this->db->bind(':id', $id);

      // Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
  }
