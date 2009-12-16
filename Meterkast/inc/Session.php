<?php // generated with ADL vs. 0.8.10-488
/***************************************\
*                                       *
*   Interface V1.3.1                    *
*   (c) Bas Joosten Jun 2005-Aug 2009   *
*                                       *
*   Using interfaceDef                  *
*                                       *
\***************************************/
  error_reporting(E_ALL); 
  ini_set("display_errors", 1);
  require "interfaceDef.inc.php";
  require "Session.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $ip = @$r['0'];
    if(@$r['1']!=''){
      $file = @$r['1'];
    }else $file=null;
    $Session=new Session($ID,$ip, $file);
    if($Session->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Session='.urlencode($Session->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Session'])){
    if(!$del || !delSession($_REQUEST['Session']))
      $Session = readSession($_REQUEST['Session']);
    else $Session = false; // delete was a succes!
  } else if($new) $Session = new Session();
  else $Session = false;
  if($Session){
    writeHead("<TITLE>Session - Meterkast - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Session->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Session->getId()).'" /></P>';
    else echo '<H1>'.$Session->getId().'</H1>';
    ?>
    <DIV class="Floater ip">
      <DIV class="FloaterHeader">ip</DIV>
      <DIV class="FloaterContent"><?php
          $ip = $Session->get_ip();
          echo '<SPAN CLASS="item UI_ip" ID="0">';
          echo htmlspecialchars($ip);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater file">
      <DIV class="FloaterHeader">file</DIV>
      <DIV class="FloaterContent"><?php
          $file = $Session->get_file();
          if (isset($file)){
            echo '<DIV CLASS="item UI_file" ID="1">';
            echo '</DIV>';
            if(isset($file)){
              if(!$edit) echo '
              <A HREF="Bestand.php?Bestand='.urlencode($file).'">'.htmlspecialchars($file).'</A>';
              else echo htmlspecialchars($file);
            }
          } else echo '<DIV CLASS="new UI_file" ID="1"><I>Nothing</I></DIV>';
        ?> 
      </DIV>
    </DIV>
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Session->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Session=".urlencode($Session->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Session=".urlencode($Session->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Session=".urlencode($Session->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Session is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Session object selected - Meterkast - ADL Prototype</TITLE>");
      ?><i>No Session object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>