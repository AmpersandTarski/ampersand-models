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
 * $_REQUEST['operation'] => $operation --operation number, overruled by certain POSTs
 * $_REQUEST['file'] => --uploaded file to fill text field, default empty.adl
 * $_REQUEST['showadvanced'] --show the upload INCLUDE files part.
 * $_REQUEST['logout'] --indicator to logout
 */
/* DEFINE USER */
if (!isset($_SERVER['AUTH_USER'])&& !isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Ampersand - Rule Based Design"');
    echo 'Just enter a name without password. Refresh the page to retry...';
    exit;
} else {
	$usr = isset($_SERVER['AUTH_USER']) ? str_replace(' ', '', $_SERVER['AUTH_USER']) : str_replace(' ', '', $_SERVER['PHP_AUTH_USER']);
	$usr = str_replace("\\", "_", $usr);
	if ($usr=='' || $usr=='shared') {
		header('WWW-Authenticate: Basic realm="Ampersand - Rule Based Design"');
		echo 'Just enter a name without password. Refresh the page to retry...';
		exit;
	} else {DEFINE("USER",$usr);}
}

require "admin/copyload.php";

/* BROWSER SUPPORT WARNINGS */
require('Browscap.php');
$bc = new Browscap('comp');
$bc->doAutoUpdate = False;
$browser = $bc->getBrowser();

if ($browser->Browser!="Firefox" || $browser->MajorVer<11) {
	echo "<p>This web application is tested on and tuned for FireFox 11.0</p>";
	echo "<p>Because you use a different browser this might have effect on the layout or correct behaviour of this application.</p>";
	if ($browser->Browser=="IE") {
		if($browser->MajorVer==7) {
			echo "<p>Because you use Internet Explorer 7 Edit-buttons in this web application will NOT function due to differences in interpretation of JavaScript. The layout has been checked in IE7, but it's a mess due to differences in interpretation of the Cascading Style Sheets &quot;standard&quot;.</p>";
		} else {
			echo "<p>This web application has not been tested in the version of Internet Explorer that you use. There are layout issues (CSS) and Edit-buttons (JavaScript) that do NOT function in other versions of IE e.g. IE7.</p>";
		}
		echo "<p>Besides FireFox, the web application has been tested in Chrome 18.0. In Chrome 18.0 there is one known issue: all images - conceptual diagrams and images in the manual - are not visible.</p>";
	}
	if ($browser->Browser=="Chrome") {
			echo "<p>You use Chrome. This web application has been tested in Chrome 18.0. There is one known issue: all images - conceptual diagrams and images in the manual - are not visible.</p>";
	}
}
 
/* DEFINE PATHS */
DEFINE("COMPILATIONS_PATH","comp/".USER."/");
@mkdir(COMPILATIONS_PATH);
DEFINE("FILEPATH","comp/".USER."/uploads/");
@mkdir(FILEPATH);
DEFINE("TMPFILEPATH",FILEPATH."temp/");
@mkdir(TMPFILEPATH);
DEFINE("LOGPATH","comp/".USER."/log/");
@mkdir(LOGPATH);

if (isset($_REQUEST['userrole']))
	DEFINE("USERROLE",$_REQUEST['userrole']);
elseif (isset($_POST['userrole']))
	DEFINE("USERROLE",$_POST['userrole']);
else
	DEFINE("USERROLE","STUDENT");

/* MAYBE DEFINE REQDIR+REQFILE */
if (isset($_REQUEST['file'])){
	$rfn = basename($_REQUEST['file']);
	$rfd = dirname($_REQUEST['file']).'/';
	if ($rfd == FILEPATH || $rfd == TMPFILEPATH) {
		DEFINE("REQFILE",$rfn);
		DEFINE("REQDIR",$rfd);
	} else {$illegaldir = $rfd;}
}

/* get the full path to the uploaded adl file, upload if needed*/
DEFINE("FULLFILE",getadlfile());
include "operations.php"; //uses FULLFILE and constants defines $commandstr and $compileurl
/* maybe run an operation */
if     (isset($_POST['adllaad']) || isset($_POST['adlbestand']) || isset($_POST['adllaadtekst'])) 
	$operation =  1; //file_exists(COMPILATIONS_PATH.'index.php') ? 1 : 0; //different start page for first load i.e. new user
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

