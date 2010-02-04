<?php // generated with ADL vs. 0.8.10-452
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
  require "Sessie.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $persoon = @$r['0'];
    $DigID = @$r['1'];
    $startTijdstip = @$r['2'];
    $rol = @$r['3'];
    $Sessie=new Sessie($ID,$persoon, $DigID, $startTijdstip, $rol);
    if($Sessie->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Sessie='.urlencode($Sessie->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Sessie'])){
    if(!$del || !delSessie($_REQUEST['Sessie']))
      $Sessie = readSessie($_REQUEST['Sessie']);
    else $Sessie = false; // delete was a succes!
  } else if($new) $Sessie = new Sessie();
  else $Sessie = false;
  if($Sessie){
    writeHead("<TITLE>Sessie - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Sessie->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Sessie->getId()).'" /></P>';
    else echo '<H1>'.$Sessie->getId().'</H1>';
    ?>
    <DIV class="Floater persoon">
      <DIV class="FloaterHeader">persoon</DIV>
      <DIV class="FloaterContent"><?php
          $persoon = $Sessie->get_persoon();
          echo '<SPAN CLASS="item UI_persoon" ID="0">';
          if(!$edit){
            echo '
          <A class="GotoLink" id="To0">';
            echo htmlspecialchars($persoon).'</A>';
            echo '<DIV class="Goto" id="GoTo0"><UL>';
            echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($persoon).'">RechterlijkeAmbtenaar</A></LI>';
            echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($persoon).'">Persoon</A></LI>';
            echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($persoon).'">Belanghebbende</A></LI>';
            echo '</UL></DIV>';
          } else echo htmlspecialchars($persoon);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater DigID">
      <DIV class="FloaterHeader">DigID</DIV>
      <DIV class="FloaterContent"><?php
          $DigID = $Sessie->get_DigID();
          echo '<SPAN CLASS="item UI_DigID" ID="1">';
          echo htmlspecialchars($DigID);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater startTijdstip">
      <DIV class="FloaterHeader">startTijdstip</DIV>
      <DIV class="FloaterContent"><?php
          $startTijdstip = $Sessie->get_startTijdstip();
          echo '<SPAN CLASS="item UI_startTijdstip" ID="2">';
          echo htmlspecialchars($startTijdstip);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater rol">
      <DIV class="FloaterHeader">rol</DIV>
      <DIV class="FloaterContent"><?php
          $rol = $Sessie->get_rol();
          echo '<SPAN CLASS="item UI_rol" ID="3">';
          echo htmlspecialchars($rol);
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Sessie->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Sessie=".urlencode($Sessie->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Sessie=".urlencode($Sessie->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Sessie=".urlencode($Sessie->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Sessie is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Sessie object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Sessie object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>