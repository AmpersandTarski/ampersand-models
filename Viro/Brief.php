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
  require "Brief.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $zaaksdossier=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $zaaksdossier[$i0] = @$r['0.'.$i0.''];
    }
    $type = @$r['1'];
    $van = @$r['2'];
    $aan=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $aan[$i0] = @$r['3.'.$i0.''];
    }
    $kenmerk = @$r['4'];
    $verzonden = @$r['5'];
    if(@$r['6']!=''){
      $ontvangen = @$r['6'];
    }else $ontvangen=null;
    $Brief=new Brief($ID,$zaaksdossier, $type, $van, $aan, $kenmerk, $verzonden, $ontvangen);
    if($Brief->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Brief='.urlencode($Brief->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Brief'])){
    if(!$del || !delBrief($_REQUEST['Brief']))
      $Brief = readBrief($_REQUEST['Brief']);
    else $Brief = false; // delete was a succes!
  } else if($new) $Brief = new Brief();
  else $Brief = false;
  if($Brief){
    writeHead("<TITLE>Brief - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Brief->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Brief->getId()).'" /></P>';
    else echo '<H1>'.$Brief->getId().'</H1>';
    ?>
    <DIV class="Floater zaaksdossier">
      <DIV class="FloaterHeader">zaaksdossier</DIV>
      <DIV class="FloaterContent"><?php
          $zaaksdossier = $Brief->get_zaaksdossier();
          echo '
          <UL>';
          foreach($zaaksdossier as $i0=>$v0){
            echo '
            <LI CLASS="item UI_zaaksdossier" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To0.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($v0).'">BasisgegevensUC001</A></LI>';
                echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($v0).'">Procedure</A></LI>';
                echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($v0).'">nieuweProcedure</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_zaaksdossier" ID="0.'.count($zaaksdossier).'">new zaaksdossier</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater type">
      <DIV class="FloaterHeader">type</DIV>
      <DIV class="FloaterContent"><?php
          $type = $Brief->get_type();
          echo '<SPAN CLASS="item UI_type" ID="1">';
          if(!$edit) echo '
          <A HREF="Documenttype.php?Documenttype='.urlencode($type).'">'.htmlspecialchars($type).'</A>';
          else echo htmlspecialchars($type);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater van">
      <DIV class="FloaterHeader">van</DIV>
      <DIV class="FloaterContent"><?php
          $van = $Brief->get_van();
          echo '<SPAN CLASS="item UI_van" ID="2">';
          if(!$edit){
            echo '
          <A class="GotoLink" id="To2">';
            echo htmlspecialchars($van).'</A>';
            echo '<DIV class="Goto" id="GoTo2"><UL>';
            echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($van).'">RechterlijkeAmbtenaar</A></LI>';
            echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($van).'">Persoon</A></LI>';
            echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($van).'">Belanghebbende</A></LI>';
            echo '</UL></DIV>';
          } else echo htmlspecialchars($van);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater aan">
      <DIV class="FloaterHeader">aan</DIV>
      <DIV class="FloaterContent"><?php
          $aan = $Brief->get_aan();
          echo '
          <UL>';
          foreach($aan as $i0=>$v0){
            echo '
            <LI CLASS="item UI_aan" ID="3.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To3.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo3.'.$i0.'"><UL>';
                echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0).'">RechterlijkeAmbtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_aan" ID="3.'.count($aan).'">new aan</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater kenmerk">
      <DIV class="FloaterHeader">kenmerk</DIV>
      <DIV class="FloaterContent"><?php
          $kenmerk = $Brief->get_kenmerk();
          echo '<SPAN CLASS="item UI_kenmerk" ID="4">';
          echo htmlspecialchars($kenmerk);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater verzonden">
      <DIV class="FloaterHeader">verzonden</DIV>
      <DIV class="FloaterContent"><?php
          $verzonden = $Brief->get_verzonden();
          echo '<SPAN CLASS="item UI_verzonden" ID="5">';
          echo htmlspecialchars($verzonden);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater ontvangen">
      <DIV class="FloaterHeader">ontvangen</DIV>
      <DIV class="FloaterContent"><?php
          $ontvangen = $Brief->get_ontvangen();
          if (isset($ontvangen)){
            echo '<DIV CLASS="item UI_ontvangen" ID="6">';
            echo '</DIV>';
            if(isset($ontvangen)){
              echo htmlspecialchars($ontvangen);
            }
          } else echo '<DIV CLASS="new UI_ontvangen" ID="6"><I>Nothing</I></DIV>';
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Brief->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Brief=".urlencode($Brief->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Brief=".urlencode($Brief->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Brief=".urlencode($Brief->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Brief is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Brief object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Brief object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>