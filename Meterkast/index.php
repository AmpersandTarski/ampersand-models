<?php

  if (!isset($_SERVER['AUTH_USER'])|| $_SERVER['AUTH_USER']=='') {
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
      header('WWW-Authenticate: Basic realm="Ampersand - Bedrijfsregels"');
      echo 'Just enter a name without password. Refresh the page to retry...';
      exit;
    } else {
      DEFINE("USER","PHP_".$_SERVER['PHP_AUTH_USER']);
    }
  } else {
    DEFINE("USER", str_replace("\\", "_", $_SERVER['AUTH_USER']));
  }

  DEFINE("IMGPATH","");
  DEFINE("FILEPATH","comp/".USER."/");
  DEFINE("COMPILATIONS_PATH","comp/".USER."/");
  @mkdir(FILEPATH);
  session_start();
  if ($_POST['adlsessie']){ $_SESSION["adlsessie"]=$_POST['sessie']; }
  elseif ($_POST['adlbestand'] || $_POST['adltekst']){ session_regenerate_id(); $_SESSION["adlsessie"]=session_id(); }
  else {$_SESSION["adlsessie"]=session_id();}
  require "inc/Session.inc.php";
  require "inc/Bestand.inc.php";
  require "inc/Operatie.inc.php";
  require "inc/connectToDataBase.inc.php";
  //$DB_debug=6;
  $ses = new Session($_SESSION["adlsessie"]);
  if($ses->isNew()){
    $ses->set_ip($_SERVER['REMOTE_ADDR']);
    $ses->save();
//  }else if($ses->get_ip()!=$_SERVER['REMOTE_ADDR']){ //GMI-> Do I need this check/regenerate action???
//      $n=0;
//      while (!$ses->isNew() && $n<50) {
//        $n++;
//        session_regenerate_id();
//        $ses = new Session(session_id(),$_SERVER['REMOTE_ADDR'],null);
//      }
//      if($n>=50) die('Error creating new session, please reload this page or contact the system administrator.');
//      $ses->save();
  }

  if($_POST['adlbestand']){
    delBestand($ses->get_file());
    $file = new Bestand(null,$_FILES['file']['name'],$ses->getId(),array());
    if($file->save()!==false){
      move_uploaded_file($_FILES['file']['tmp_name'],FILEPATH.$file->getId().'.adl');
    }else{
      echo $file->getId();
      $file = false;
    }
  }
  else if($_POST['adltekst']){
    if ($_POST['scriptname']=='') {$sn =  'phptekstinvoer';} else {$sn =  $_POST['scriptname'];}	  
    delBestand($ses->get_file());
    $file = new Bestand(null,$sn,$ses->getId(),array());
    if($file->save()!==false){
      file_put_contents(FILEPATH.$file->getId().'.adl',$_POST['adltext']);
    }else{
      echo $file->getId();
      $file = false;
    }
  } else {$file=readBestand($ses->get_file());}
  
	  DEFINE("HANDLEIDING","<p>Met dit tool kunnen verschillende bewerkingen op een ADL script uitgevoerd worden. Om een bewerking uit te kunnen voeren moet een ADL script naar de server worden gestuurd. Dit kan op drie manieren:</p><p> * Selecteer een .adl bestand op uw computer<p/><p> * Een eerdere sessie hervatten<p/><p> * Plak (of wijzig) ADL code in het tekstveld<p/><p>Vervolgens kunnen één of meerdere bewerkingen uitgevoerd worden door op <i>Compile</i> te klikken in de sectie <b>Voer een bewerking uit op het geladen ADL script</b>. Sommige bewerkingen genereren output die online bekeken kan worden. Als een dergelijke bewerking succesvol wordt uitgevoerd, dan verschijnt er een <b>vinkje</b> dat tevens de link is naar de gegenereerde output. Als een bewerking geen output genereert, dan wordt een succesvolle bewerking aangegeven met de melding <i>De bewerking is succesvol uitgevoerd</i>.<p/><p>Iedere aanpassing aan het script, ook in het tekstveld, vereist dat het script opnieuw naar de server wordt gestuurd. Iedere aanpassing krijgt een eigen, nieuwe sessie. Het huidige sessienummer ziet u boven aan de pagina. Op dit moment moet u dit nummer nog zelf onthouden om deze sessie op een later moment te hervatten. Als u een script naar de server stuurt, dan wordt dat script weergegeven in het tekstveld onder aan de pagina.</p><p>Bekijk de meldingen van de andere informatie symbolen voor detailinformatie.</p>");
	  DEFINE("SCRIPTNAAM","Als u het script in het tekstveld laadt, dan wordt dit script met deze naam op de server opgeslagen. Als u geen naam opgeeft, dan krijgt het script de naam <i>phptekstinvoer</i>");
	  DEFINE("ADLTEKST","U kunt een ADL script in het tekstveld plakken en deze via de knop <b>ADL script (her)laden</b> naar de server sturen. Als u al een script geladen heeft dan toont het tekstveld het huidige geladen script voorzien van regelnummers in ADL commentaar. U kunt dit script in het tekstveld wijzigen. Wijzigingen moeten via de knop <b>ADL script (her)laden</b> naar de server gestuurd worden. Een gewijzigd script krijgt een nieuw sessienummer.");
	  DEFINE("SESSIELADEN","Als u het sessienummer heeft onthouden, dan kunt u die sessie hervatten door het sessienummer in het desbetreffende veld in te vullen en op de knop <b>Laad sessienummer</b> te klikken. U kunt vervolgens nog niet uitgevoerde bewerkingen uitvoeren, of u kunt naar de output van eerdere bewerkingen navigeren.");
	  DEFINE("ADLBEWERKING","Klik op <b>Compile</b> achter de bewerking die u wil uitvoeren. Er zijn vier bewerkingen mogelijk. <b>Test</b> probeert het script in te lezen en de relatie algebra expressies te typeren zonder daarbij bijzondere output te genereren. Als dit lukt, dan wordt de melding <i>De bewerking is succesvol uitgevoerd</i> weergegeven. De overige drie bewerkingen genereren Atlas data en plaatjes. Het is mogelijk om data en plaatjes in afzonderlijke bewerkingen te genereren. Dit is nuttig als u een script heeft waarvan het genereren van plaatjes te lang duurt naar de zin van de web server. Dit is mogelijk het geval als u de melding <i>error retrieving compile.php</i> terugkrijgt.");
	  DEFINE("BESTANDLADEN","Selecteer het bestand op uw filesysteem met daarin het ADL script dat u wil laden. Klik op de knop <b>Bestand uploaden</b>. Het script verschijnt in het tekstveld onderaan de pagina, voorzien van regelnummers in ADL commentaar. Wijzigingen in het tekstveld worden <i>niet</i> gesynchroniseerd met het bestand op uw filesysteem");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<TITLE>ADL</TITLE>
