<?php

$commandstr = array(
     1 => './adl579-2100 -p'.COMPILATIONS_PATH.' --theme='.USERROLE.' --css=RAP.css --import="'.FULLFILE.'" --fileformat=ADL1 --namespace='.USER.' --dbName=atlas --sqlHost=145.20.32.24 --sqlLogin=atlas --sqlPwd=albu3m RAP.adl', //load
     2 => './adl579-2100 -o'.TMPFILEPATH.' --export="'.basename(FULLFILE).'" --fileformat=ADL1 --namespace='.USER.' RAP.adl', //export+load
     3 => './adl579-2100 -o'.TMPFILEPATH.' --export="'.basename(FULLFILE).'" --fileformat=ADL1 --namespace='.USER.' RAP.adl', //export
     4 => './adl579-2100 -o'.TMPFILEPATH.' --export="'.basename(FULLFILE).'" --fileformat=POP1 --namespace='.USER.' RAP.adl', //export .pop
     5 => './amp579 -o'.COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/fs/ -f Latex "'.FULLFILE.'"', //fspec pdf
     6 => './adl579-2100 -p'.COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/proto/ -x --theme=student --namespace='.USER.' --dbName=adl --sqlHost=145.20.32.24 --sqlLogin=adl --sqlPwd=actie2f "'.FULLFILE.'"', //proto student
     7 => './amp579 -o'.COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/diag/ -f Latex --diagnosis "'.FULLFILE.'"', //diagnosis pdf
     8 => './adl579-2100 -p'.COMPILATIONS_PATH.basename(FULLFILE,'.adl').'/proto/ --namespace='.USER.' --dbName=adl --sqlHost=145.20.32.24 --sqlLogin=adl --sqlPwd=actie2f "'.FULLFILE.'"', //proto student
     99 => './adl579-2100 --verbose "'.FULLFILE.'"' //test
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
