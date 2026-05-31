<?php
  // Simple page redirect
  function redirect($page){
    header('location: ' . URLROOT . '/' . $page);
  }

  // HTML Escape helper
  function h($text){
    if (is_null($text)) return '';
    // Decode multiple times to handle potential nested encoding (e.g., &amp;#13;)
    $decoded = $text;
    $prev = '';
    while($decoded !== $prev) {
      $prev = $decoded;
      $decoded = html_entity_decode($decoded, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
    return htmlspecialchars($decoded, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
  }
