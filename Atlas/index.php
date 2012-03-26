<?php
/* $_POST['adlbestand'] --UPLOAD+LOAD file
 * $_FILES["uploadfile"]
 * $_POST['adllaadtekst'] --SAVE+LOAD text field
 * $_POST['adltext'] --text field
 * $_POST['adllaad'] --RELOAD text field
 * $_POST['filename'] --file name for text field
 * $_POST['adlinclude'] --UPLOAD file
 * $_FILES["includedfile"]
 * $_POST['adlhuidige'] --return to loaded 
 * $_REQUEST['output'] => REQ_OUTPUT --name of pdf without extension
 * $_REQUEST['operation'] => $operation --operation number, overruled by certain POSTs
 * $_REQUEST['file'] => --uploaded file to fill text field, default empty.adl
 * $_REQUEST['showadvanced'] --show the upload INCLUDE files part.
 * $_REQUEST['logout'] --indicator to logout
 */
/* DEFINE USER */
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

/* BROWSER SUPPORT WARNINGS */
$browser = get_browser(null, true);
if ($browser["browser"]=="IE") {
	echo "<p>Deze webapplicatie is getest in en afgestemd op FireFox 10.0.2.</p>";
	if($browser["majorver"]==7) {
		echo "<p>Doordat u Internet Explorer 7 gebruikt zullen EDIT-knoppen in deze webapplicatie niet naar behoren werken. De layout van de webapplicatie in IE7 is getest, maar licht afwijkend van FF10.</p>";
	} else {
		echo "<p>Deze webapplicatie is niet getest in de versie van Internet Explorer die u nu gebruikt. Houd rekening met layout-issues en EDIT-knoppen die niet naar behoren werken.</p>";
	}
}

/* DEFINE PATHS AND REQ_OUTPUT */
DEFINE("COMPILATIONS_PATH","comp/".USER."/");
@mkdir(COMPILATIONS_PATH);
DEFINE("FILEPATH","comp/".USER."/uploads/");
@mkdir(FILEPATH);
DEFINE("TMPFILEPATH",FILEPATH."temp/");
@mkdir(TMPFILEPATH);
DEFINE("LOGPATH","comp/".USER."/log/");
@mkdir(LOGPATH);
DEFINE("REQ_OUTPUT",(isset($_REQUEST['output'])) ? $_REQUEST['output'] : '');

/* get the full path to the uploaded adl file, upload if needed*/
$fullfile = getadlfile();
include "operations.php"; //uses $fullfile and constants defines $commandstr and $compileurl
/* maybe run an operation */
if     (isset($_POST['adllaad']) || isset($_POST['adlbestand']) || isset($_POST['adllaadtekst'])) 
	$operation =  1;
elseif (isset($_REQUEST['operation']))
	$operation =  $_REQUEST['operation'];
