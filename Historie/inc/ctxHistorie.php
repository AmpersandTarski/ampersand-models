<?php
  // ctxHistorie.php
  // Generated with ADL vs. 1.1.0.801
  // Prototype interface design by Milan van Bruggen and Sebastiaan J.C. Joosten
  
  
  error_reporting(E_ALL); 
  ini_set("display_errors", 1);
  
  $content = $_REQUEST['content'];
  $ctxenv = array();
  include "$content.php"; 
  
  ?>