/* after each load delete the Installer.php of RAP and copy content to the admin tables of RAP */
if (file_exists(COMPILATIONS_PATH.'Installer.php') && isset($operation)){
	unlink(COMPILATIONS_PATH.'Installer.php');
	$dbName = 'atlas';
	if ($errorlns=='') copyload(USER);
}

/* try to move the file in the temp directory i.e. do not overwrite files
 * export operations generate files into the temp directory
 */
if (defined('REQDIR') && REQDIR == TMPFILEPATH && file_exists(TMPFILEPATH.REQFILE)){
	if (file_exists(FILEPATH.REQFILE)){
		$rfnexists = REQFILE;
	} else { rename(TMPFILEPATH.REQFILE , FILEPATH.REQFILE); }
}

/* get the next version for a file name */
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

/* uploads the .adl-file if not already uploaded and returns the path to that file */
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
		return (defined('REQFILE')) ?  REQDIR.REQFILE : 'empty.adl';
	}
}

		
/* upload file for INCLUDE */
if(isset($_POST['adlinclude'])){
	$tmp_name = $_FILES["includedfile"]["tmp_name"];
	$dest_name = FILEPATH.($_POST["includefilename"]!='' ? $_POST["includefilename"] : $_FILES["includedfile"]["name"]);
	$tmp_dest_name = TMPFILEPATH.$_FILES["includedfile"]["name"];
	if ($_FILES["includedfile"]["error"]===0){
		move_uploaded_file($tmp_name, $tmp_dest_name);
		if ($_FILES["includedfile"]["size"]>1048576) { //I could use php.ini, but I want the installation of RAP to be as easy as possible
			echo "<h3>The file you try to upload is larger than we allow c.q. larger than 1MB.</h3>";
		} elseif (file_exists($dest_name)){
			echo "<h3>The name of the file you try to upload already exists (see list <i>Previously uploaded files</i>).</h3><h3>Use the input field to provide a different target name.</h3>";
		} else	{
			$adl = file_get_contents($tmp_dest_name);
			if (strpos($adl,"CONTEXT")===false || strpos($adl,"ENDCONTEXT")===false){
				echo "<h3>You may only upload files with a CONTEXT.</h3>";
			} else {
				copy($tmp_dest_name,$dest_name);
			}
		}
		unlink($tmp_dest_name);
	} else {echo "<h3>Error while uploading: ".$_FILES["includedfile"]["error"]."</h3>";}
}

?>
<!DOCTYPE html>
<HTML>
<HEAD>
<?php
/* maybe set $url and auto-redirect to it if it exists */
if (isset($operation) && $compileurl[$operation]!='' && $operation!=4 && $errorlns==''  && $verboselns=='' && !isset($illegaldir) && !isset($rfnexists)) //type errors are put on the verbose stream
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
<p><div style="width:100%;background-color:#ffffff;margin:0px;padding:0px;top:0px"> <img style="margin:0px;padding:0px" src="RAPlogo.png"></div></p>

<?php
/* message in case the output does not exists, and print LaTeX logs if any and applicable */
if (isset($notarget)){
   echo '<H2>Target page '.$url.' does not exist. Tell an administrator e.g. gerard.michels@ou.nl.</H2>';
   $pdflog = dirname($compileurl[$operation]).'/'.basename($compileurl[$operation],'.pdf').'log';
   echo $pdflog;
   if (file_exists($pdflog)){
       foreach( file ( escapeshellcmd($pdflog)) as $line)
              {echo '<p>'.$line.'</p>'; }
   }
   $pdflog0 = dirname($compileurl[$operation]).'/'.basename($compileurl[$operation],'.pdf').'log0';
   echo $pdflog0;
   if (file_exists($pdflog0)){
       foreach( file ( escapeshellcmd($pdflog0)) as $line)
              {echo '<p>'.$line.'</p>'; }
   }
   $pdflog1 = dirname($compileurl[$operation]).'/'.basename($compileurl[$operation],'.pdf').'log1';
   echo $pdflog1;
   if (file_exists($pdflog1)){
       foreach( file ( escapeshellcmd($pdflog1)) as $line)
              {echo '<p>'.$line.'</p>'; }
   }
}
/* print errors moving file from temp directory
 * print operation results and links to move on 
 * ELSE print the FORM for uploading and editing files */
