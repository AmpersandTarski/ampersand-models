<?php
  DEFINE("IMGPATH","");
  DEFINE("FILEPATH","comp/");
  DEFINE("COMPILATIONS_PATH","comp/");
  session_start();
  require "inc/Session.inc.php";
  require "inc/Bestand.inc.php";
  require "inc/Operatie.inc.php";
  require "inc/connectToDataBase.inc.php";
  //$DB_debug=6;
  $ses = new Session(session_id());
  if($ses->isNew()){
    $ses->set_ip($_SERVER['REMOTE_ADDR']);
    $ses->save();
  }else if($ses->get_ip()!=$_SERVER['REMOTE_ADDR']){
      $n=0;
      while (!$ses->isNew() && $n<50) {
        $n++;
        session_regenerate_id();
        $ses = new Session(session_id(),$_SERVER['REMOTE_ADDR'],null);
      }
      if($n>=50) die('Error creating new session, please reload this page or contact the system administrator.');
      $ses->save();
  }
  if(isset($_FILES['file'])){
    delBestand($ses->get_file());
    $file = new Bestand(null,$_FILES['file']['name'],$ses->getId(),array());
    if($file->save()!==false){
      move_uploaded_file($_FILES['file']['tmp_name'],FILEPATH.$file->getId().'.adl');
    }else{
      echo $file->getId();
      $file = false;
    }
  }else $file=readBestand($ses->get_file());

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<TITLE>ADL</TITLE>
<SCRIPT type="text/javascript" src="compile.js"></SCRIPT>
<link rel="stylesheet" type="text/css" href="style.css" />
</HEAD>
<BODY>
<?php if ($file && !isset($_REQUEST['newFile'])) { ?>
  <h1><?php echo htmlspecialchars($file->get_path()); ?></h1>
  <UL>
  <?php
  $havops=array();
  foreach($file->get_compilations() as $c){
    if(!isset($havops[$c['operatie']])) $havops[$c['operatie']] = array();
    $havops[$c['operatie']][]=$c['id'];
  }
  foreach(getEachOperatie() as $op){
    $opr = new Operatie($op);
    echo '<LI id="op'.$op.'">'.$opr->get_naam().': <SPAN>'; // reason that getName() is not shown as htmlspecialchars: only the Admin can change this, and maybe he'd like to put in an image, such as the LaTeX logo
    if(isset($havops[$op])){
      foreach($havops[$op] as $i){
        echo '<A HREF="'.COMPILATIONS_PATH.$file->getId().'_'.$op.'" />';
        if (file_exists(COMPILATIONS_PATH.$file->getId().'_'.$op.'/done')) echo '<IMG SRC="'.IMGPATH.'ok.png" />'; else echo '???';
        echo '</A>';
      }
    }else{
      echo '<small><A href="JavaScript:compile(\''.$op.'\');">Compile</A></small>';
    }
    echo '</SPAN></LI>';
  }
  ?>
  </UL>
  <P>
  <a href="index.php?newFile=1">Bestand vervangen</a>
  </P>
<?php }else { ?>
  <h1>Een .adl bestand uploaden</h1>
  <FORM name="myForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
  <P>Kies een bestand om te vertalen: <input type="file" name="file" /></P>
  <P><input type="submit" name="submit" /></P>
  </FORM>
  <?php
  if($file){
    ?>
    <P>
    <a href="index.php">Reeds geuploade bestand tonen</a>
    </P>
    <?php
  }
} ?>
</BODY>
</HTML>