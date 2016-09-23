<?php

use Exception;
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

function CompileScript($scriptAtomId){
    Logger::getLogger('EXECENGINE')->info("CompileWithAmpersand({$action}, {$scriptAtomId})");
    
    $scriptConcept = Concept::getConceptByLabel("Script");
    $scriptVersion = Concept::getConceptByLabel("ScriptVersion");
    $scriptAtom = new Atom($scriptAtomId,$scriptConcept);
    
    $dir = "scripts/{$scriptAtom->id}";
    $versionId = date('Y-m-dTHis');
    
    $fileName = "Script{$versionId}.adl";
    $relPath = $dir . "/source/{$fileName}";
    $absPath = realpath(Config::get('absolutePath') . $relPath);
    
    // Script content ophalen en schrijven naar bestandje
    $tgts = $scriptAtom->ifc('ScriptContent')->getTgtAtoms();
    if(empty($tgts)) throw new Exception ("No script content provided",500);
    $scriptContent = current($tgts)->id;
    file_put_contents ($absPath, $scriptContent);
    
    // Compile bestandje
    $cmd = "Ampersand {$absPath}";
    Execute($cmd, $response, $exitcode);
    saveCompileResponse($scriptAtom, $response);
    
    if($exitcode == 0){ // script ok
        // Create new script version atom and add to rel version[Script*ScriptVersion]
        $version = $scriptVersion->createNewAtom();
        Relation::getRelation('version[Script*ScriptVersion]')->addLink($scriptAtom, $version, false, 'COMPILEENGINE');
        setProp('scriptOk', $version, true);
        
        $sourceFO = createFileObject($relPath, $fileName);
        Relation::getRelation('source[ScriptVersion*FileObject]')->addLink($version, $sourceFO, false, 'COMPILEENGINE');
        
    }else{ // script not ok
        // do nothing
    }
}

function CompileWithAmpersand($action, $scriptVersionAtomId){
    $scriptVersionConcept = Concept::getConceptByLabel("ScriptVersion");
    $scriptVersionAtom = new Atom($scriptVersionAtomId, $scriptVersionConcept);
    
    // Script bestand voeren aan Ampersand compiler
    switch($action){
        case 'diagnosis':
            Diagnosis($path, $scriptVersionAtom, $dir.'/diagnosis');
            break;
        case 'loadPopInRAP3' : 
            loadPopInRAP3($path, $scriptVersionAtom, $dir.'/prototype'); 
            break;
        case 'fspec' : 
            FuncSpec($path, $scriptVersionAtom, $dir.'/fSpec');
            break;
        case 'prototype' : 
            Prototype($path, $scriptVersionAtom, $dir.'/prototype'); 
            break;
        default :
            Logger::getLogger('EXECENGINE')->error("Unknown action ({$action}) specified");
            break;
    }
}

function FuncSpec($path, $scriptAtom, $relDir){
    
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    $filename = pathinfo($path, PATHINFO_FILENAME);
    $outputDir = Config::get('absolutePath').$relDir;
    $default = "Ampersand {$path} -fl --language=NL --outputDir=\"{$outputDir}\" ";
    $cmd = is_null(Config::get('FuncSpecCmd', 'RAP3')) ? $default : Config::get('FuncSpecCmd', 'RAP3');

    // Execute cmd, and populate 'funcSpecOk' upon success
    Execute($cmd, $response, $exitcode);
    setProp('funcSpecOk', $scriptAtom, $exitCode == 0);
    saveCompileResponse($scriptAtom, $response);

    // Create fSpec and link to scriptAtom
    $foObject = createFileObject("{$relDir}/{$filename}.pdf", 'Functional specification');
    Relation::getRelation('funcSpec[Script*FileObject]')->addLink($scriptAtom, $foObject, false, 'COMPILEENGINE');
    
}

function Diagnosis($path, $scriptAtom, $relDir){

    $extension = pathinfo($path, PATHINFO_EXTENSION);
    $filename = pathinfo($path, PATHINFO_FILENAME);
    $outputDir = Config::get('absolutePath').$relDir;
    $default = "Ampersand {$path} -fl --diagnosis --language=NL --outputDir=\"{$outputDir}\" ";
    $cmd = is_null(Config::get('DiagCmd', 'RAP3')) ? $default : Config::get('DiagCmd', 'RAP3');

    // Execute cmd, and populate 'diagOk' upon success
    Execute($cmd, $response, $exitcode);
    setProp('diagOk', $scriptAtom, $exitCode == 0);
    saveCompileResponse($scriptAtom, $response);
    
    // Create diagnose and link to scriptAtom
    $foObject = createFileObject("{$relDir}/{$filename}.pdf", 'Diagnosis');
    Relation::getRelation('diag[Script*FileObject]')->addLink($scriptAtom, $foObject, false, 'COMPILEENGINE');
    
}

function Prototype($path, $scriptAtom, $relDir){
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    $filename = pathinfo($path, PATHINFO_FILENAME);
    $outputDir = Config::get('absolutePath').$relDir;
    $default = "Ampersand {$path} --proto=\"{$outputDir}\" --dbName=\"ampersand_{$scriptAtom->id}\" --language=NL ";
    $cmd = is_null(Config::get('ProtoCmd', 'RAP3')) ? $default : Config::get('ProtoCmd', 'RAP3');

    // Execute cmd, and populate 'protoOk' upon success
    Execute($cmd, $response, $exitcode);
    setProp('protoOk', $scriptAtom, $exitCode == 0);
    saveCompileResponse($scriptAtom, $response);
    
    // Create proto and link to scriptAtom
    $foObject = createFileObject("{$relDir}", 'Launch prototype');
    Relation::getRelation('proto[Script*FileObject]')->addLink($scriptAtom, $foObject, false, 'COMPILEENGINE');
}

