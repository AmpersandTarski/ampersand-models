<?php

$commandstr = array(
     1 => './adl577-2093 -p'.COMPILATIONS_PATH.' --theme='.USERROLE.' --dbName=atlas --css=RAP.css --import="'.FULLFILE.'" --fileformat=ADL1 --namespace='.USER.' rap.adl', //load
     2 => './adl577-2093 -o'.TMPFILEPATH.' --export="'.basename(FULLFILE).'" --fileformat=ADL1 --namespace='.USER.' rap.adl', //export+load
     3 => './adl577-2093 -o'.TMPFILEPATH.' --export="'.basename(FULLFILE).'" --fileformat=ADL1 --namespace='.USER.' rap.adl', //export
     4 => './adl577-2093 -o'.TMPFILEPATH.' --export="'.basename(FULLFILE).'" --fileformat=POP1 --namespace='.USER.' rap.adl', //export .pop
     5 => './amp577 -o'.COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/fs/ -f Latex "'.FULLFILE.'"', //fspec pdf
     6 => './adl577-2093 -p'.COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/proto/ --dbName=adl --namespace='.USER.' -x --theme=student "'.FULLFILE.'"', //proto
     7 => './amp577 -o'.COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/diag/ -f Latex --diagnosis "'.FULLFILE.'"', //diagnosis pdf
     8 => './adl577-2093 -p'.COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/proto/ --dbName=adl --namespace='.USER.' "'.FULLFILE.'"', //proto
     99 => './adl577-2093 --verbose "'.FULLFILE.'"' //test
     );
$compileurl = array(
     1 => COMPILATIONS_PATH.'index.php?interface=Atlas (Play)&atom=1&role=0',
     2 => 'index.php?file='.FILEPATH.basename(FULLFILE).'&operation=1&userrole='.USERROLE, //immediately load after saving .adl
     3 => 'index.php?file='.FILEPATH.basename(FULLFILE).'&userrole='.USERROLE, //first view after saving .adl
     4 => COMPILATIONS_PATH.'index.php?interface=Atlas (Play)&atom=1&role=0', //return to loaded context after saving .pop
     5 => COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/fs/'.basename(FULLFILE,'.adl').'.pdf', //go to output (pdf)
     6 => COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/proto/index.php', //go to output (proto)
     7 => COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/diag/'.basename(FULLFILE,'.adl').'.pdf', //go to output (pdf)
     8 => COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/proto/index.php', //go to output (proto)
     99 => ''
     );

?>
