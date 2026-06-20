<?php
  // Load Config
  require_once __DIR__ . '/config/config.php';
  // Load Composer Autoloader
  if(file_exists(dirname(__DIR__) . '/vendor/autoload.php')){
    require_once dirname(__DIR__) . '/vendor/autoload.php';
  }

  // Load Helpers
  require_once __DIR__ . '/helpers/url_helper.php';
  require_once __DIR__ . '/helpers/session_helper.php';

  // Autoload Core Libraries
  spl_autoload_register(function($className){
    require_once __DIR__ . '/libraries/' . $className . '.php';
  });
