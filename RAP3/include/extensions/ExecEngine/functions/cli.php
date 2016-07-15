<?php

use Ampersand\Log\Logger;
use Ampersand\Config;
use Ampersand\Core\Relation;
use Ampersand\Core\Atom;
use Ampersand\Core\Concept;

function CompileWithAmpersand($action, $file, $scriptAtomId){
	Logger::getLogger('EXECENGINE')->info("CompileWithAmpersand({$action}, {$file}, {$scriptAtomId})");
	
	$path = realpath(Config::get('absolutePath') . $file);
	$scriptAtom = new Atom($scriptAtomId,'Script');
	
	switch($action){
		case 'compilecheck' : 
			CompileCheck($path, $scriptAtom);
			break;
		case 'fspec' : 
			FuncSpec($path, $scriptAtom);
			break;
		case 'diagnose':
			break;
		case 'proto' : 
			break;
		default :
			break;
	}
}

function CompileCheck($path, $scriptAtom){
	$cmd = "Ampersand {$path}";
	Logger::getLogger('COMPILEENGINE')->debug("cmd:'{$cmd}'");
	
	// Execute cmd
	Execute($cmd, $response, $exitcode);
	
	// Add response to database
	$relCompileResponse = Relation::getRelation('compileresponse','Script','CompileResponse');
	$responseAtom = new Atom($response,'CompileResponse');
	$relCompileResponse->addLink($scriptAtom,$responseAtom,false,'COMPILEENGINE');
	
	// If exitcode = 0, set property 'scriptOk[Script*Script] [PROP]'
	if($exitcode == 0){
		//$relScriptOk = Relation::getRelation('scriptOk','Script','Script');
		//$relScriptOk->addLink($scriptAtom,$scriptAtom,false,'COMPILEENGINE');
	}
	
}

function FuncSpec($path, $scriptAtom){
	$dir = dirname($path);
	$extension = pathinfo($path, PATHINFO_EXTENSION);
	$filename = pathinfo($path, PATHINFO_FILENAME);
	
	$cmd = "Ampersand {$path} -fl --language=NL --outputDir=\"{$dir}/fspec\" --verbose";
	Logger::getLogger('COMPILEENGINE')->debug("cmd:'{$cmd}'");

	// Execute cmd
	Execute($cmd, $response, $exitcode);
	
	// Create FileObject in database
	$concept = Concept::getConcept('FileObject');
	$fspecAtom = $concept->createNewAtom();
	Relation::getRelation('filePath','FileObject','FilePath')->addLink($fspecAtom, new Atom("uploads/fspec/{$filename}.pdf", 'FilePath'));
	Relation::getRelation('originalFileName','FileObject','FileName')->addLink($fspecAtom, new Atom('LogicalDataModel.pdf', 'FileName'));

	// Link fSpecAtom to scriptAtom
	Relation::getRelation('funcSpec','Script','FileObject')->addLink($scriptAtom,$fspecAtom,false,'COMPILEENGINE');
	
}

function Execute($cmd, &$response, &$exitcode){
	$output = array();
	exec($cmd, $output, $exitcode);
	$response = implode('\n',$output);
	Logger::getLogger('COMPILEENGINE')->debug("response:'{$response}'");
}

?>