<?php
  class Pages extends Controller {
    public function __construct(){

    }

    public function index(){
      if(isLoggedIn()){
        redirect('servidores/index');
      } else {
        redirect('users/login');
      }
    }
  }
