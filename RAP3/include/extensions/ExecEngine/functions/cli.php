<?php

use Ampersand\Log\Logger;
use Ampersand\Config;

function CompileWithAmpersand($file,$switches){
	Logger::getLogger('EXECENGINE')->info("CompileWithAmpersand({$file})");
	$path = realpath(Config::get('absolutePath') . $file);
	$cmd = "Ampersand {$switches} {$path}";
	Logger::getLogger('EXECENGINE')->debug("cmd:'{$cmd}'");
	$output = array();
	Logger::getLogger('EXECENGINE')->debug(exec($cmd, $output));
	Logger::getLogger('EXECENGINE')->debug($output);
}

?>