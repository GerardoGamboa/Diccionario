<?php
  class Users extends Controller {
    public function __construct(){
      $this->userModel = $this->model('User');
    }

    public function login(){
      if(isLoggedIn()){
        redirect('servidores/index');
      }
      // Check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process form
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        // Init data
        $data =[
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'email_err' => '',
          'password_err' => '',
        ];

        // Validate Email
        if(empty($data['email'])){
          $data['email_err'] = 'Por favor ingrese su correo';
        }

        // Validate Password
        if(empty($data['password'])){
          $data['password_err'] = 'Por favor ingrese su contraseña';
        }

        // Check for user/email
        if($this->userModel->findUserByEmail($data['email'])){
          // User found
        } else {
          // User not found
          $data['email_err'] = 'Usuario no encontrado';
        }

        // Make sure errors are empty
        if(empty($data['email_err']) && empty($data['password_err'])){
          // Validated
          // Check and set logged in user
          $loggedInUser = $this->userModel->login($data['email'], $data['password']);

          if($loggedInUser){
            // Create Session
            $this->createUserSession($loggedInUser);
          } else {
            $data['password_err'] = 'Contraseña incorrecta';

            $this->view('users/login', $data);
          }
        } else {
          // Load view with errors
          $this->view('users/login', $data);
        }


      } else {
        // Init data
        $data =[
          'email' => '',
          'password' => '',
          'email_err' => '',
          'password_err' => '',
        ];

        // Load view
        $this->view('users/login', $data);
      }
    }

    public function createUserSession($user){
      $_SESSION['user_id'] = $user->id;
      $_SESSION['user_email'] = $user->email;
      $_SESSION['user_name'] = $user->name;
      redirect('servidores/index');
    }

    public function logout(){
      unset($_SESSION['user_id']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_name']);
      session_destroy();
      redirect('users/login');
    }

    public function index(){
      if(!isLoggedIn()) redirect('users/login');
      $users = $this->userModel->getUsers();
      $data = [
        'users' => $users
      ];
      $this->view('users/index', $data);
    }

    public function add(){
      if(!isLoggedIn()) redirect('users/login');
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $data = [
          'name' => trim($_POST['name']),
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm_password']),
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];

        if(empty($data['name'])) $data['name_err'] = 'Ingrese nombre';
        if(empty($data['email'])) {
            $data['email_err'] = 'Ingrese email';
        } else {
            if($this->userModel->findUserByEmail($data['email'])) $data['email_err'] = 'Email ya registrado';
        }
        if(empty($data['password'])) $data['password_err'] = 'Ingrese contraseña';
        elseif(strlen($data['password']) < 6) $data['password_err'] = 'Mínimo 6 caracteres';

        if(empty($data['confirm_password'])) $data['confirm_password_err'] = 'Confirme contraseña';
        else {
            if($data['password'] != $data['confirm_password']) $data['confirm_password_err'] = 'Contraseñas no coinciden';
        }

        if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
          if($this->userModel->register($data)){
            flash('msg', 'Usuario registrado');
            redirect('users');
          } else die('Error');
        } else {
          $this->view('users/add', $data);
        }
      } else {
        $data = [
          'name' => '',
          'email' => '',
          'password' => '',
          'confirm_password' => '',
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];
        $this->view('users/add', $data);
      }
    }

    public function edit($id){
        if(!isLoggedIn()) redirect('users/login');
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
          $data = [
            'id' => $id,
            'name' => trim($_POST['name']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'name_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => ''
          ];

          if(empty($data['name'])) $data['name_err'] = 'Ingrese nombre';
          if(empty($data['email'])) $data['email_err'] = 'Ingrese email';

          if(!empty($data['password'])){
              if(strlen($data['password']) < 6) $data['password_err'] = 'Mínimo 6 caracteres';
              if($data['password'] != $data['confirm_password']) $data['confirm_password_err'] = 'Contraseñas no coinciden';
          }

          if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
            if(!empty($data['password'])) $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            if($this->userModel->updateUser($data)){
              flash('msg', 'Usuario actualizado');
              redirect('users');
            } else die('Error');
          } else {
            $this->view('users/edit', $data);
          }
        } else {
          $user = $this->userModel->getUserById($id);
          $data = [
            'id' => $id,
            'name' => $user->name,
            'email' => $user->email,
            'password' => '',
            'confirm_password' => '',
            'name_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => ''
          ];
          $this->view('users/edit', $data);
        }
    }

    public function delete($id){
        if(!isLoggedIn()) redirect('users/login');
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($id == $_SESSION['user_id']) {
                flash('msg', 'No puede eliminarse a sí mismo', 'alert alert-danger');
                redirect('users');
            }
            if($this->userModel->deleteUser($id)){
                flash('msg', 'Usuario eliminado');
                redirect('users');
            } else die('Error');
        } else redirect('users');
    }

    public function change_password(){
        if(!isLoggedIn()) redirect('users/login');

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'current_password' => trim($_POST['current_password']),
                'new_password' => trim($_POST['new_password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate current password
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            if(!password_verify($data['current_password'], $user->password)){
                $data['current_password_err'] = 'Contraseña actual incorrecta';
            }

            // Validate new password
            if(empty($data['new_password'])){
                $data['new_password_err'] = 'Ingrese nueva contraseña';
            } elseif(strlen($data['new_password']) < 6){
                $data['new_password_err'] = 'Mínimo 6 caracteres';
            }

            // Validate confirm password
            if(empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Confirme nueva contraseña';
            } else {
                if($data['new_password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Contraseñas no coinciden';
                }
            }

            if(empty($data['current_password_err']) && empty($data['new_password_err']) && empty($data['confirm_password_err'])){
                $hashed_password = password_hash($data['new_password'], PASSWORD_DEFAULT);
                if($this->userModel->updatePassword($_SESSION['user_id'], $hashed_password)){
                    flash('msg', 'Contraseña actualizada con éxito');
                    redirect('pages/index');
                } else die('Error');
            } else {
                $this->view('users/change_password', $data);
            }

        } else {
            $data = [
                'current_password' => '',
                'new_password' => '',
                'confirm_password' => '',
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => ''
            ];
            $this->view('users/change_password', $data);
        }
    }
  }
