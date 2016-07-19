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
		case 'diagnosis':
			Diagnosis($path, $scriptAtom);
			break;
		case 'prototype' : 
			Prototype($path, $scriptAtom);
			break;
		default :
			Logger::getLogger('EXECENGINE')->error("Unknown action ({$action}) specified");
			break;
	}
}

function CompileCheck($path, $scriptAtom){
	$cmd = "Ampersand {$path}";
	Logger::getLogger('COMPILEENGINE')->debug("cmd:'{$cmd}'");
	
	// Execute cmd, and populate 'scriptOk' upon success
	Execute($cmd, $response, $exitcode, 'scriptOk', $scriptAtom);
	
	// Add response to database
	$relCompileResponse = Relation::getRelation('compileresponse','Script','CompileResponse');
	$responseAtom = new Atom($response,'CompileResponse');
	$relCompileResponse->addLink($scriptAtom,$responseAtom,false,'COMPILEENGINE');
	
}

function FuncSpec($path, $scriptAtom){
	$dir = dirname($path);
	$extension = pathinfo($path, PATHINFO_EXTENSION);
	$filename = pathinfo($path, PATHINFO_FILENAME);
	
	$cmd = "Ampersand {$path} -fl --language=NL --outputDir=\"{$dir}/fspec\" --verbose";
	Logger::getLogger('COMPILEENGINE')->debug("cmd:'{$cmd}'");

	// Execute cmd, and populate 'funcSpecOk' upon success
	Execute($cmd, $response, $exitcode, 'funcSpecOk', $scriptAtom);

	// Create FileObject in database
	$concept = Concept::getConcept('FileObject');
	$fileObjectAtom = $concept->createNewAtom();
	Relation::getRelation('filePath','FileObject','FilePath')->addLink($fileObjectAtom, new Atom("uploads/fspec/{$filename}.pdf", 'FilePath'));
	Relation::getRelation('originalFileName','FileObject','FileName')->addLink($fileObjectAtom, new Atom('LogicalDataModel.pdf', 'FileName'));

	// Link fSpecAtom to scriptAtom
	Relation::getRelation('funcSpec','Script','FileObject')->addLink($scriptAtom,$fileObjectAtom,false,'COMPILEENGINE');
	
}

function Diagnosis($path, $scriptAtom){
	$dir = dirname($path);
	$extension = pathinfo($path, PATHINFO_EXTENSION);
	$filename = pathinfo($path, PATHINFO_FILENAME);
	
	$cmd = "Ampersand {$path} --diagnosis --language=NL --outputDir=\"{$dir}/diag\" --verbose";
	Logger::getLogger('COMPILEENGINE')->debug("cmd:'{$cmd}'");

	// Execute cmd, and populate 'diagOk' upon success
	Execute($cmd, $response, $exitcode, 'diagOk', $scriptAtom);
	
	// Create FileObject in database
	$concept = Concept::getConcept('FileObject');
	$fileObjectAtom = $concept->createNewAtom();
	Relation::getRelation('filePath','FileObject','FilePath')->addLink($fileObjectAtom, new Atom("uploads/diag/{$filename}.pdf", 'FilePath'));
	Relation::getRelation('originalFileName','FileObject','FileName')->addLink($fileObjectAtom, new Atom('Diagnosis.pdf', 'FileName'));

	// Link diagAtom to scriptAtom
	Relation::getRelation('diag','Script','FileObject')->addLink($scriptAtom,$fileObjectAtom,false,'COMPILEENGINE');
	
}

function Prototype($path, $scriptAtom){
	$dir = dirname($path);
	$extension = pathinfo($path, PATHINFO_EXTENSION);
	$filename = pathinfo($path, PATHINFO_FILENAME);
	
	$cmd = "Ampersand {$path} --proto=\"{$dir}/prototype\" --language=NL --verbose";
	Logger::getLogger('COMPILEENGINE')->debug("cmd:'{$cmd}'");

	// Execute cmd, and populate 'protoOk' upon success
	Execute($cmd, $response, $exitcode, 'protoOk', $scriptAtom);
	
	// Create FileObject in database
	$concept = Concept::getConcept('FileObject');
	$fileObjectAtom = $concept->createNewAtom();
	Relation::getRelation('filePath','FileObject','FilePath')->addLink($fileObjectAtom, new Atom("uploads/proto/{$filename}/index.php", 'FilePath'));
	Relation::getRelation('originalFileName','FileObject','FileName')->addLink($fileObjectAtom, new Atom('index.php', 'FileName'));

	// Link protoAtom to scriptAtom
	Relation::getRelation('proto','Script','FileObject')->addLink($scriptAtom,$fileObjectAtom,false,'COMPILEENGINE');
}

/**
 * @param string $cmd command that needs to be executed
 * @param string &$response reference to textual output of executed command
 * @param int &$exitcode reference to exitcode of executed command
 * @param string $proprelname name of ampersand property relation that must be (de)populated upon success/failure
 * @param Atom $scriptAtom ampersand Script atom used for populating
 */
function Execute($cmd, &$response, &$exitcode, $proprelname, $scriptAtom){
	$output = array();
	exec($cmd, $output, $exitcode);

	// Set property '$proprelname[Script*Script] [PROP]' depending on the exit code
	$proprel = Relation::getRelation($proprelname,'Script','Script');
	$proprel->addLink($scriptAtom,$scriptAtom,false,'COMPILEENGINE');
    // Before deleteLink always addLink (otherwise Exception will be thrown when link does not exist)
    if($exitcode != 0) $proprel->deleteLink($scriptAtom,$scriptAtom,false,'COMPILEENGINE');
    

	// format execution output
	$response = implode('\n',$output);
	Logger::getLogger('COMPILEENGINE')->debug("response:'{$response}'");
}

?>