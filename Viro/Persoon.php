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
  require "Persoon.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $procedures=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $procedures[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                              , 'nr' => @$r['0.'.$i0.'.0']
                              , 'zorgdragerOrgaan' => @$r['0.'.$i0.'.1']
                              , 'rechtsgebiedRechtsgebied' => @$r['0.'.$i0.'.2']
                              , 'proceduresoortProceduresoort' => @$r['0.'.$i0.'.3']
                              );
    }
    $rol=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $rol[$i0] = @$r['1.'.$i0.''];
    }
    $gemachtigdevan=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $gemachtigdevan[$i0] = array( 'id' => @$r['2.'.$i0.'']
                                  );
      $gemachtigdevan[$i0]['gemachtigde']=array();
      for($i1=0;isset($r['2.'.$i0.'.0.'.$i1]);$i1++){
        $gemachtigdevan[$i0]['gemachtigde'][$i1] = @$r['2.'.$i0.'.0.'.$i1.''];
      }
    }
    $DigID=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $DigID[$i0] = @$r['3.'.$i0.''];
    }
    $Dossier=array();
    for($i0=0;isset($r['4.'.$i0]);$i0++){
      $Dossier[$i0] = array( 'id' => @$r['4.'.$i0.'']
                           , 'van' => @$r['4.'.$i0.'.0']
                           , 'verzondenTijdstip' => @$r['4.'.$i0.'.2']
                           );
      $Dossier[$i0]['aan']=array();
      for($i1=0;isset($r['4.'.$i0.'.1.'.$i1]);$i1++){
        $Dossier[$i0]['aan'][$i1] = @$r['4.'.$i0.'.1.'.$i1.''];
      }
    }
    $Persoon=new Persoon($ID,$procedures, $rol, $gemachtigdevan, $DigID, $Dossier);
    if($Persoon->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Persoon='.urlencode($Persoon->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Persoon'])){
    if(!$del || !delPersoon($_REQUEST['Persoon']))
      $Persoon = readPersoon($_REQUEST['Persoon']);
    else $Persoon = false; // delete was a succes!
  } else if($new) $Persoon = new Persoon();
  else $Persoon = false;
  if($Persoon){
    writeHead("<TITLE>Persoon - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Persoon->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Persoon->getId()).'" /></P>';
    else echo '<H1>'.$Persoon->getId().'</H1>';
    ?>
    <DIV class="Floater procedure(s)">
      <DIV class="FloaterHeader">procedure(s)</DIV>
      <DIV class="FloaterContent"><?php
          $procedures = $Persoon->get_procedures();
          echo '
          <UL>';
          foreach($procedures as $i0=>$v0){
            echo '
            <LI CLASS="item UI_procedures" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To0.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($v0['id']).'">BasisgegevensUC001</A></LI>';
                echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($v0['id']).'">Procedure</A></LI>';
                echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($v0['id']).'">nieuweProcedure</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'nr: ';
                echo '<SPAN CLASS="item UI_procedures_nr" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['nr']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'zorgdragerOrgaan: ';
                echo '<SPAN CLASS="item UI_procedures_zorgdragerOrgaan" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Orgaan.php?Orgaan='.urlencode($v0['zorgdragerOrgaan']).'">'.htmlspecialchars($v0['zorgdragerOrgaan']).'</A>';
                else echo htmlspecialchars($v0['zorgdragerOrgaan']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rechtsgebiedRechtsgebied: ';
                echo '<SPAN CLASS="item UI_procedures_rechtsgebiedRechtsgebied" ID="0.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="Rechtsgebied.php?Rechtsgebied='.urlencode($v0['rechtsgebiedRechtsgebied']).'">'.htmlspecialchars($v0['rechtsgebiedRechtsgebied']).'</A>';
                else echo htmlspecialchars($v0['rechtsgebiedRechtsgebied']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'proceduresoortProceduresoort: ';
                echo '<SPAN CLASS="item UI_procedures_proceduresoortProceduresoort" ID="0.'.$i0.'.3">';
                if(!$edit) echo '
                <A HREF="Proceduresoort.php?Proceduresoort='.urlencode($v0['proceduresoortProceduresoort']).'">'.htmlspecialchars($v0['proceduresoortProceduresoort']).'</A>';
                else echo htmlspecialchars($v0['proceduresoortProceduresoort']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_procedures" ID="0.'.count($procedures).'">new procedure(s)</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in procedure(s)
      function UI_procedures(id){
        return '<DIV>nr: <SPAN CLASS="item UI_procedures_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>zorgdragerOrgaan: <SPAN CLASS="item UI_procedures_zorgdragerOrgaan" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>rechtsgebiedRechtsgebied: <SPAN CLASS="item UI_procedures_rechtsgebiedRechtsgebied" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>proceduresoortProceduresoort: <SPAN CLASS="item UI_procedures_proceduresoortProceduresoort" ID="'+id+'.3"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater rol">
      <DIV class="FloaterHeader">rol</DIV>
      <DIV class="FloaterContent"><?php
          $rol = $Persoon->get_rol();
          echo '
          <UL>';
          foreach($rol as $i0=>$v0){
            echo '
            <LI CLASS="item UI_rol" ID="1.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Rol.php?Rol='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_rol" ID="1.'.count($rol).'">new rol</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater gemachtigde van">
      <DIV class="FloaterHeader">gemachtigde van</DIV>
      <DIV class="FloaterContent"><?php
          $gemachtigdevan = $Persoon->get_gemachtigdevan();
          echo '
          <UL>';
          foreach($gemachtigdevan as $i0=>$v0){
            echo '
            <LI CLASS="item UI_gemachtigdevan" ID="2.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Machtiging.php?Machtiging='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'gemachtigde: ';
                echo '
                <UL>';
                foreach($v0['gemachtigde'] as $i1=>$gemachtigde){
                  echo '
                  <LI CLASS="item UI_gemachtigdevan" ID="2.'.$i0.'.0.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To2.'.$i0.'.0.'.$i1.'">';
                      echo htmlspecialchars($gemachtigde).'</A>';
                      echo '<DIV class="Goto" id="GoTo2.'.$i0.'.0.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($gemachtigde).'">Gerechtelijkeambtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($gemachtigde).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($gemachtigde).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($gemachtigde);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_gemachtigdevan" ID="2.'.$i0.'.0.'.count($v0['gemachtigde']).'">new gemachtigde</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="2.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_gemachtigdevan" ID="2.'.count($gemachtigdevan).'">new gemachtigde van</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in gemachtigde van
      function UI_gemachtigdevan(id){
        return '<DIV>gemachtigde: <UL><LI CLASS="new UI_gemachtigdevan_gemachtigde" ID="'+id+'.0">new gemachtigde</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater DigID">
      <DIV class="FloaterHeader">DigID</DIV>
      <DIV class="FloaterContent"><?php
          $DigID = $Persoon->get_DigID();
          echo '
          <UL>';
          foreach($DigID as $i0=>$v0){
            echo '
            <LI CLASS="item UI_DigID" ID="3.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_DigID" ID="3.'.count($DigID).'">new DigID</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater Dossier">
      <DIV class="FloaterHeader">Dossier</DIV>
      <DIV class="FloaterContent"><?php
          $Dossier = $Persoon->get_Dossier();
          echo '
          <UL>';
          foreach($Dossier as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Dossier" ID="4.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To4.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo4.'.$i0.'"><UL>';
                echo '<LI><A HREF="Brief.php?Brief='.urlencode($v0['id']).'">Brief</A></LI>';
                echo '<LI><A HREF="Betaling.php?Betaling='.urlencode($v0['id']).'">Betaling</A></LI>';
                echo '<LI><A HREF="Document.php?Document='.urlencode($v0['id']).'">Document</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'van: ';
                echo '<SPAN CLASS="item UI_Dossier_van" ID="4.'.$i0.'.0">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To4.'.$i0.'.0">';
                  echo htmlspecialchars($v0['van']).'</A>';
                  echo '<DIV class="Goto" id="GoTo4.'.$i0.'.0"><UL>';
                  echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0['van']).'">Gerechtelijkeambtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['van']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['van']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['van']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'aan: ';
                echo '
                <UL>';
                foreach($v0['aan'] as $i1=>$aan){
                  echo '
                  <LI CLASS="item UI_Dossier_aan" ID="4.'.$i0.'.1.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To4.'.$i0.'.1.'.$i1.'">';
                      echo htmlspecialchars($aan).'</A>';
                      echo '<DIV class="Goto" id="GoTo4.'.$i0.'.1.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($aan).'">Gerechtelijkeambtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($aan).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($aan).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($aan);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Dossier_aan" ID="4.'.$i0.'.1.'.count($v0['aan']).'">new aan</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'verzondenTijdstip: ';
                echo '<SPAN CLASS="item UI_Dossier_verzondenTijdstip" ID="4.'.$i0.'.2">';
                echo htmlspecialchars($v0['verzondenTijdstip']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="4.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Dossier" ID="4.'.count($Dossier).'">new Dossier</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Dossier
      function UI_Dossier(id){
        return '<DIV>van: <SPAN CLASS="item UI_Dossier_van" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>aan: <UL><LI CLASS="new UI_Dossier_aan" ID="'+id+'.1">new aan</LI></UL></DIV>'
             + '<DIV>verzondenTijdstip: <SPAN CLASS="item UI_Dossier_verzondenTijdstip" ID="'+id+'.2"></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Persoon->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Persoon=".urlencode($Persoon->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Persoon=".urlencode($Persoon->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Persoon=".urlencode($Persoon->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Persoon is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Persoon object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Persoon object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>