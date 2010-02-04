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
  require "Plaats.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    if(@$r['0']!=''){
      $Rechtbank = @$r['0'];
    }else $Rechtbank=null;
    if(@$r['1']!=''){
      $ressort = @$r['1'];
    }else $ressort=null;
    $plaatsZitting=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $plaatsZitting[$i0] = array( 'id' => @$r['2.'.$i0.'.0']
                                 , 'Zitting' => @$r['2.'.$i0.'.0']
                                 , 'griffier' => @$r['2.'.$i0.'.2']
                                 , 'geagendeerd' => @$r['2.'.$i0.'.3']
                                 , 'plaats' => @$r['2.'.$i0.'.4']
                                 , 'locatie' => @$r['2.'.$i0.'.5']
                                 , 'kamer' => @$r['2.'.$i0.'.6']
                                 );
      $plaatsZitting[$i0]['rechter']=array();
      for($i1=0;isset($r['2.'.$i0.'.1.'.$i1]);$i1++){
        $plaatsZitting[$i0]['rechter'][$i1] = @$r['2.'.$i0.'.1.'.$i1.''];
      }
    }
    $hoofdplaats=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $hoofdplaats[$i0] = @$r['3.'.$i0.''];
    }
    $Plaats=new Plaats($ID,$Rechtbank, $ressort, $plaatsZitting, $hoofdplaats);
    if($Plaats->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Plaats='.urlencode($Plaats->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Plaats'])){
    if(!$del || !delPlaats($_REQUEST['Plaats']))
      $Plaats = readPlaats($_REQUEST['Plaats']);
    else $Plaats = false; // delete was a succes!
  } else if($new) $Plaats = new Plaats();
  else $Plaats = false;
  if($Plaats){
    writeHead("<TITLE>Plaats - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Plaats->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Plaats->getId()).'" /></P>';
    else echo '<H1>'.$Plaats->getId().'</H1>';
    ?>
    <DIV class="Floater Rechtbank">
      <DIV class="FloaterHeader">Rechtbank</DIV>
      <DIV class="FloaterContent"><?php
          $Rechtbank = $Plaats->get_Rechtbank();
          echo '<SPAN CLASS="item UI_Rechtbank" ID="0">';
          if(isset($Rechtbank)){
            if(!$edit) echo '
            <A HREF="Gerecht.php?Gerecht='.urlencode($Rechtbank).'">'.htmlspecialchars($Rechtbank).'</A>';
            else echo htmlspecialchars($Rechtbank);
          }
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater ressort">
      <DIV class="FloaterHeader">ressort</DIV>
      <DIV class="FloaterContent"><?php
          $ressort = $Plaats->get_ressort();
          echo '<SPAN CLASS="item UI_ressort" ID="1">';
          if(isset($ressort)){
            echo htmlspecialchars($ressort);
          }
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater plaats Zitting">
      <DIV class="FloaterHeader">plaats Zitting</DIV>
      <DIV class="FloaterContent"><?php
          $plaatsZitting = $Plaats->get_plaatsZitting();
          echo '
          <UL>';
          foreach($plaatsZitting as $i0=>$v0){
            echo '
            <LI CLASS="item UI_plaatsZitting" ID="2.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Zitting.php?Zitting='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'Zitting: ';
                echo '<SPAN CLASS="item UI_plaatsZitting_Zitting" ID="2.'.$i0.'.0">';
                echo htmlspecialchars($v0['Zitting']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rechter: ';
                echo '
                <UL>';
                foreach($v0['rechter'] as $i1=>$rechter){
                  echo '
                  <LI CLASS="item UI_plaatsZitting_rechter" ID="2.'.$i0.'.1.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To2.'.$i0.'.1.'.$i1.'">';
                      echo htmlspecialchars($rechter).'</A>';
                      echo '<DIV class="Goto" id="GoTo2.'.$i0.'.1.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($rechter).'">Gerechtelijkeambtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($rechter).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($rechter).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($rechter);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_plaatsZitting_rechter" ID="2.'.$i0.'.1.'.count($v0['rechter']).'">new rechter</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'griffier: ';
                echo '<SPAN CLASS="item UI_plaatsZitting_griffier" ID="2.'.$i0.'.2">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To2.'.$i0.'.2">';
                  echo htmlspecialchars($v0['griffier']).'</A>';
                  echo '<DIV class="Goto" id="GoTo2.'.$i0.'.2"><UL>';
                  echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0['griffier']).'">Gerechtelijkeambtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['griffier']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['griffier']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['griffier']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'geagendeerd: ';
                echo '<SPAN CLASS="item UI_plaatsZitting_geagendeerd" ID="2.'.$i0.'.3">';
                echo htmlspecialchars($v0['geagendeerd']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'plaats: ';
                echo '<SPAN CLASS="item UI_plaatsZitting_plaats" ID="2.'.$i0.'.4">';
                if(!$edit) echo '
                <A HREF="Plaats.php?Plaats='.urlencode($v0['plaats']).'">'.htmlspecialchars($v0['plaats']).'</A>';
                else echo htmlspecialchars($v0['plaats']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'locatie: ';
                echo '<SPAN CLASS="item UI_plaatsZitting_locatie" ID="2.'.$i0.'.5">';
                if(!$edit) echo '
                <A HREF="Gerecht.php?Gerecht='.urlencode($v0['locatie']).'">'.htmlspecialchars($v0['locatie']).'</A>';
                else echo htmlspecialchars($v0['locatie']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'kamer: ';
                echo '<SPAN CLASS="item UI_plaatsZitting_kamer" ID="2.'.$i0.'.6">';
                if(!$edit) echo '
                <A HREF="Kamer.php?Kamer='.urlencode($v0['kamer']).'">'.htmlspecialchars($v0['kamer']).'</A>';
                else echo htmlspecialchars($v0['kamer']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="2.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_plaatsZitting" ID="2.'.count($plaatsZitting).'">new plaats Zitting</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in plaats Zitting
      function UI_plaatsZitting(id){
        return '<DIV>Zitting: <SPAN CLASS="item UI_plaatsZitting_Zitting" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>rechter: <UL><LI CLASS="new UI_plaatsZitting_rechter" ID="'+id+'.1">new rechter</LI></UL></DIV>'
             + '<DIV>griffier: <SPAN CLASS="item UI_plaatsZitting_griffier" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>geagendeerd: <SPAN CLASS="item UI_plaatsZitting_geagendeerd" ID="'+id+'.3"></SPAN></DIV>'
             + '<DIV>plaats: <SPAN CLASS="item UI_plaatsZitting_plaats" ID="'+id+'.4"></SPAN></DIV>'
             + '<DIV>locatie: <SPAN CLASS="item UI_plaatsZitting_locatie" ID="'+id+'.5"></SPAN></DIV>'
             + '<DIV>kamer: <SPAN CLASS="item UI_plaatsZitting_kamer" ID="'+id+'.6"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater hoofdplaats">
      <DIV class="FloaterHeader">hoofdplaats</DIV>
      <DIV class="FloaterContent"><?php
          $hoofdplaats = $Plaats->get_hoofdplaats();
          echo '
          <UL>';
          foreach($hoofdplaats as $i0=>$v0){
            echo '
            <LI CLASS="item UI_hoofdplaats" ID="3.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Gerecht.php?Gerecht='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_hoofdplaats" ID="3.'.count($hoofdplaats).'">new hoofdplaats</LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Plaats->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Plaats=".urlencode($Plaats->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Plaats=".urlencode($Plaats->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Plaats=".urlencode($Plaats->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Plaats is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Plaats object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Plaats object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>