<?php
  class Pages extends Controller {
    public function __construct(){

    }

    public function index(){
      if(isLoggedIn()){
        redirect('diccionario/index');
      } else {
        redirect('users/login');
      }
    }
  }
