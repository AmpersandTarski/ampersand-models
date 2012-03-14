<?php

$commandstr = array(
     1 => 'prototype --verbose -p'.COMPILATIONS_PATH.' --css=RAP.css --import="'.$fullfile.'" --importformat=ADL1 --namespace='.USER.' rap.adl',
     2 => 'prototype --verbose -o'.FILEPATH.' --export='.$file.' --namespace='.USER.' atlas',
     3 => 'prototype --verbose -o'.FILEPATH.' --export='.$file.' --namespace='.USER.' atlas',
     4 => 'ampersand --verbose -o'.COMPILATIONS_PATH.' -f Latex "'.$fullfile.'"',
     5 => 'prototype --verbose -p'.COMPILATIONS_PATH.'proto/ --theme=student "'.$fullfile.'"',
     6 => 'ampersand --verbose -o'.COMPILATIONS_PATH.' -f Latex --diagnosis "'.$fullfile.'"',
     99 => 'prototype --verbose "'.$fullfile.'"'
     );
$compileurl = array(
     1 => COMPILATIONS_PATH.'index.php?interface=Overzicht&atom=1&role=0',
     2 => 'index.php?file='.$fullfile.'&operation=1',
     3 => 'index.php?file='.$fullfile,
     4 => COMPILATIONS_PATH.REQ_OUTPUT,
     5 => COMPILATIONS_PATH.'proto/index.htm',
     6 => COMPILATIONS_PATH.REQ_OUTPUT,
     99 => ''
     );

?>
