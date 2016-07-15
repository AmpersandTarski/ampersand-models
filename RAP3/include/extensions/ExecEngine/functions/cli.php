<?php

use Ampersand\Log\Logger;
use Ampersand\Config;
use Ampersand\Core\Relation;
use Ampersand\Core\Atom;

function CompileWithAmpersand($file, $scriptAtomId){
	Logger::getLogger('EXECENGINE')->info("CompileWithAmpersand({$file})");
	$relCompileResponse = Relation::getRelation('compileresponse','Script','CompileResponse');
	$scriptAtom = new Atom($scriptAtomId,'Script');
	$path = realpath(Config::get('absolutePath') . $file);
	$cmd = "Ampersand {$path}";
	Logger::getLogger('COMPILEENGINE')->debug("cmd:'{$cmd}'");
	$output = array();
	$response = exec($cmd, $output);
	Logger::getLogger('COMPILEENGINE')->debug("response:'{$response}'");
	$responseAtom = new Atom(implode('\n',$output),'CompileResponse');
	$relCompileResponse->addLink($scriptAtom,$responseAtom,false,'COMPILEENGINE');
	Logger::getLogger('COMPILEENGINE')->debug($output);
}

?>