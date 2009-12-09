<?php
  if (!isset($_SERVER['AUTH_USER'])) {
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
      header('WWW-Authenticate: Basic realm="Ampersand - Bedrijfsregels"');
      echo 'Just enter your WIKI-werkplaats account. Refresh the page to retry...';
      exit;
    } else {
      DEFINE("USER","PHP_".$_SERVER['PHP_AUTH_USER']);
    }
  } else {
    //IF Windows Authentication has been enabled on IIS then use the windows account.
    DEFINE("USER",str_replace("\\", "_", $_SERVER['AUTH_USER']));
  }
  DEFINE("IMGPATH","");
  DEFINE("FILEPATH","comp/".USER."/");
  DEFINE("COMPILATIONS_PATH","comp/".USER."/");
  DEFINE("ADL_PATH_ABS","/Users/basj/ADL_ou/");
  passthru ('PATH=$PATH:'.ADL_PATH_ABS);// or exit('error:Cannot set PATH directive using exec');
  session_start();
  require "inc/Session.inc.php";
  require "inc/Bestand.inc.php";
  require "inc/Actie.inc.php";
  require "inc/Operatie.inc.php";
  require "inc/connectToDataBase.inc.php";
  $ses  = readSession(session_id()) or exit('error:Cannot find session, ensure cookies are enabled');
  if($ses->get_ip()!=$_SERVER['REMOTE_ADDR']){
    exit('error:Cannot find a session for your IP, ensure cookies are enabled');
  }
  $file = readBestand($ses->get_file()) or exit('error:Cannot find the file to compile. Upload a file first');
  if(!isset($_REQUEST['op'])) exit('error:Variable \'op\' not given'); else $op = $_REQUEST['op'];
  $opr = readOperatie($op) or exit('error:Operation op=\''.$op.'\' unknown');
  function ok($i){
    return '<A HREF="'.COMPILATIONS_PATH.$i.'/"><IMG SRC="'.IMGPATH.'ok.png" /></A>';
  }
  foreach($file->get_compilations() as $c){
    if($op==$c['operatie']){
      // check the progress of the compilation
      if (file_exists(COMPILATIONS_PATH.$file->getId().'_'.$op.'/done')){
        exit('ok:'.ok($file->getId().'_'.$op));
      }else{
        sleep(5); // wait some time before checking again
        exit('hold:op='.$op);
      }
    }
  }
  $running=true;
  set_time_limit(10);
  function shutdown () {
    if($running)
    echo ('hold:op='.$op);
  }
  register_shutdown_function('shutdown');
  $target = escapeshellcmd(COMPILATIONS_PATH.$file->getId().'_'.$op.'/');
  if(!is_dir($target)) mkdir($target) or exit('error:could not create directory '.$target);
  $source = escapeshellcmd(FILEPATH.$file->getId().'.adl');
  $act = new Actie(null,$file->getId(),$op);
  if($act->save()!==false){
    // in linux:
    // exec(sprintf($opr->get_call(),$target,$source,$file->getId()).';touch '.COMPILATIONS_PATH.$op.'/done');
    // but this has to be run on a windows machine, so:
    // |sort| is used as ;
    // type nul > is used as touch
    // (both methods work in linux as well)
    $str = ''.sprintf($opr->get_call(),$target,$source,$file->getId()).' |sort| type nul > "'.$target.'done"';
    //echo $str."\n<br />";
    unset($out);
    exec($str,$out);
    //print_r($out);
    set_time_limit(11);
    $running=false;
    exit('ok:'.ok($file->getId().'_'.$op));
  } else exit('error:Could not save the action into the database');
  ?>
