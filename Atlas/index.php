<?php
if (!isset($_SERVER['AUTH_USER'])|| $_SERVER['AUTH_USER']=='') {
  if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Ampersand - Bedrijfsregels"');
    echo 'Just enter a name without password. Refresh the page to retry...';
    exit;
  } else {
    DEFINE("USER",str_replace(" ","",$_SERVER['PHP_AUTH_USER']));
  }
} else {
  DEFINE("USER", str_replace("\\", "_", $_SERVER['AUTH_USER']));
}


$browser = get_browser(null, true);
if ($browser["browser"]=="IE") {
	echo "<p>Deze webapplicatie is getest in en afgestemd op FireFox 10.0.2.</p>";
	if($browser["majorver"]==7) {
		echo "<p>Doordat u Internet Explorer 7 gebruikt zullen EDIT-knoppen in deze webapplicatie niet naar behoren werken. De layout van de webapplicatie in IE7 is getest, maar licht afwijkend van FF10.</p>";
	} else {
		echo "<p>Deze webapplicatie is niet getest in de versie van Internet Explorer die u nu gebruikt. Houd rekening met layout-issues en EDIT-knoppen die niet naar behoren werken.</p>";
	}
}


DEFINE("COMPILATIONS_PATH","comp/".USER."/");
@mkdir(COMPILATIONS_PATH);
DEFINE("FILEPATH","comp/".USER."/uploads/");
@mkdir(FILEPATH);
DEFINE("TMPFILEPATH",FILEPATH."temp/");
@mkdir(TMPFILEPATH);

//prevent undefined indexes
if(isset($_REQUEST['output'])) {DEFINE("REQ_OUTPUT",$_REQUEST['output']);} else {DEFINE("REQ_OUTPUT",'');}
if(isset($_REQUEST['operation'])) {DEFINE("REQ_OPERATION",$_REQUEST['operation']);} else {DEFINE("REQ_OPERATION",-1);}
if(isset($_REQUEST['file'])) {DEFINE("REQ_FILE",$_REQUEST['file']);} else {DEFINE("REQ_FILE",'empty.adl');}

$fullfile = REQ_FILE;
if(isset($_POST['adlbestand'])){
        $tmp_name = $_FILES["uploadfile"]["tmp_name"];
        $i=1;
        $name = str_replace(".adl","",$_FILES["uploadfile"]["name"]).'.v'.$i.'.adl';
        while (file_exists(FILEPATH.$name)){
           $j=$i;
           $i++;
           $name = str_replace(".v".$j.".",".v".$i.".",$name);
        }
        move_uploaded_file($tmp_name, FILEPATH.$name);
        $fullfile = FILEPATH.$name;
}
if(isset($_POST['adllaad'])){
        $fullfile = FILEPATH.$_POST['filename'];
}
if(isset($_POST['adltekst']) || REQ_OPERATION==3 || REQ_OPERATION==2){
   $dtstr = '.'.strftime('%Y-%m-%d.%H-%M-%S').'.';
   $oldfile = basename(REQ_FILE);
   if (isset($_POST['filename'])) {$oldfile = $_POST['filename'];} 
   if (preg_match("/\.\d{4}\-\d{2}\-\d{2}\.\d{2}-\d{2}-\d{2}\./", $oldfile)==0)
       $fullfile = FILEPATH.str_replace(".adl","",$oldfile).$dtstr."adl";
   else
       $fullfile = FILEPATH.preg_replace("/\.\d{4}\-\d{2}\-\d{2}\.\d{2}-\d{2}-\d{2}\./",$dtstr, $oldfile);
}
$file = basename($fullfile);

