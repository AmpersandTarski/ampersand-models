<?php
  // Meterkast.php
  // Generated with ADL vs. 0.8.10-529
  // Prototype interface design by Sebastiaan JC Joosten (c) Aug 2009
  
  
  error_reporting(E_ALL); 
  ini_set("display_errors", 1);
  
  $content = $_REQUEST['content'];
  $ctxenv = array();
  include "$content.php"; 
  
  ?>