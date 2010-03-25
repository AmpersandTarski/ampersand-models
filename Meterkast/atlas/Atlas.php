<?php
  // Atlas.php
  // Generated with ADL vs. 1.1-646
  // Prototype interface design by Milan van Bruggen and Sebastiaan J.C. Joosten
  
  
  error_reporting(E_ALL); 
  ini_set("display_errors", 1);
  
  $content = $_REQUEST['content'];
  $ctxenv = array('User'=>$_REQUEST['User'], 'Script'=>$_REQUEST['Script']);
  include "$content.php"; 
  
  ?>