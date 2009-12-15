<?php // generated with ADL vs. 0.8.10-485
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
  require "Actie.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $file = @$r['0'];
    $operatie = @$r['1'];
    $Actie=new Actie($ID,$file, $operatie);
    if($Actie->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Actie='.urlencode($Actie->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Actie'])){
    if(!$del || !delActie($_REQUEST['Actie']))
      $Actie = readActie($_REQUEST['Actie']);
    else $Actie = false; // delete was a succes!
  } else if($new) $Actie = new Actie();
  else $Actie = false;
  if($Actie){
    writeHead("<TITLE>Actie - Meterkast - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Actie->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Actie->getId()).'" /></P>';
    else echo '<H1>'.$Actie->getId().'</H1>';
    ?>
    <DIV class="Floater file">
      <DIV class="FloaterHeader">file</DIV>
      <DIV class="FloaterContent"><?php
          $file = $Actie->get_file();
          echo '<SPAN CLASS="item UI_file" ID="0">';
          if(!$edit) echo '
          <A HREF="Bestand.php?Bestand='.urlencode($file).'">'.htmlspecialchars($file).'</A>';
          else echo htmlspecialchars($file);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater operatie">
      <DIV class="FloaterHeader">operatie</DIV>
      <DIV class="FloaterContent"><?php
          $operatie = $Actie->get_operatie();
          echo '<SPAN CLASS="item UI_operatie" ID="1">';
          if(!$edit) echo '
          <A HREF="Operatie.php?Operatie='.urlencode($operatie).'">'.htmlspecialchars($operatie).'</A>';
          else echo htmlspecialchars($operatie);
          echo '</SPAN>';
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Actie->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Actie=".urlencode($Actie->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Actie=".urlencode($Actie->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Actie=".urlencode($Actie->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Actie is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Actie object selected - Meterkast - ADL Prototype</TITLE>");
      ?><i>No Actie object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>