if (isset($operation)){
   if(is_file(LOGPATH.'error.txt')) unlink(LOGPATH.'error.txt');
   if(is_file(LOGPATH.'verbose.txt')) unlink(LOGPATH.'verbose.txt');
   $descriptorspec = array(
      0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
      1 => array("file", LOGPATH."verbose.txt", "a"),  // stdout is a pipe that the child will write to
      2 => array("file", LOGPATH."error.txt", "a") // stderr is a pipe that the child will write to
      );
   //echo getcwd();
   $process = proc_open($commandstr[$operation], $descriptorspec, $pipes, getcwd());
   if (is_resource($process)) {
        fclose($pipes[0]);
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


function nextversion($name){
	$i=1;
	$name = preg_match('/\.v\d+\.adl/',$name) ? $name : str_replace(".adl","",$name).'.v'.$i.'.adl'; //put .vi. before .adl or concat .vi.adl
	while (file_exists(FILEPATH.$name)){
		$j=$i;
		$i++;
		$name = str_replace(".v".$j.".",".v".$i.".",$name);
	}
	return $name;
}
//uploads a file if not already uploaded and returns the path to that file
function getadlfile(){
	if (isset($_POST['adlbestand'])){ //upload file+load
		$name = nextversion($_FILES["uploadfile"]["name"]);
		move_uploaded_file($_FILES["uploadfile"]["tmp_name"], FILEPATH.$name);
		return FILEPATH.$name;
	}
	elseif (isset($_POST['adltext']) && isset($_POST['adllaadtekst'])){ //save txt+load
		$name = nextversion($_POST['filename']);
		file_put_contents(FILEPATH.$name,$_POST['adltext']);
		return FILEPATH.$name;
	}
	else { //no post or isset($_POST['adllaad'])=reload
		return (isset($_REQUEST['file'])) ?  $_REQUEST['file'] : 'empty.adl';
	}
}

		
if(isset($_POST['adlinclude'])){
	$tmp_name = $_FILES["includedfile"]["tmp_name"];
	$dest_name = FILEPATH.($_POST["includefilename"]!='' ? $_POST["includefilename"] : $_FILES["includedfile"]["name"]);
	$tmp_dest_name = TMPFILEPATH.$_FILES["includedfile"]["name"];
	if ($_FILES["includedfile"]["error"]===0){
		move_uploaded_file($tmp_name, $tmp_dest_name);
		if ($_FILES["includedfile"]["size"]>1048576) { //I could use php.ini, but I want the installation of RAP to be as easy as possible
			echo "Het bestand dat u probeert te uploaden is groter dan wij willen toestaan nl. groter dan 1MB.";
		} elseif (file_exists($dest_name)){
			echo "<p>De naam van het include-bestand dat u probeert te uploaden bestaat al op de server (zie lijst <i>Reeds ge-uploade bestanden</i>).</p><p>U kunt een andere naam (evt. met versieaanduiding) opgeven in het daarvoor bestemde invoerveld.</p>";
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

?>
<!DOCTYPE html>
<HTML>
<HEAD>
<?php
if (isset($operation) && $compileurl[$operation]!='' && $errorlns==''  && $verboselns=='') //type errors are put on the verbose stream
   $url = $compileurl[$operation];
if (isset($_POST['adlhuidige']))
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
<p><div style="width:100%;background-color:#ffffff;margin:0px;padding:0px;top:0px"> <img style="margin:0px;padding:0px" src="ou.jpg"></div></p>

<?php
if (isset($notarget)){
   echo '<H2>Pagina '.$url.' bestaat niet. Waarschuw de systeembeheerder.</H2>';
   $pdflog = COMPILATIONS_PATH . REQ_OUTPUT.'log';
   echo $pdflog;
   if (file_exists($pdflog)){
       foreach( file ( escapeshellcmd($pdflog)) as $line)
              {echo '<p>'.$line.'</p>'; }
   }
}

if (isset($operation)){
   if ($operation==1 || $operation==3)
      echo '<H2>Het script wordt geladen. Wacht tot de browser aangeeft klaar te zijn, waarna u automatisch naar de output zou moeten gaan.</H2>';
   if ($compileurl[$operation]!='' && $errorlns=='' && !isset($notarget))
      echo '<A HREF="'.$compileurl[$operation].'">klik hier om naar de output te gaan.</A>';
   echo $errorlns;
   echo $verboselns;
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
   echo 'onmouseover="return overlib(\'<p>U kunt een bestand van uw computer uploaden en laden.</p><p>Een versienummer zal aan de bestandsnaam toegevoegd of ververst worden, nl. <i>bestandsnaam.v*.adl</i>.</p><p>Verondersteld wordt dat het bestand in UTF-8 gecodeerd is.</p>\',WIDTH, 350);"';
   echo 'onmouseout="return nd();">';
   echo '<IMG SRC="info.png" /></a>';
   echo '<input type="file" name="uploadfile" /></p>';

   echo '<p><input type="submit" name="adllaadtekst" value="... uit onderstaand tekstveld (save)"/></p>';

 /* not needed, since you can reload scripts from RAP?
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
   echo '<input type="text" name="filename" value="'.basename($fullfile).'"/>';
   echo '<a href="javascript:void(0);"';
   echo 'onmouseover="return overlib(\'<p>U mag deze naam wijzigingen.</p><p>Als u laadoptie &quot;... uit onderstaand tekstveld (save)&quot; gebruikt, dan wordt de code in het tekstveld onder deze naam in een serverbestand opgeslagen.</p><p>Een versienummer zal aan de bestandsnaam toegevoegd of ververst worden, nl. <i>bestandsnaam.v*.adl</i>.</p>\',WIDTH, 350);"';
   echo 'onmouseout="return nd();">';
   echo '<IMG SRC="info.png" /></a></p>';
   echo '<P><textarea name="adltext" cols=100 rows=10>';
   $i=0;
   foreach( file (escapeshellcmd($fullfile)) as $line){
       $i++;
       $line = preg_replace('/{-(\d+)-}/','',$line);
       echo '{-'.$i.'-}'.$line;
   }
   echo '</textarea></P>';

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
	   echo 'onmouseover="return overlib(\'<p>Ge-uploade bestanden kunnen gebruikt worden in het ADL-statement <b>INCLUDE &quot;bestandsnaam&quot;</b>.</p><p>Ge-uploade bestanden kunnen <b>NIET</b> overschreven worden. U kan een te uploaden bestand een unieke (geversioneerde) naam geven via onderstaande invoerveld.</p><p>Verondersteld wordt dat een bestand in UTF-8 gecodeerd is.</p>\',WIDTH, 700);"';
	   echo 'onmouseout="return nd();">';
	   echo '<IMG SRC="info.png" /></a>';
	   echo '<input type="file" name="includedfile" />';
	   echo '</p>';
	   echo '<p>Andere doelnaam voor te uploaden bestand ';
	   echo '<input type="text" name="includefilename"/>';
	   echo '<a href="javascript:void(0);"';
	   echo 'onmouseover="return overlib(\'<p>Het te uploaden bestand zal op de server opgeslagen worden met de naam die u hier opgeeft, mits er nog geen bestand op de server bestaat met die naam.</p><p>Als u hier niks opgeeft dan zal de oorspronkelijke naam van het bestand worden gebruikt.</p>\',WIDTH, 700);"';
	   echo 'onmouseout="return nd();">';
	   echo '<IMG SRC="info.png" /></a></p>';
	   echo '<b>Reeds ge-uploade bestanden (read-only)</b>';
	   if ($dh = opendir(FILEPATH)) {
		   while (($fn = readdir($dh)) !== false) {
			   if (!is_dir($fn)) echo "<p><a href='".FILEPATH.$fn."'>".$fn."</a></p>";
		   }
		   closedir($dh);
	   }
   }
   echo '</FORM>';
} //end !isset($operation)
?>
</BODY>
</HTML>
