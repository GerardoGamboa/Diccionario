<?php
  // Simple page redirect
  function redirect($page){
    header('location: ' . URLROOT . '/' . $page);
  }

  // HTML Escape helper
  function h($text){
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
  }
