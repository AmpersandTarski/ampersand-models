<?php
  $x = split('inc',$_SERVER['PHP_SELF']);
  if(count($x)>1){
    // authorize!
    $user = "user";$pass = "basenbram";
    if (!isset($_SERVER['PHP_AUTH_USER']) || !(($_SERVER['PHP_AUTH_USER'] == $user) && ($_SERVER['PHP_AUTH_PW'] == $pass))){header("WWW-Authenticate: Basic realm=\"You must Log In!\"");Header("HTTP/1.0 401 Unauthorized");exit;}
  }
  if($DB_link=@mysql_connect($DB_host=null, $DB_user="ADLgebruiker", $DB_pass="W5woord")){
    $DB_debug=1; // do not show rule violations and db errormessages! (1 < 3)
  }else{
    $DB_link=mysql_connect($DB_host="localhost", $DB_user="root", $DB_pass="");
    $DB_debug = 3;// do show errormessages, but not the queries (3 < 5)
  } ?>