<SCRIPT type="text/javascript" src="compile.js"></SCRIPT>
<SCRIPT type="text/javascript" src="overlib421/overlib.js"><!-- overLIB (c) Erik Bosrup --></SCRIPT>
<link rel="stylesheet" type="text/css" href="style.css" />
</HEAD>
<BODY>
  <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div><!--needed for overLIB-->
  <a href="javascript:void(0);" 
  onmouseover="return overlib('<?php echo (HANDLEIDING); ?>',STICKY, CAPTION, 'Handleiding',CLOSECLICK,WIDTH, 500);"
     onmouseout="return nd();">
     <?php echo '<IMG SRC="'.IMGPATH.'info.png" />'; ?></a>
<?php if ($file && !isset($_REQUEST['newFile'])) { ?>
  <H5>Sessienummer: <?php echo $ses->getId(); ?>. Geladen script: <?php echo htmlspecialchars($file->get_path()); echo ". U bent ingelogd als: ";echo USER;echo ".</H5>";?>
  <hr/>
  <H3>Voer een bewerking uit op het geladen ADL script
  <a href="javascript:void(0);" 
     onmouseover="return overlib('<?php echo (ADLBEWERKING); ?>',WIDTH, 350);"
     onmouseout="return nd();">
     <?php echo '<IMG SRC="'.IMGPATH.'info.png" />'; ?></a>
  </H3>
  <UL>
  <?php
  $havops=array();
  foreach($file->get_compilations() as $c){
    if(!isset($havops[$c['operatie']])) $havops[$c['operatie']] = array();
    $havops[$c['operatie']][]=$c['id'];
  }
  function isCompiled($file,$op){
    foreach($file->get_compilations() as $c){
     if ($c['operatie']==$op) return true;
    } 
    return false;
  }
  foreach(getEachOperatie() as $op){
    $opr = new Operatie($op); //selects an operation based on identifier
    echo '<LI id="op'.$op.'">'.$opr->get_naam().': <SPAN>'; // reason that getName() is not shown as htmlspecialchars: only the Admin can change this, and maybe he'd like to put in an image, such as the LaTeX logo
    if(isset($havops[$op])){
      foreach($havops[$op] as $i){
        $target = escapeshellcmd(COMPILATIONS_PATH.$file->getId().'_'.$op.'/');
        $source = escapeshellcmd(FILEPATH.$file->getId().'.adl');
        $compileurl = ''.sprintf($opr->get_outputURL(),$target,$source,$file->getId(),USER);    
	echo '<A HREF="'.$compileurl.'" target="_blank"/>';
        if (isCompiled($file,$op)) echo '<IMG SRC="'.IMGPATH.'ok.png" />'; else echo '???';
        echo '</A>';
      }
    }else{
       echo '<small><A href="JavaScript:compile(\''.$op.'\');">Compile</A></small>';
    }
    echo '</SPAN></LI>';
  }
  ?>
  </UL>
<?php } ?>

  <FORM name="myForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
  <hr/>
  <H3>Selecteer een .adl bestand op uw computer
  <a href="javascript:void(0);" 
     onmouseover="return overlib('<?php echo (BESTANDLADEN); ?>',WIDTH, 350);"
     onmouseout="return nd();">
     <?php echo '<IMG SRC="'.IMGPATH.'info.png" />'; ?></a>
  </H3>
  <P><input type="file" name="file" /></P>
  <P><input type="submit" name="adlbestand" value="Bestand uploaden" /></P>
  <hr/>
  <H3>Een eerdere sessie hervatten
  <a href="javascript:void(0);" 
     onmouseover="return overlib('<?php echo (SESSIELADEN); ?>',WIDTH, 350);"
     onmouseout="return nd();">
     <?php echo '<IMG SRC="'.IMGPATH.'info.png" />'; ?></a>
  </H3>
  <P><input type="text" name="sessie" value="<sessienummer>"/></P>
  <P><input type="submit" name="adlsessie" value="Laad sessienummer" /></P>
  <hr/>
  <H3>Plak (of wijzig) ADL code in het tekstveld
  <a href="javascript:void(0);" 
     onmouseover="return overlib('<?php echo (ADLTEKST); ?>',WIDTH, 350);"
     onmouseout="return nd();">
     <?php echo '<IMG SRC="'.IMGPATH.'info.png" />'; ?></a>
  </H3>
  <P><input type="submit" name="adltekst" value="ADL script (her)laden" /></P>
  <P>Script naam <input type="text" name="scriptname"/> (optioneel)
  <a href="javascript:void(0);" 
     onmouseover="return overlib('<?php echo (SCRIPTNAAM); ?>',WIDTH, 350);"
     onmouseout="return nd();">
     <?php echo '<IMG SRC="'.IMGPATH.'info.png" />'; ?></a>
  </P>
  <P><textarea name="adltext" cols=100 rows=30><?php if ($file && !isset($_REQUEST['newFile'])) {
	        //if () {  //user toevoegen aan meterkast.adl en juiste FILEPATH nemen.
	     //} else {
	     $i=0;
	     foreach( file ( escapeshellcmd(FILEPATH.$file->getId().'.adl')) as $line) //}
	     {
		     $i++;
		     $line = (preg_replace('/{-(\d+)-}/','',$line));
		     echo '{-'.$i.'-}'.$line;
	     }
	    } else { echo '<plak hier ADL code>'; } 
     ?>
     </textarea></P>
  </FORM>
</BODY>
</HTML>
