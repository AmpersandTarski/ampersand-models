<?php

$commandstr = array(
     1 => './adl552-1956 -p'.COMPILATIONS_PATH.' --dbName=atlas --css=RAP.css --import="'.FULLFILE.'" --fileformat=ADL1 --namespace='.USER.' rap.adl', //load
     2 => './adl552-1956 -o'.TMPFILEPATH.' --export="'.basename(FULLFILE).'" --fileformat=ADL1 --namespace='.USER.' rap.adl', //export+load
     3 => './adl552-1956 -o'.TMPFILEPATH.' --export="'.basename(FULLFILE).'" --fileformat=ADL1 --namespace='.USER.' rap.adl', //export
     4 => './adl552-1956 -o'.TMPFILEPATH.' --export="'.basename(FULLFILE).'" --fileformat=POP1 --namespace='.USER.' rap.adl', //export .pop
     5 => './adl552 -o'.COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/fs/ -f Latex "'.FULLFILE.'"', //fspec pdf
     6 => './adl552-1956 -p'.COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/proto/ --theme=student "'.FULLFILE.'"', //proto
     7 => './adl552 -o'.COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/diag/ -f Latex --diagnosis "'.FULLFILE.'"', //diagnosis pdf
     99 => './adl552-1956 --verbose "'.FULLFILE.'"' //test
     );
$compileurl = array(
     1 => COMPILATIONS_PATH.'index.php?interface=Atlas&atom=1&role=0',
     2 => 'index.php?file='.FILEPATH.basename(FULLFILE).'&operation=1', //immediately load after saving .adl
     3 => 'index.php?file='.FILEPATH.basename(FULLFILE), //first view after saving .adl
     4 => COMPILATIONS_PATH.'index.php?interface=Atlas&atom=1&role=0', //return to loaded context after saving .pop
     5 => COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/fs/'.basename(FULLFILE,'.adl').'.pdf', //go to output (pdf)
     6 => COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/proto/index.htm', //go to output (proto)
     7 => COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/diag/'.basename(FULLFILE,'.adl').'.pdf', //go to output (pdf)
     99 => ''
     );

?>
