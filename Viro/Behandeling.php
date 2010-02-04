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
  require "Behandeling.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $zitting = array( 'id' => @$r['0']
                    , 'gerecht' => @$r['0.0']
                    , 'griffier' => @$r['0.2']
                    , 'geagendeerd' => @$r['0.3']
                    , 'feitelijkedatum' => @$r['0.4']
                    );
    $zitting['rechter']=array();
    for($i0=0;isset($r['0.1.'.$i0]);$i0++){
      $zitting['rechter'][$i0] = @$r['0.1.'.$i0.''];
    }
    $zaak = array( 'id' => @$r['1']
                 , 'rechtsgebied' => @$r['1.0']
                 , 'proceduresoort' => @$r['1.1']
                 );
    $zaak['zitting']=array();
    for($i0=0;isset($r['1.2.'.$i0]);$i0++){
      $zaak['zitting'][$i0] = @$r['1.2.'.$i0.''];
    }
    $Behandeling=new Behandeling($ID,$zitting, $zaak);
    if($Behandeling->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Behandeling='.urlencode($Behandeling->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Behandeling'])){
    if(!$del || !delBehandeling($_REQUEST['Behandeling']))
      $Behandeling = readBehandeling($_REQUEST['Behandeling']);
    else $Behandeling = false; // delete was a succes!
  } else if($new) $Behandeling = new Behandeling();
  else $Behandeling = false;
  if($Behandeling){
    writeHead("<TITLE>Behandeling - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Behandeling->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Behandeling->getId()).'" /></P>';
    else echo '<H1>'.$Behandeling->getId().'</H1>';
    ?>
    <DIV class="Floater zitting">
      <DIV class="FloaterHeader">zitting</DIV>
      <DIV class="FloaterContent"><?php
          $zitting = $Behandeling->get_zitting();
          echo '<DIV CLASS="UI_zitting" ID="0">';
            if(!$edit){
              echo '
            <A HREF="Zitting.php?Zitting='.urlencode($zitting['id']).'">';
              echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
            }
            echo '
            <DIV>';
              echo 'gerecht: ';
              echo '<SPAN CLASS="item UI_zitting_gerecht" ID="0.0">';
              if(!$edit) echo '
              <A HREF="Gerecht.php?Gerecht='.urlencode($zitting['gerecht']).'">'.htmlspecialchars($zitting['gerecht']).'</A>';
              else echo htmlspecialchars($zitting['gerecht']);
              echo '</SPAN>';
            echo '</DIV>
            <DIV>';
              echo 'rechter: ';
              echo '
              <UL>';
              foreach($zitting['rechter'] as $i0=>$rechter){
                echo '
                <LI CLASS="item UI_zitting_rechter" ID="0.1.'.$i0.'">';
                  if(!$edit){
                    echo '
                  <A class="GotoLink" id="To0.1.'.$i0.'">';
                    echo htmlspecialchars($rechter).'</A>';
                    echo '<DIV class="Goto" id="GoTo0.1.'.$i0.'"><UL>';
                    echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($rechter).'">RechterlijkeAmbtenaar</A></LI>';
                    echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($rechter).'">Persoon</A></LI>';
                    echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($rechter).'">Belanghebbende</A></LI>';
                    echo '</UL></DIV>';
                  } else echo htmlspecialchars($rechter);
                echo '</LI>';
              }
              if($edit) echo '
                <LI CLASS="new UI_zitting_rechter" ID="0.1.'.count($zitting['rechter']).'">new rechter</LI>';
              echo '
              </UL>';
            echo '</DIV>
            <DIV>';
              echo 'griffier: ';
              echo '<SPAN CLASS="item UI_zitting_griffier" ID="0.2">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To0.2">';
                echo htmlspecialchars($zitting['griffier']).'</A>';
                echo '<DIV class="Goto" id="GoTo0.2"><UL>';
                echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($zitting['griffier']).'">RechterlijkeAmbtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($zitting['griffier']).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($zitting['griffier']).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($zitting['griffier']);
              echo '</SPAN>';
            echo '</DIV>
            <DIV>';
              echo 'geagendeerd: ';
              echo '<SPAN CLASS="item UI_zitting_geagendeerd" ID="0.3">';
              echo htmlspecialchars($zitting['geagendeerd']);
              echo '</SPAN>';
            echo '</DIV>
            <DIV>';
              echo 'feitelijkedatum: ';
              if (isset($zitting['feitelijkedatum'])){
                echo '<DIV CLASS="item UI_zitting_feitelijkedatum" ID="0.4">';
                echo '</DIV>';
                if(isset($zitting['feitelijkedatum'])){
                  echo htmlspecialchars($zitting['feitelijkedatum']);
                }
              } else echo '<DIV CLASS="new UI_zitting_feitelijkedatum" ID="0.4"><I>Nothing</I></DIV>';
            echo '
            </DIV>';
            if($edit) echo '
            <INPUT TYPE="hidden" name="0.ID" VALUE="'.$zitting['id'].'" />';
          echo '</DIV>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater zaak">
      <DIV class="FloaterHeader">zaak</DIV>
      <DIV class="FloaterContent"><?php
          $zaak = $Behandeling->get_zaak();
          echo '<DIV CLASS="UI_zaak" ID="1">';
            if(!$edit){
              echo '
            <DIV class="GotoArrow" id="To1">&rArr;</DIV>';
              echo '<DIV class="Goto" id="GoTo1"><UL>';
              echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($zaak['id']).'">BasisgegevensUC001</A></LI>';
              echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($zaak['id']).'">Procedure</A></LI>';
              echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($zaak['id']).'">nieuweProcedure</A></LI>';
              echo '</UL></DIV>';
            }
            echo '
            <DIV>';
              echo 'rechtsgebied: ';
              echo '<SPAN CLASS="item UI_zaak_rechtsgebied" ID="1.0">';
              if(!$edit) echo '
              <A HREF="Rechtsgebied.php?Rechtsgebied='.urlencode($zaak['rechtsgebied']).'">'.htmlspecialchars($zaak['rechtsgebied']).'</A>';
              else echo htmlspecialchars($zaak['rechtsgebied']);
              echo '</SPAN>';
            echo '</DIV>
            <DIV>';
              echo 'proceduresoort: ';
              echo '<SPAN CLASS="item UI_zaak_proceduresoort" ID="1.1">';
              if(!$edit) echo '
              <A HREF="Proceduresoort.php?Proceduresoort='.urlencode($zaak['proceduresoort']).'">'.htmlspecialchars($zaak['proceduresoort']).'</A>';
              else echo htmlspecialchars($zaak['proceduresoort']);
              echo '</SPAN>';
            echo '</DIV>
            <DIV>';
              echo 'zitting: ';
              echo '
              <UL>';
              foreach($zaak['zitting'] as $i0=>$zitting){
                echo '
                <LI CLASS="item UI_zaak_zitting" ID="1.2.'.$i0.'">';
                  if(!$edit) echo '
                  <A HREF="Zitting.php?Zitting='.urlencode($zitting).'">'.htmlspecialchars($zitting).'</A>';
                  else echo htmlspecialchars($zitting);
                echo '</LI>';
              }
              if($edit) echo '
                <LI CLASS="new UI_zaak_zitting" ID="1.2.'.count($zaak['zitting']).'">new zitting</LI>';
              echo '
              </UL>';
            echo '
            </DIV>';
            if($edit) echo '
            <INPUT TYPE="hidden" name="1.ID" VALUE="'.$zaak['id'].'" />';
          echo '</DIV>';
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Behandeling->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Behandeling=".urlencode($Behandeling->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Behandeling=".urlencode($Behandeling->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Behandeling=".urlencode($Behandeling->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Behandeling is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Behandeling object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Behandeling object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>