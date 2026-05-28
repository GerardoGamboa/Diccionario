<?php
  class Diccionario extends Controller {
    public function __construct(){
      if(!isLoggedIn()){
        redirect('users/login');
      }

      $this->objetoModel = $this->model('Objeto');
      $this->userModel = $this->model('User');
    }

    public function index(){
      // Get objects
      $objetos = $this->objetoModel->getObjetos();

      $data = [
        'objetos' => $objetos
      ];

      $this->view('diccionario/index', $data);
    }

    public function add(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data = [
          'nombre' => trim($_POST['nombre']),
          'tipo' => trim($_POST['tipo']),
          'descripcion' => trim($_POST['descripcion']),
          'base_datos' => trim($_POST['base_datos']),
          'user_id' => $_SESSION['user_id'],
          'nombre_err' => '',
          'tipo_err' => ''
        ];

        // Validate nombre
        if(empty($data['nombre'])){
          $data['nombre_err'] = 'Please enter name';
        }
        // Validate tipo
        if(empty($data['tipo'])){
          $data['tipo_err'] = 'Please enter type';
        }

        // Make sure no errors
        if(empty($data['nombre_err']) && empty($data['tipo_err'])){
          // Validated
          if($this->objetoModel->addObjeto($data)){
            flash('post_message', 'Objeto Added');
            redirect('diccionario');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $this->view('diccionario/add', $data);
        }

      } else {
        $data = [
          'nombre' => '',
          'tipo' => '',
          'descripcion' => '',
          'base_datos' => '',
        ];

        $this->view('diccionario/add', $data);
      }
    }

    public function edit($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data = [
          'id' => $id,
          'nombre' => trim($_POST['nombre']),
          'tipo' => trim($_POST['tipo']),
          'descripcion' => trim($_POST['descripcion']),
          'base_datos' => trim($_POST['base_datos']),
          'user_id' => $_SESSION['user_id'],
          'nombre_err' => '',
          'tipo_err' => ''
        ];

        // Validate nombre
        if(empty($data['nombre'])){
          $data['nombre_err'] = 'Please enter name';
        }
        // Validate tipo
        if(empty($data['tipo'])){
          $data['tipo_err'] = 'Please enter type';
        }

        // Make sure no errors
        if(empty($data['nombre_err']) && empty($data['tipo_err'])){
          // Validated
          if($this->objetoModel->updateObjeto($data)){
            flash('post_message', 'Objeto Updated');
            redirect('diccionario');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $this->view('diccionario/edit', $data);
        }

      } else {
        // Get existing post from model
        $objeto = $this->objetoModel->getObjetoById($id);

        // Check for owner (Optional for DBA control, but here we check just in case)
        // if($objeto->usuario_creador != $_SESSION['user_id']){
        //   redirect('diccionario');
        // }

        $data = [
          'id' => $id,
          'nombre' => $objeto->nombre,
          'tipo' => $objeto->tipo,
          'descripcion' => $objeto->descripcion,
          'base_datos' => $objeto->base_datos,
        ];

        $this->view('diccionario/edit', $data);
      }
    }

    public function delete($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Get existing post from model
        $objeto = $this->objetoModel->getObjetoById($id);

        // Check for owner
        // if($objeto->usuario_creador != $_SESSION['user_id']){
        //   redirect('diccionario');
        // }

        if($this->objetoModel->deleteObjeto($id)){
          flash('post_message', 'Objeto Removed');
          redirect('diccionario');
        } else {
          die('Something went wrong');
        }
      } else {
        redirect('diccionario');
      }
    }
  }
