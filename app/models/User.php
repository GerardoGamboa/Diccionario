<?php
  class User {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Regsiter user
    public function register($data){
      $this->db->query('INSERT INTO dic_usuarios (name, email, password) VALUES(:name, :email, :password)');
      // Bind values
      $this->db->bind(':name', $data['name']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':password', $data['password']);

      // Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Login User
    public function login($email, $password){
      $this->db->query('SELECT * FROM dic_usuarios WHERE email = :email');
      $this->db->bind(':email', $email);

      $row = $this->db->single();

      if ($row) {
        $hashed_password = $row->password;
        if(password_verify($password, $hashed_password)){
          return $row;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }

    // Find user by email
    public function findUserByEmail($email){
      $this->db->query('SELECT * FROM dic_usuarios WHERE email = :email');
      // Bind value
      $this->db->bind(':email', $email);

      $row = $this->db->single();

      // Check row
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }

    // Get User by ID
    public function getUserById($id){
      $this->db->query('SELECT * FROM dic_usuarios WHERE id = :id');
      // Bind value
      $this->db->bind(':id', $id);

      $row = $this->db->single();

      return $row;
    }

    // Get all users
    public function getUsers(){
      $this->db->query('SELECT * FROM dic_usuarios ORDER BY name ASC');
      return $this->db->resultSet();
    }

    // Update user
    public function updateUser($data){
      if(!empty($data['password'])){
        $this->db->query('UPDATE dic_usuarios SET name = :name, email = :email, password = :password WHERE id = :id');
        $this->db->bind(':password', $data['password']);
      } else {
        $this->db->query('UPDATE dic_usuarios SET name = :name, email = :email WHERE id = :id');
      }

      $this->db->bind(':id', $data['id']);
      $this->db->bind(':name', $data['name']);
      $this->db->bind(':email', $data['email']);

      return $this->db->execute();
    }

    // Delete user
    public function deleteUser($id){
      $this->db->query('DELETE FROM dic_usuarios WHERE id = :id');
      $this->db->bind(':id', $id);
      return $this->db->execute();
    }
  }
