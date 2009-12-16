<?php
error_reporting(E_ALL); 
ini_set("display_errors", 1);
//require "interfaceDef.inc.php";

$content = $_REQUEST['content'];
//if($content == "") {
//$content = "Rules";
//}
$ctxenv = array('User'=>$_REQUEST['User'], 'Script'=>$_REQUEST['Script']);
include "$content.php"; 

?> 

