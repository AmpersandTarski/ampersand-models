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
  require "Artikel.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $tekst=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $tekst[$i0] = @$r['0.'.$i0.''];
    }
    $handeling=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $handeling[$i0] = @$r['1.'.$i0.''];
    }
    $orgaan=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $orgaan[$i0] = @$r['2.'.$i0.''];
    }
    $werkwoord=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $werkwoord[$i0] = @$r['3.'.$i0.''];
    }
    $objecttype=array();
    for($i0=0;isset($r['4.'.$i0]);$i0++){
      $objecttype[$i0] = @$r['4.'.$i0.''];
    }
    $Artikel=new Artikel($ID,$tekst, $handeling, $orgaan, $werkwoord, $objecttype);
    if($Artikel->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Artikel='.urlencode($Artikel->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Artikel'])){
    if(!$del || !delArtikel($_REQUEST['Artikel']))
      $Artikel = readArtikel($_REQUEST['Artikel']);
    else $Artikel = false; // delete was a succes!
  } else if($new) $Artikel = new Artikel();
  else $Artikel = false;
  if($Artikel){
    writeHead("<TITLE>Artikel - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Artikel->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Artikel->getId()).'" /></P>';
    else echo '<H1>'.$Artikel->getId().'</H1>';
    ?>
    <DIV class="Floater tekst">
      <DIV class="FloaterHeader">tekst</DIV>
      <DIV class="FloaterContent"><?php
          $tekst = $Artikel->get_tekst();
          echo '
          <UL>';
          foreach($tekst as $i0=>$v0){
            echo '
            <LI CLASS="item UI_tekst" ID="0.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_tekst" ID="0.'.count($tekst).'">new tekst</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater handeling">
      <DIV class="FloaterHeader">handeling</DIV>
      <DIV class="FloaterContent"><?php
          $handeling = $Artikel->get_handeling();
          echo '
          <UL>';
          foreach($handeling as $i0=>$v0){
            echo '
            <LI CLASS="item UI_handeling" ID="1.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_handeling" ID="1.'.count($handeling).'">new handeling</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater orgaan">
      <DIV class="FloaterHeader">orgaan</DIV>
      <DIV class="FloaterContent"><?php
          $orgaan = $Artikel->get_orgaan();
          echo '
          <UL>';
          foreach($orgaan as $i0=>$v0){
            echo '
            <LI CLASS="item UI_orgaan" ID="2.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Orgaan.php?Orgaan='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_orgaan" ID="2.'.count($orgaan).'">new orgaan</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater werkwoord">
      <DIV class="FloaterHeader">werkwoord</DIV>
      <DIV class="FloaterContent"><?php
          $werkwoord = $Artikel->get_werkwoord();
          echo '
          <UL>';
          foreach($werkwoord as $i0=>$v0){
            echo '
            <LI CLASS="item UI_werkwoord" ID="3.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_werkwoord" ID="3.'.count($werkwoord).'">new werkwoord</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater objecttype">
      <DIV class="FloaterHeader">objecttype</DIV>
      <DIV class="FloaterContent"><?php
          $objecttype = $Artikel->get_objecttype();
          echo '
          <UL>';
          foreach($objecttype as $i0=>$v0){
            echo '
            <LI CLASS="item UI_objecttype" ID="4.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_objecttype" ID="4.'.count($objecttype).'">new objecttype</LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Artikel->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Artikel=".urlencode($Artikel->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Artikel=".urlencode($Artikel->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Artikel=".urlencode($Artikel->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Artikel is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Artikel object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Artikel object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>