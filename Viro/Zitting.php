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
  require "Zitting.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $gerecht = @$r['0'];
    $kamer = @$r['1'];
    $plaats = @$r['2'];
    $rechter=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $rechter[$i0] = @$r['3.'.$i0.''];
    }
    $griffier = @$r['4'];
    $geagendeerd = @$r['5'];
    if(@$r['6']!=''){
      $feitelijkedatum = @$r['6'];
    }else $feitelijkedatum=null;
    $zaken=array();
    for($i0=0;isset($r['7.'.$i0]);$i0++){
      $zaken[$i0] = array( 'id' => @$r['7.'.$i0.'.0']
                         , 'zaaknr' => @$r['7.'.$i0.'.0']
                         );
      $zaken[$i0]['eiser']=array();
      for($i1=0;isset($r['7.'.$i0.'.1.'.$i1]);$i1++){
        $zaken[$i0]['eiser'][$i1] = @$r['7.'.$i0.'.1.'.$i1.''];
      }
      $zaken[$i0]['gedaagde']=array();
      for($i1=0;isset($r['7.'.$i0.'.2.'.$i1]);$i1++){
        $zaken[$i0]['gedaagde'][$i1] = @$r['7.'.$i0.'.2.'.$i1.''];
      }
    }
    $Zitting=new Zitting($ID,$gerecht, $kamer, $plaats, $rechter, $griffier, $geagendeerd, $feitelijkedatum, $zaken);
    if($Zitting->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Zitting='.urlencode($Zitting->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Zitting'])){
    if(!$del || !delZitting($_REQUEST['Zitting']))
      $Zitting = readZitting($_REQUEST['Zitting']);
    else $Zitting = false; // delete was a succes!
  } else if($new) $Zitting = new Zitting();
  else $Zitting = false;
  if($Zitting){
    writeHead("<TITLE>Zitting - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Zitting->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Zitting->getId()).'" /></P>';
    else echo '<H1>'.$Zitting->getId().'</H1>';
    ?>
    <DIV class="Floater gerecht">
      <DIV class="FloaterHeader">gerecht</DIV>
      <DIV class="FloaterContent"><?php
          $gerecht = $Zitting->get_gerecht();
          echo '<SPAN CLASS="item UI_gerecht" ID="0">';
          if(!$edit) echo '
          <A HREF="Gerecht.php?Gerecht='.urlencode($gerecht).'">'.htmlspecialchars($gerecht).'</A>';
          else echo htmlspecialchars($gerecht);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater kamer">
      <DIV class="FloaterHeader">kamer</DIV>
      <DIV class="FloaterContent"><?php
          $kamer = $Zitting->get_kamer();
          echo '<SPAN CLASS="item UI_kamer" ID="1">';
          if(!$edit) echo '
          <A HREF="Kamer.php?Kamer='.urlencode($kamer).'">'.htmlspecialchars($kamer).'</A>';
          else echo htmlspecialchars($kamer);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater plaats">
      <DIV class="FloaterHeader">plaats</DIV>
      <DIV class="FloaterContent"><?php
          $plaats = $Zitting->get_plaats();
          echo '<SPAN CLASS="item UI_plaats" ID="2">';
          if(!$edit) echo '
          <A HREF="Plaats.php?Plaats='.urlencode($plaats).'">'.htmlspecialchars($plaats).'</A>';
          else echo htmlspecialchars($plaats);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater rechter">
      <DIV class="FloaterHeader">rechter</DIV>
      <DIV class="FloaterContent"><?php
          $rechter = $Zitting->get_rechter();
          echo '
          <UL>';
          foreach($rechter as $i0=>$v0){
            echo '
            <LI CLASS="item UI_rechter" ID="3.'.$i0.'">';
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
            <LI CLASS="new UI_rechter" ID="3.'.count($rechter).'">new rechter</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater griffier">
      <DIV class="FloaterHeader">griffier</DIV>
      <DIV class="FloaterContent"><?php
          $griffier = $Zitting->get_griffier();
          echo '<SPAN CLASS="item UI_griffier" ID="4">';
          if(!$edit){
            echo '
          <A class="GotoLink" id="To4">';
            echo htmlspecialchars($griffier).'</A>';
            echo '<DIV class="Goto" id="GoTo4"><UL>';
            echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($griffier).'">Gerechtelijkeambtenaar</A></LI>';
            echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($griffier).'">Persoon</A></LI>';
            echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($griffier).'">Belanghebbende</A></LI>';
            echo '</UL></DIV>';
          } else echo htmlspecialchars($griffier);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater geagendeerd">
      <DIV class="FloaterHeader">geagendeerd</DIV>
      <DIV class="FloaterContent"><?php
          $geagendeerd = $Zitting->get_geagendeerd();
          echo '<SPAN CLASS="item UI_geagendeerd" ID="5">';
          echo htmlspecialchars($geagendeerd);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater feitelijkedatum">
      <DIV class="FloaterHeader">feitelijkedatum</DIV>
      <DIV class="FloaterContent"><?php
          $feitelijkedatum = $Zitting->get_feitelijkedatum();
          echo '<SPAN CLASS="item UI_feitelijkedatum" ID="6">';
          if(isset($feitelijkedatum)){
            echo htmlspecialchars($feitelijkedatum);
          }
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater zaken">
      <DIV class="FloaterHeader">zaken</DIV>
      <DIV class="FloaterContent"><?php
          $zaken = $Zitting->get_zaken();
          echo '
          <UL>';
          foreach($zaken as $i0=>$v0){
            echo '
            <LI CLASS="item UI_zaken" ID="7.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To7.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo7.'.$i0.'"><UL>';
                echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($v0['id']).'">BasisgegevensUC001</A></LI>';
                echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($v0['id']).'">Procedure</A></LI>';
                echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($v0['id']).'">nieuweProcedure</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'zaaknr: ';
                echo '<SPAN CLASS="item UI_zaken_zaaknr" ID="7.'.$i0.'.0">';
                echo htmlspecialchars($v0['zaaknr']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'eiser: ';
                echo '
                <UL>';
                foreach($v0['eiser'] as $i1=>$eiser){
                  echo '
                  <LI CLASS="item UI_zaken_eiser" ID="7.'.$i0.'.1.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To7.'.$i0.'.1.'.$i1.'">';
                      echo htmlspecialchars($eiser).'</A>';
                      echo '<DIV class="Goto" id="GoTo7.'.$i0.'.1.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($eiser).'">Gerechtelijkeambtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($eiser).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($eiser).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($eiser);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_zaken_eiser" ID="7.'.$i0.'.1.'.count($v0['eiser']).'">new eiser</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'gedaagde: ';
                echo '
                <UL>';
                foreach($v0['gedaagde'] as $i1=>$gedaagde){
                  echo '
                  <LI CLASS="item UI_zaken_gedaagde" ID="7.'.$i0.'.2.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To7.'.$i0.'.2.'.$i1.'">';
                      echo htmlspecialchars($gedaagde).'</A>';
                      echo '<DIV class="Goto" id="GoTo7.'.$i0.'.2.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($gedaagde).'">Gerechtelijkeambtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($gedaagde).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($gedaagde).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($gedaagde);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_zaken_gedaagde" ID="7.'.$i0.'.2.'.count($v0['gedaagde']).'">new gedaagde</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="7.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_zaken" ID="7.'.count($zaken).'">new zaken</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in zaken
      function UI_zaken(id){
        return '<DIV>zaaknr: <SPAN CLASS="item UI_zaken_zaaknr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>eiser: <UL><LI CLASS="new UI_zaken_eiser" ID="'+id+'.1">new eiser</LI></UL></DIV>'
             + '<DIV>gedaagde: <UL><LI CLASS="new UI_zaken_gedaagde" ID="'+id+'.2">new gedaagde</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Zitting->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Zitting=".urlencode($Zitting->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Zitting=".urlencode($Zitting->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Zitting=".urlencode($Zitting->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Zitting is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Zitting object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Zitting object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>