if (isset($illegaldir)){
   echo '<H2>The path of the file is illegal.</H2>';
   echo '<p>'.$illegaldir.'</p>';
   echo '<A HREF="'.$compileurl[1].'">Click here to go to RAP.</A>';
}elseif (isset($rfnexists)){
   echo '<H2>The file cannot be saved. The file name already exists.</H2>';
   echo '<p>You can provide a unique name of a .pop-file after clicking the Edit-button on page <i>Export Atlas</i>.</p>';
   echo '<A HREF="'.$compileurl[1].'">Click here to go to RAP.</A>';
}elseif (isset($operation)){
   if ($operation==1 || $operation==2)
      echo '<H2>The CONTEXT is loaded. Wait untill the browser is ready, you should be redirected to RAP.</H2>';
   if ($operation==4)  echo ($errorlns=='') ? '<H2>The file is saved: <A HREF="index.php?file='.FILEPATH.REQFILE.'">'.REQFILE.'</A>.</H2>' : '<H2>ERROR: The file is not saved.</H2>';
   if ($compileurl[$operation]!='' && $errorlns=='' && !isset($notarget)){
	   if ($operation==1 || $operation==2 || $operation==3 || $operation==4)
		   echo '<A HREF="'.$compileurl[$operation].'">Click here to go to RAP.</A>';
	   else	   echo '<A HREF="'.$compileurl[$operation].'">Click here to go to the output.</A>';
   }
   echo $errorlns;
   echo $verboselns;
}else{
   echo '<FORM name="myForm" action="'.$_SERVER['REQUEST_URI'].'" method="POST" enctype="multipart/form-data">';

   if (file_exists(COMPILATIONS_PATH.'index.php')){
     echo '<H1>Load the context into RAP...</H1>';
     echo '<p><input type="submit" name="adlhuidige" value="... previously loaded by '.USER.' (return/cancel)"/>';
     echo '<a href="javascript:void(0);"';
     echo 'onmouseover="return overlib(\'<p>Attention! Changes made in the text area will be lost!</p>\',WIDTH, 350);"';
     echo 'onmouseout="return nd();">';
     echo '<IMG SRC="warning.png" /></a></p>';
   } else {
	   echo '<H1>Welcome new user '.USER.'!</H1>';
	   echo '<p>On this page you can upload a file with an Ampersand CONTEXT to the server, which will be loaded into the Repository for Ampersand Projects (RAP).</p>';
	   echo '<p>When you do not have a CONTEXT yet, then you can load the empty context <i>empty.adl</i> by clicking <i>... from the text area below (save)</i>.</p>';
	   echo '<p>You will enter RAP where you can read more about RAP in the manual.</p>';
	   echo '<p>When you do have a CONTEXT, then you can use one of the options below to load it into RAP.</p>';
	   echo '<H1>Load the context into RAP...</H1>';
   }

   echo '<p><input type="submit" name="adlbestand" value="... from a file on your system (upload)" />';
   echo '<a href="javascript:void(0);"';
   echo 'onmouseover="return overlib(\'<p>Attention! Changes made in the text area or in the Atlas will be lost!</p>\',WIDTH, 350);"';
   echo 'onmouseout="return nd();">';
   echo '<IMG SRC="warning.png" /></a>';
   echo '<a href="javascript:void(0);"';
   echo 'onmouseover="return overlib(\'<p>You can upload a file with a CONTEXT from your system into RAP.</p><p>A version number will be added to the file name or updated c.q. <i>filename.v*.adl</i>.</p><p>The file should be UTF-8 encoded.</p>\',WIDTH, 350);"';
   echo 'onmouseout="return nd();">';
   echo '<IMG SRC="info.png" /></a>';
   echo '<input type="file" name="uploadfile" /></p>';

   echo '<p><input type="submit" name="adllaadtekst" value="... from the text area below (save)"/>';
   echo '<a href="javascript:void(0);"';
   echo 'onmouseover="return overlib(\'<p>Attention! Changes made in the Atlas will be lost!</p>\',WIDTH, 350);"';
   echo 'onmouseout="return nd();">';
   echo '<IMG SRC="warning.png" /></a>';
   echo '</p>';

   echo '<p>Name for version of CONTEXT in text area ';
   echo '<input type="text" name="filename" value="'.basename(FULLFILE).'"/>';
   echo '<a href="javascript:void(0);"';
   echo 'onmouseover="return overlib(\'<p>You may change the name.</p><p>When you use &quot;... from the text area below (save)&quot; to load, then the CONTEXT will be saved in a server file with that name.</p><p>A version number will be added to the file name or updated c.q. <i>filename.v*.adl</i>.</p>\',WIDTH, 350);"';
   echo 'onmouseout="return nd();">';
   echo '<IMG SRC="info.png" /></a></p>';
   if ($browser->Browser=="Firefox" && $browser->MajorVer>=11) {
	   echo '<P><textarea name="adltext" cols=100 rows=10>';
   } else {echo '<P><textarea name="adltext" cols=100 rows=30>';}
   $i=0;
   foreach( file (escapeshellcmd(FULLFILE)) as $line){
       $i++;
       $line = preg_replace('/{-(\d+)-}/','',$line);
       echo '{-'.$i.'-}'.$line;
   }
   echo '</textarea></P>';

   if (!isset($_REQUEST['showadvanced'])){
	   $showadv = $_SERVER['REQUEST_URI'].(count($_REQUEST)===0?"?":"&")."showadvanced";
	   echo "<a href='".$showadv."'>+ Show extra functions</a>";
	   echo '<a href="javascript:void(0);"';
	   echo 'onmouseover="return overlib(\'<p>Extra functions are available for anybody. These functions are not a necessity for students, but they might be interesting. To use an extra function it may be necessary to consult information sources not included in course materials e.g. http://ampersand.sourceforge.net</p>\',WIDTH, 700);"';
	   echo 'onmouseout="return nd();">';
	   echo '<IMG SRC="info.png" /></a>';
   } else {
	   echo '<H1>Use RAP in the role of';
	   echo '</H1>';
	   echo '<p><input type="radio" name="userrole" value="Student" checked="true" /> Student</p>';
	   echo '<p><input type="radio" name="userrole" value="StudentDesigner" /> Student Designer</p>';
	   echo '<p><input type="radio" name="userrole" value="Designer" /> Designer</p>';
	   
	   echo '<H1>Upload files to INCLUDE';
	   echo '</H1>';
	   echo '<p><input type="submit" name="adlinclude" value="Upload file" />';
	   echo '<a href="javascript:void(0);"';
	   echo 'onmouseover="return overlib(\'<p>Attention! Changes made in the text area will be lost!</p>\',WIDTH, 350);"';
	   echo 'onmouseout="return nd();">';
	   echo '<IMG SRC="warning.png" /></a>';
	   echo '<a href="javascript:void(0);"';
	   echo 'onmouseover="return overlib(\'<p>Uploaded files can be used in the ADL-statement <b>INCLUDE &quot;filename&quot;</b>.</p><p>Uploaded files can <b>NOT</b> be overwritten. You can provide a unique target name for a file to upload in the input field below.</p><p>The file should be UTF-8 encoded.</p>\',WIDTH, 700);"';
	   echo 'onmouseout="return nd();">';
	   echo '<IMG SRC="info.png" /></a>';
	   echo '<input type="file" name="includedfile" />';
	   echo '</p>';
	   echo '<p>Other target name for file to upload ';
	   echo '<input type="text" name="includefilename"/>';
	   echo '<a href="javascript:void(0);"';
	   echo 'onmouseover="return overlib(\'<p>The file to upload will be uploaded with the name from this input field, unless there is already an uploaded file with that name.</p><p>When you leave the input field blank, then the original file name will be used.</p>\',WIDTH, 700);"';
	   echo 'onmouseout="return nd();">';
	   echo '<IMG SRC="info.png" /></a></p>';
	   echo '<b>Previously uploaded files (read-only)</b>';
	   if ($dh = opendir(FILEPATH)) {
		   while (($fn = readdir($dh)) !== false) {
			   if (!is_dir($fn)&&$fn!='temp') echo "<p><a href='".FILEPATH.$fn."'>".$fn."</a></p>";
		   }
		   closedir($dh);
	   }
   }
   echo '</FORM>';
} //end !isset($operation)
?>
</BODY>
</HTML>
