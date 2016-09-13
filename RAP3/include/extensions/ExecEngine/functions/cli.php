<?php

use Ampersand\Log\Logger;
use Ampersand\Config;
use Ampersand\Core\Relation;
use Ampersand\Core\Atom;
use Ampersand\Core\Concept;
use Ampersand\Session;

// Ampersand commando's mogen niet in dit bestand worden aangepast. 
// De manier om je eigen commando's te regelen is door onderstaande regels naar jouw localSettings.php te copieren en te veranderen
// Nu kan dat nog niet, omdat zulke strings niet de paden e.d. kunnen doorgeven.
// Config::set('proto', 'RAP3', 'value');
// Config::set('proto', 'RAP3', 'value');
// Config::set('proto', 'RAP3', 'value');
// Config::set('proto', 'RAP3', 'value');
// Config::set('proto', 'RAP3', 'value');


// Required Ampersand script
/*
RELATION loadedInRAP3[Script*Script] [PROP] 



*/


function CompileWithAmpersand($action, $filePath, $scriptAtomId){
    Logger::getLogger('EXECENGINE')->info("CompileWithAmpersand({$action}, {$filePath}, {$scriptAtomId})");
    
    $path = realpath(Config::get('absolutePath') . $filePath);
    $scriptAtom = new Atom($scriptAtomId,'Script');
    
    switch($action){
        case 'compilecheck' : 
            CompileCheck($path, $scriptAtom);
            break;
        case 'diagnosis':
            Diagnosis($path, $scriptAtom);
            break;
        case 'loadPopInRAP3' : 
            loadPopInRAP3($path, $scriptAtom);
            break;
        case 'fspec' : 
            FuncSpec($path, $scriptAtom);
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
    $default = "Ampersand {$path}";
    $cmd = is_null(Config::get('CompileCheckCmd', 'RAP3')) ? $default : Config::get('CompileCheckCmd', 'RAP3');
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
    
    $default = "Ampersand {$path} -fl --language=NL --outputDir=\"{$dir}/fspec\" --verbose";
    $cmd = is_null(Config::get('FuncSpecCmd', 'RAP3')) ? $default : Config::get('FuncSpecCmd', 'RAP3');
    Logger::getLogger('COMPILEENGINE')->debug("cmd:'{$cmd}'");

    // Execute cmd, and populate 'funcSpecOk' upon success
    Execute($cmd, $response, $exitcode, 'funcSpecOk', $scriptAtom);

    // Create FileObject in database
    $concept = Concept::getConcept('FileObject');
    $fileObjectAtom = $concept->createNewAtom();
    Relation::getRelation('filePath','FileObject','FilePath')->addLink($fileObjectAtom, new Atom("uploads/fspec/{$filename}.pdf", 'FilePath'));
    Relation::getRelation('originalFileName','FileObject','FileName')->addLink($fileObjectAtom, new Atom('Functional specification', 'FileName'));

    // Link fSpecAtom to scriptAtom
    Relation::getRelation('funcSpec','Script','FileObject')->addLink($scriptAtom,$fileObjectAtom,false,'COMPILEENGINE');
    
}

function Diagnosis($path, $scriptAtom){
    $dir = dirname($path);
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    $filename = pathinfo($path, PATHINFO_FILENAME);
    
    $default = "Ampersand {$path} --diagnosis --language=NL --outputDir=\"{$dir}/diag\" --verbose";
    $cmd = is_null(Config::get('DiagCmd', 'RAP3')) ? $default : Config::get('DiagCmd', 'RAP3');
    Logger::getLogger('COMPILEENGINE')->debug("cmd:'{$cmd}'");

    // Execute cmd, and populate 'diagOk' upon success
    Execute($cmd, $response, $exitcode, 'diagOk', $scriptAtom);
    
    // Create FileObject in database
    $concept = Concept::getConcept('FileObject');
    $fileObjectAtom = $concept->createNewAtom();
    Relation::getRelation('filePath','FileObject','FilePath')->addLink($fileObjectAtom, new Atom("uploads/diag/{$filename}.pdf", 'FilePath'));
    Relation::getRelation('originalFileName','FileObject','FileName')->addLink($fileObjectAtom, new Atom('Diagnosis', 'FileName'));

    // Link diagAtom to scriptAtom
    Relation::getRelation('diag','Script','FileObject')->addLink($scriptAtom,$fileObjectAtom,false,'COMPILEENGINE');
    
}

function Prototype($path, $scriptAtom){
    $dir = dirname($path);
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    $filename = pathinfo($path, PATHINFO_FILENAME);
    
    $default = "Ampersand {$path} --proto=\"{$dir}/prototype\" --language=NL --verbose";
    $cmd = is_null(Config::get('ProtoCmd', 'RAP3')) ? $default : Config::get('ProtoCmd', 'RAP3');
    Logger::getLogger('COMPILEENGINE')->debug("cmd:'{$cmd}'");

    // Execute cmd, and populate 'protoOk' upon success
    Execute($cmd, $response, $exitcode, 'protoOk', $scriptAtom);
    
    // Link urlAtom to scriptAtom
    $urlAtom = new Atom ('hier de url', 'URL');
    Relation::getRelation('proto url relation name','Script','URL')->addLink($scriptAtom, $urlAtom, false,'COMPILEENGINE');
}

function loadPopInRAP3($path, $scriptAtom){
    $session = Session::singleton();
    
    $dir = dirname($path) . '/prototype';
    
    $cmd = "Ampersand {$path} --proto=\"{$dir}\" --language=NL --verbose --gen-as-rap-model"; // het draait om: ../prototype/generics/metaPopulation.json
    Logger::getLogger('COMPILEENGINE')->debug("cmd:'{$cmd}'");
    
    // Execute cmd, and populate 'loadedInRAP3' upon success
    Execute($cmd, $response, $exitcode, 'loadedInRAP3', $scriptAtom);
    
    // Open and decode generated metaPopulation.json file
    $queries = file_get_contents("{$dir}/generics/metaPopulation.json");
    $queries = json_decode($queries, true);
    
  // There are no tables created at this time. 
  // // Structure (CREATE TABLE IF NOT EXIST syntax required)
  //  foreach($queries['allDBstructQueries'] as $query){
  //      $session->database->Exe($query);
  //  }
    
    // Population (no transaction mechanism in place, invariant violations may not occur in provided population)
    foreach($queries['metaPopulation'] as $query){
        $session->database->Exe($query);
    }
    
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