if(isset($_POST['adlinclude'])){
	$tmp_name = $_FILES["includedfile"]["tmp_name"];
	$dest_name = FILEPATH.$_FILES["includedfile"]["name"];
	$tmp_dest_name = TMPFILEPATH.$_FILES["includedfile"]["name"];
	if ($_FILES["includedfile"]["error"]===0){
		move_uploaded_file($tmp_name, $tmp_dest_name);
		if ($_FILES["includedfile"]["size"]>1048576) { //I could use php.ini, but I want the installation of RAP to be as easy as possible
			echo "Het bestand dat u probeert te uploaden is groter dan wij willen toestaan nl. groter dan 1MB.";
		} elseif (file_exists($dest_name)){
			echo "De naam van het include-bestand dat u probeert te uploaden bestaat al op de server. Gebruik een andere naam door het bestand op uw computer een andere naam te geven, evt. door een kopie te maken.";
		} else	{
			$adl = file_get_contents($tmp_dest_name);
			if (strpos($adl,"CONTEXT")===false || strpos($adl,"ENDCONTEXT")===false){
				echo "U mag alleen adl bestanden uploaden.";
			} else {
				copy($tmp_dest_name,$dest_name);
			}
		}
		unlink($tmp_dest_name);
	} else {echo "Er is een upload-error: ".$_FILES["includedfile"]["error"];}
}

DEFINE("LOGPATH","comp/".USER."/log/");
@mkdir(LOGPATH);
//$target = escapeshellcmd(COMPILATIONS_PATH.'log/');
//$source = escapeshellcmd(FILEPATH.$file->getId().'.adl');
//if(!is_dir($target)) mkdir($target) or exit('error:could not create directory '.$target);
if(is_file(LOGPATH.'error.txt')) unlink(LOGPATH.'error.txt');
if(is_file(LOGPATH.'verbose.txt')) unlink(LOGPATH.'verbose.txt');
$descriptorspec = array(
      0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
      //1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
      1 => array("file", LOGPATH."verbose.txt", "a"),  // stdout is a pipe that the child will write to
      //2 => array("pipe", "w") // stderr is a pipe that the child will write to
      2 => array("file", LOGPATH."error.txt", "a") // stderr is a pipe that the child will write to
  //    2 => array("file", "/error-output.txt" ,"a") // stderr is a file to write to
      );
//echo getcwd();
include "operations.php";

if (isset($_REQUEST['operation']) || isset($_POST['adltekst']) || isset($_POST['adlbestand']) || isset ($_POST['adllaad'])){
   if (isset($_POST['adllaad'])|| isset($_POST['adlbestand'])) {$operation = 1;}
   elseif (isset($_POST['adltekst'])) {
          $operation = 1;
          file_put_contents($fullfile,$_POST['adltext']);
   } else $operation = $_REQUEST['operation'];

   $process = proc_open($commandstr[$operation], $descriptorspec, $pipes, getcwd());
   if (is_resource($process)) {
        fclose($pipes[0]);
       //fclose($pipes[2]);
       //$perr = stream_get_contents($pipes[2]);
       //$pout = stream_get_contents($pipes[1]);
       //fclose($pipes[1]);
       //fclose($pipes[2]);
       // It is important that you close any pipe before calling
       // proc_close in order to avoid a deadlock
       $return_value = proc_close($process);
   }

   $errorlns = '';
   $verboselns = '';
   if (file_exists(LOGPATH.'error.txt')){
       foreach( file ( escapeshellcmd(LOGPATH.'error.txt')) as $line)
              {$errorlns = $errorlns.'<p>'.$line.'</p>'; }
   }
   if (file_exists(LOGPATH.'verbose.txt'))
       foreach( file ( escapeshellcmd(LOGPATH.'verbose.txt')) as $line)
              {$verboselns = $verboselns.'<p>'.$line.'</p>'; }
} //end running the operation
?>
<!DOCTYPE html>
<HTML>
<HEAD>
<?php
if (isset($operation) && $compileurl[$operation]!='' && $errorlns==''  && $verboselns=='') //type errors are put on the verbose stream
   $url = $compileurl[$operation];
