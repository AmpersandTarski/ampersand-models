<?php

$commandstr = array(
     1 => 'prototype -p'.COMPILATIONS_PATH.' --css=RAP.css --import="'.$fullfile.'" --fileformat=ADL1 --namespace='.USER.' rap.adl', //load
     2 => 'prototype -o'.TMPFILEPATH.' --export="'.basename($fullfile).'" --fileformat=ADL1 --namespace='.USER.' rap.adl', //export+load
     3 => 'prototype -o'.TMPFILEPATH.' --export="'.basename($fullfile).'" --fileformat=ADL1 --namespace='.USER.' rap.adl', //export
     4 => 'prototype -o'.TMPFILEPATH.' --export="'.basename($fullfile).'" --fileformat=POP1 --namespace='.USER.' rap.adl', //export .pop
     5 => 'ampersand -o'.COMPILATIONS_PATH.basename($fullfile,'.adl').'/fs/ -f Latex "'.$fullfile.'"', //fspec pdf
     6 => 'prototype -p'.COMPILATIONS_PATH.basename($fullfile,'.adl').'/proto/ --theme=student "'.$fullfile.'"', //proto
     7 => 'ampersand -o'.COMPILATIONS_PATH.basename($fullfile,'.adl').'/diag/ -f Latex --diagnosis "'.$fullfile.'"', //diagnosis pdf
     99 => 'prototype --verbose "'.$fullfile.'"' //test
     );
$compileurl = array(
     1 => COMPILATIONS_PATH.'index.php?interface=Atlas&atom=1&role=0',
     2 => 'index.php?file='.FILEPATH.basename($fullfile).'&operation=1', //immediately load after saving .adl
     3 => 'index.php?file='.FILEPATH.basename($fullfile), //first view after saving .adl
     4 => COMPILATIONS_PATH.'index.php?interface=Atlas&atom=1&role=0', //return to loaded context after saving .pop
     5 => COMPILATIONS_PATH.basename($fullfile,'.adl').'/fs/'.basename($fullfile,'.adl').'.pdf', //go to output (pdf)
     6 => COMPILATIONS_PATH.basename($fullfile,'.adl').'/proto/index.htm', //go to output (proto)
     7 => COMPILATIONS_PATH.basename($fullfile,'.adl').'/diag/'.basename($fullfile,'.adl').'.pdf', //go to output (pdf)
     99 => ''
     );

?>
