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
  require "Betaling.inc.php";
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
    $betreft = @$r['4'];
    $bedrag=array();
    for($i0=0;isset($r['5.'.$i0]);$i0++){
      $bedrag[$i0] = @$r['5.'.$i0.''];
    }
    $verzonden = @$r['6'];
    if(@$r['7']!=''){
      $ontvangen = @$r['7'];
    }else $ontvangen=null;
    $Betaling=new Betaling($ID,$zaaksdossier, $type, $van, $aan, $betreft, $bedrag, $verzonden, $ontvangen);
    if($Betaling->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Betaling='.urlencode($Betaling->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Betaling'])){
    if(!$del || !delBetaling($_REQUEST['Betaling']))
      $Betaling = readBetaling($_REQUEST['Betaling']);
    else $Betaling = false; // delete was a succes!
  } else if($new) $Betaling = new Betaling();
  else $Betaling = false;
  if($Betaling){
    writeHead("<TITLE>Betaling - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Betaling->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Betaling->getId()).'" /></P>';
    else echo '<H1>'.$Betaling->getId().'</H1>';
    ?>
    <DIV class="Floater zaaksdossier">
      <DIV class="FloaterHeader">zaaksdossier</DIV>
      <DIV class="FloaterContent"><?php
          $zaaksdossier = $Betaling->get_zaaksdossier();
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
          $type = $Betaling->get_type();
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
          $van = $Betaling->get_van();
          echo '<SPAN CLASS="item UI_van" ID="2">';
          if(!$edit){
            echo '
          <A class="GotoLink" id="To2">';
            echo htmlspecialchars($van).'</A>';
            echo '<DIV class="Goto" id="GoTo2"><UL>';
            echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($van).'">Gerechtelijkeambtenaar</A></LI>';
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
          $aan = $Betaling->get_aan();
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
                echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0).'">Gerechtelijkeambtenaar</A></LI>';
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
    <DIV class="Floater betreft">
      <DIV class="FloaterHeader">betreft</DIV>
      <DIV class="FloaterContent"><?php
          $betreft = $Betaling->get_betreft();
          echo '<SPAN CLASS="item UI_betreft" ID="4">';
          echo htmlspecialchars($betreft);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater bedrag">
      <DIV class="FloaterHeader">bedrag</DIV>
      <DIV class="FloaterContent"><?php
          $bedrag = $Betaling->get_bedrag();
          echo '
          <UL>';
          foreach($bedrag as $i0=>$v0){
            echo '
            <LI CLASS="item UI_bedrag" ID="5.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_bedrag" ID="5.'.count($bedrag).'">new bedrag</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater verzonden">
      <DIV class="FloaterHeader">verzonden</DIV>
      <DIV class="FloaterContent"><?php
          $verzonden = $Betaling->get_verzonden();
          echo '<SPAN CLASS="item UI_verzonden" ID="6">';
          echo htmlspecialchars($verzonden);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater ontvangen">
      <DIV class="FloaterHeader">ontvangen</DIV>
      <DIV class="FloaterContent"><?php
          $ontvangen = $Betaling->get_ontvangen();
          echo '<SPAN CLASS="item UI_ontvangen" ID="7">';
          if(isset($ontvangen)){
            echo htmlspecialchars($ontvangen);
          }
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Betaling->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Betaling=".urlencode($Betaling->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Betaling=".urlencode($Betaling->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Betaling=".urlencode($Betaling->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Betaling is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Betaling object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Betaling object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>