//if (isset($_REQUEST['adlhuidige']) || (file_exists(COMPILATIONS_PATH.'index.php') && !isset($_REQUEST['operation']) && !isset($_REQUEST['file'])))
if (isset($_REQUEST['adlhuidige']))
   $url = $compileurl[1];
if (isset($_REQUEST['logout']))
   $url = 'logout.htm';
if (isset($url)){
	$x = explode('?',$url);
	if (file_exists($x[0])) echo '<meta HTTP-EQUIV="REFRESH" content="0; url='.$url.'">';
	else $notarget=True;
}

?>
<meta charset="UTF-8"> 
<TITLE>Ampersand</TITLE>
<SCRIPT type="text/javascript" src="overlib421/overlib.js"><!-- overLIB (c) Erik Bosrup --></SCRIPT>
<link rel="stylesheet" type="text/css" href="style.css" />
</HEAD>
<BODY>
  <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div><!--needed for overLIB-->

<p><div style="width:100%;background-color:#ffffff;margin:0px;padding:0px;top:0px"> <img style="margin:0px;padding:0px" src="ou.jpg">
</div></p>
<?php
if (isset($notarget)){
   echo '<H2>Pagina '.$url.' bestaat niet. Waarschuw de systeembeheerder.</H2>';
   $pdflog = COMPILATIONS_PATH.$_REQUEST['output'].'log';
   echo $pdflog;
   if (file_exists($pdflog)){
       foreach( file ( escapeshellcmd($pdflog)) as $line)
              {echo '<p>'.$line.'</p>'; }
   }
}
if (REQ_OPERATION==3) echo '<H2>Het script wordt geladen. Wacht tot de browser aangeeft klaar te zijn.</H2>';
if (isset($operation)){
   if ($compileurl[$operation]!='' && $errorlns=='' && !isset($notarget))
      echo '<A HREF="'.$compileurl[$operation].'">klik hier om naar de output te gaan.</A>';
   echo $verboselns;
   echo $errorlns;
}else{
   echo '<FORM name="myForm" action="'.$_SERVER['REQUEST_URI'].'" method="POST" enctype="multipart/form-data">';


   echo '<H1>Laad de context in de Atlas...</H1>';
   if (file_exists(COMPILATIONS_PATH.'index.php')){
     echo '<p><input type="submit" name="adlhuidige" value="... die '.USER.' het laatst geladen heeft (return/cancel)"/>';
     echo '<a href="javascript:void(0);"';
     echo 'onmouseover="return overlib(\'<p>Let op! Eventuele wijzigingen in het tekstveld gaan verloren!</p>\',WIDTH, 350);"';
     echo 'onmouseout="return nd();">';
     echo '<IMG SRC="warning.png" /></a></p>';
   }

   echo '<p><input type="submit" name="adlbestand" value="... uit bestand op uw computer (upload)" />';
   echo '<a href="javascript:void(0);"';
   echo 'onmouseover="return overlib(\'<p>Let op! Eventuele wijzigingen in het tekstveld gaan verloren!</p>\',WIDTH, 350);"';
   echo 'onmouseout="return nd();">';
   echo '<IMG SRC="warning.png" /></a>';
   echo '<a href="javascript:void(0);"';
   echo 'onmouseover="return overlib(\'<p>Verondersteld wordt dat een bestand in UTF-8 gecodeerd is.</p>\',WIDTH, 350);"';
   echo 'onmouseout="return nd();">';
   echo '<IMG SRC="info.png" /></a>';
   echo '<input type="file" name="uploadfile" /></p>';

   if (!isset($_REQUEST['browse'])){     
     echo '<p><input type="submit" name="adltekst" value="... uit onderstaand tekstveld (save)"/></p>';

 /* not needed?
     if (isset($_REQUEST['file'])){
       echo '<p><input type="submit" name="adllaad" value="... uit in tekstveld geladen bestand (reload)"/>';
       echo '<a href="javascript:void(0);"';
       echo 'onmouseover="return overlib(\'<p>Let op! Eventuele wijzigingen in het tekstveld gaan verloren!</p>\',WIDTH, 350);"';
       echo 'onmouseout="return nd();">';
       echo '<IMG SRC="warning.png" /></a>';
       echo '<a href="javascript:void(0);"';
       echo 'onmouseover="return overlib(\'<p>De laadoptie &quot;uit onderstaand tekstveld (save)&quot; cre?ert een nieuwe contextversie in een nieuw serverbestand<p/><p>Als u geen wijzigingen in het tekstveld heeft gemaakt, of deze niet wil opslaan, gebruik dan deze laadoptie</p><p>De contextversie uit serverbestand '.$fullfile.' zal worden geladen.</p>\',WIDTH, 350);"';
       echo 'onmouseout="return nd();">';
       echo '<IMG SRC="info.png" /></a></p>';
     }
 */

     echo '<p>Naam van contextversie in tekstveld ';
     echo '<input type="text" name="filename" value="'.$file.'"/>';
     echo '<a href="javascript:void(0);"';
     echo 'onmouseover="return overlib(\'<p>U mag deze naam wijzigingen.</p><p>Als u laadoptie &quot;... uit onderstaand tekstveld (save)&quot; gebruikt, dan wordt de contextversie in het tekstveld onder deze naam in een serverbestand opgeslagen.</p><p>Een timestamp zal toegevoegd (of ververst) worden.</p>\',WIDTH, 350);"';
     echo 'onmouseout="return nd();">';
     echo '<IMG SRC="info.png" /></a></p>';
     ?>
     <P><textarea name="adltext" cols=100 rows=10><?php
     $i=0;
     foreach( file (escapeshellcmd($fullfile)) as $line){
       $i++;
       $line = (preg_replace('/{-(\d+)-}/','',$line));
       echo '{-'.$i.'-}'.$line;
     }?></textarea></P>
     <?php
   }
   if (!isset($_REQUEST['showadvanced'])){
	   $showadv = $_SERVER['REQUEST_URI'].(count($_REQUEST)===0?"?":"&")."showadvanced";
	   echo "<a href='".$showadv."'>+ Toon geavanceerde functionaliteit</a>";
   } else {
	   echo '<H1>Bestanden uploaden tbv INCLUDE';
   echo '</H1>';
   echo '<p><input type="submit" name="adlinclude" value="Upload bestand" />';
   echo '<a href="javascript:void(0);"';
   echo 'onmouseover="return overlib(\'<p>Let op! Eventuele wijzigingen in het tekstveld gaan verloren!</p>\',WIDTH, 350);"';
   echo 'onmouseout="return nd();">';
   echo '<IMG SRC="warning.png" /></a>';
   echo '<a href="javascript:void(0);"';
   echo 'onmouseover="return overlib(\'<p>Ge-uploade bestanden kunnen gebruikt worden in het ADL-statement <b>INCLUDE &quot;bestandsnaam&quot;</b>.</p><p>Ge-uploade bestanden kunnen <b>NIET</b> overschreven worden. U zult een te uploaden bestand lokaal een unieke (geversioneerde) naam moeten geven om de upload te laten slagen.</p>\',WIDTH, 700);"';
   echo 'onmouseout="return nd();">';
   echo '<IMG SRC="info.png" /></a>';
   echo '<input type="file" name="includedfile" />';
   echo '</p>';
   echo '<b>Reeds ge-uploade bestanden (read-only)</b>';
   if ($dh = opendir(FILEPATH)) {
        while (($file = readdir($dh)) !== false) {
            if (!is_dir($file)) echo "<p><a href='".FILEPATH.$file."'>".$file."</a></p>";
        }
        closedir($dh);
   }

   }

   echo '</FORM>';


   
}
?>



</BODY>
</HTML>

