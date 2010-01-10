<?php
  // Atlas.php
  // Generated with ADL vs. 0.8.10-529
  // Prototype interface design by Sebastiaan JC Joosten (c) Aug 2009
  
  
  error_reporting(E_ALL); 
  ini_set("display_errors", 1);
  
  $content = $_REQUEST['content'];
  $ctxenv = array('User'=>$_REQUEST['User'], 'Script'=>$_REQUEST['Script']);
  include "$content.php"; 
  
  ?>