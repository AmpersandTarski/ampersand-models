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
  require "Kamer.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $gerecht = @$r['0'];
    $sector = @$r['1'];
    $bezetting=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $bezetting[$i0] = @$r['2.'.$i0.''];
    }
    $zittingen=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $zittingen[$i0] = @$r['3.'.$i0.''];
    }
    $Kamer=new Kamer($ID,$gerecht, $sector, $bezetting, $zittingen);
    if($Kamer->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Kamer='.urlencode($Kamer->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Kamer'])){
    if(!$del || !delKamer($_REQUEST['Kamer']))
      $Kamer = readKamer($_REQUEST['Kamer']);
    else $Kamer = false; // delete was a succes!
  } else if($new) $Kamer = new Kamer();
  else $Kamer = false;
  if($Kamer){
    writeHead("<TITLE>Kamer - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Kamer->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Kamer->getId()).'" /></P>';
    else echo '<H1>'.$Kamer->getId().'</H1>';
    ?>
    <DIV class="Floater gerecht">
      <DIV class="FloaterHeader">gerecht</DIV>
      <DIV class="FloaterContent"><?php
          $gerecht = $Kamer->get_gerecht();
          echo '<SPAN CLASS="item UI_gerecht" ID="0">';
          if(!$edit) echo '
          <A HREF="Gerecht.php?Gerecht='.urlencode($gerecht).'">'.htmlspecialchars($gerecht).'</A>';
          else echo htmlspecialchars($gerecht);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater sector">
      <DIV class="FloaterHeader">sector</DIV>
      <DIV class="FloaterContent"><?php
          $sector = $Kamer->get_sector();
          echo '<SPAN CLASS="item UI_sector" ID="1">';
          if(!$edit) echo '
          <A HREF="Sector.php?Sector='.urlencode($sector).'">'.htmlspecialchars($sector).'</A>';
          else echo htmlspecialchars($sector);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater bezetting">
      <DIV class="FloaterHeader">bezetting</DIV>
      <DIV class="FloaterContent"><?php
          $bezetting = $Kamer->get_bezetting();
          echo '
          <UL>';
          foreach($bezetting as $i0=>$v0){
            echo '
            <LI CLASS="item UI_bezetting" ID="2.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To2.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo2.'.$i0.'"><UL>';
                echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0).'">RechterlijkeAmbtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_bezetting" ID="2.'.count($bezetting).'">new bezetting</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater zittingen">
      <DIV class="FloaterHeader">zittingen</DIV>
      <DIV class="FloaterContent"><?php
          $zittingen = $Kamer->get_zittingen();
          echo '
          <UL>';
          foreach($zittingen as $i0=>$v0){
            echo '
            <LI CLASS="item UI_zittingen" ID="3.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Zitting.php?Zitting='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_zittingen" ID="3.'.count($zittingen).'">new zittingen</LI>';
          echo '
          </UL>';
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Kamer->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Kamer=".urlencode($Kamer->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Kamer=".urlencode($Kamer->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Kamer=".urlencode($Kamer->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Kamer is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Kamer object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Kamer object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>