function loadPopInRAP3($path, $scriptAtom, $relDir){
    $session = Session::singleton();

    $extension = pathinfo($path, PATHINFO_EXTENSION);
    $filename = pathinfo($path, PATHINFO_FILENAME);
    $outputDir = Config::get('absolutePath').$relDir;
    
    $default = "Ampersand {$path} --proto=\"{$outputDir}\" --language=NL --gen-as-rap-model";
    $cmd = is_null(Config::get('LoadInRap3Cmd', 'RAP3')) ? $default : Config::get('LoadInRap3Cmd', 'RAP3');

    // Execute cmd, and populate 'loadedInRAP3Ok' upon success
    Execute($cmd, $response, $exitcode);
    setProp('loadedInRAP3Ok', $scriptAtom, $exitCode == 0);
    saveCompileResponse($scriptAtom, $response);
    
    if ($exitcode == 0) {
        // Open and decode generated metaPopulation.json file
        $pop = file_get_contents("{$outputDir}/generics/metaPopulation.json");
        $pop = json_decode($pop, true);
    
        // Add atoms to database    
        foreach($pop['atoms'] as $atomPop){
            $concept = Concept::getConceptByLabel($atomPop['concept']);
            foreach($atomPop['atoms'] as $atomId){
                getRAPAtom($atomId, $concept)->addAtom(); // Add to database
            }
        }
    
        // Add links to database
        foreach($pop['links'] as $linkPop){
            $relation = Relation::getRelation($linkPop['relation']);
            foreach($linkPop['links'] as $link){
                $src = getRAPAtom($link['src'], $relation->srcConcept);
                $tgt = getRAPAtom($link['tgt'], $relation->tgtConcept);
                $relation->addLink($src, $tgt); // Add link to database
            }
        }
    }        
}

function getRAPAtom($atomId, $concept){
    static $arr = []; // initialize array in first call
    
    switch($concept->isObject){
        case true : // non-scalair atoms get a new unique identifier
            // Caching of atom identifier is done by its largest concept
            $largestC = $concept->getLargestConcept(); 
            
            // If atom is already changed earlier, use new id from cache
            if(isset($arr[$largestC->name]) && array_key_exists($atomId, $arr[$largestC->name])){
                $atom = new Atom($arr[$largestC->name][$atomId], $concept); // Atom itself is instantiated with $concept (!not $largestC)
            
            // Else create new id and store in cache
            }else{
                $atom = $concept->createNewAtom(); // Create new atom (with generated id)
                // TODO: Guarantee that we have a new id. (Issue #528) (for now, the next logger statement seems to take enough time, which is great as workaround.)
                Logger::getLogger('COMPILEENGINE')->debug("concept:'{$concept->name}' --> atomId: '{$atomId}': {$atom->id}");
                $arr[$largestC->name][$atomId] = $atom->id; // Cache pair of old and new atom identifier
            }
            break;
        
        default : // All other atoms are left untouched
            $atom = new Atom($atomId, $concept);
            break;
    }
        
    return $atom;
}

/**
 * @param string $cmd command that needs to be executed
 * @param string &$response reference to textual output of executed command
 * @param int &$exitcode reference to exitcode of executed command

 */
function Execute($cmd, &$response, &$exitcode){

    Logger::getLogger('COMPILEENGINE')->debug("cmd:'{$cmd}'");
    $output = array();
    exec($cmd, $output, $exitcode);
    
    // format execution output
    $response = implode('\n',$output);
    Logger::getLogger('COMPILEENGINE')->debug("exitcode:'{$exitcode}' response:'{$response}'");
    
}

/**
 * @param string $proprelname name of ampersand property relation that must be (de)populated upon success/failure
 * @param Atom $atom ampersand atom used for populating
 */
function setProp($proprelname, $atom, $bool){
    // Set property '$proprelname[Script*Script] [PROP]' depending on $bool
    $proprel = Relation::getRelation($proprelname, $atom->concept, $atom->concept);
    $proprel->addLink($atom, $atom, false, 'COMPILEENGINE');
    // Before deleteLink always addLink (otherwise Exception will be thrown when link does not exist)
    if(!$bool) $proprel->deleteLink($atom, $atom, false,'COMPILEENGINE');
}

function createFileObject($relPath, $displayName){
    $foAtom = Concept::getConceptByLabel('FileObject')->createNewAtom();
    $cptFilePath = Concept::getConceptByLabel('FilePath');
    $cptFileName = Concept::getConceptByLabel('FileName');
    
    Relation::getRelation('filePath[FileObject*FilePath]')->addLink($foAtom, new Atom($relPath, $cptFilePath));
    Relation::getRelation('originalFileName[FileObject*FileName]')->addLink($foAtom, new Atom($displayName, $cptFileName));
    
    return $foAtom;
}

function saveCompileResponse($atom, $compileResponse){
    $cptCompileResponse = Concept::getConceptByLabel("CompileResponse");
    $responseAtom = new Atom($compileResponse, $cptCompileResponse);
    
    $relCompileResponse = Relation::getRelation('compileresponse', $atom->concept, $cptCompileResponse)->addLink($atom, $responseAtom, false, 'COMPILEENGINE');
}

?>