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
  require "Procedure.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $eiser=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $eiser[$i0] = @$r['0.'.$i0.''];
    }
    $gemachtigdevooreiser=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $gemachtigdevooreiser[$i0] = @$r['1.'.$i0.''];
    }
    $gedaagde=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $gedaagde[$i0] = @$r['2.'.$i0.''];
    }
    $gemachtigdevoorgedaagde=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $gemachtigdevoorgedaagde[$i0] = @$r['3.'.$i0.''];
    }
    $gevoegd=array();
    for($i0=0;isset($r['4.'.$i0]);$i0++){
      $gevoegd[$i0] = @$r['4.'.$i0.''];
    }
    $gemachtigdevoorgevoegde=array();
    for($i0=0;isset($r['5.'.$i0]);$i0++){
      $gemachtigdevoorgevoegde[$i0] = @$r['5.'.$i0.''];
    }
    $rechtsgebied = @$r['6'];
    $proceduresoort = @$r['7'];
    $zitting=array();
    for($i0=0;isset($r['8.'.$i0]);$i0++){
      $zitting[$i0] = array( 'id' => @$r['8.'.$i0.'']
                           , 'kamer' => @$r['8.'.$i0.'.0']
                           , 'geagendeerd' => @$r['8.'.$i0.'.1']
                           , 'griffier' => @$r['8.'.$i0.'.3']
                           );
      $zitting[$i0]['rechter']=array();
      for($i1=0;isset($r['8.'.$i0.'.2.'.$i1]);$i1++){
        $zitting[$i0]['rechter'][$i1] = @$r['8.'.$i0.'.2.'.$i1.''];
      }
    }
    $behandeling=array();
    for($i0=0;isset($r['9.'.$i0]);$i0++){
      $behandeling[$i0] = array( 'id' => @$r['9.'.$i0.'.0']
                               , 'rolnummer' => @$r['9.'.$i0.'.0']
                               , 'zittingsnummer' => @$r['9.'.$i0.'.1']
                               , 'zaaknummer' => @$r['9.'.$i0.'.2']
                               );
    }
    $bevoegd=array();
    for($i0=0;isset($r['10.'.$i0]);$i0++){
      $bevoegd[$i0] = @$r['10.'.$i0.''];
    }
    $zorgdragervoordossier = @$r['11'];
    $zaaksdossier=array();
    for($i0=0;isset($r['12.'.$i0]);$i0++){
      $zaaksdossier[$i0] = array( 'id' => @$r['12.'.$i0.'.0']
                                , 'Document' => @$r['12.'.$i0.'.0']
                                , 'type' => @$r['12.'.$i0.'.1']
                                );
    }
    $cluster=array();
    for($i0=0;isset($r['13.'.$i0]);$i0++){
      $cluster[$i0] = array( 'id' => @$r['13.'.$i0.'.0']
                           , 'nr' => @$r['13.'.$i0.'.0']
                           , 'naam' => @$r['13.'.$i0.'.1']
                           );
      $cluster[$i0]['grond']=array();
      for($i1=0;isset($r['13.'.$i0.'.2.'.$i1]);$i1++){
        $cluster[$i0]['grond'][$i1] = @$r['13.'.$i0.'.2.'.$i1.''];
      }
    }
    $machtigingen=array();
    for($i0=0;isset($r['14.'.$i0]);$i0++){
      $machtigingen[$i0] = array( 'id' => @$r['14.'.$i0.'.0']
                                , 'machtiging' => @$r['14.'.$i0.'.0']
                                , 'partij' => @$r['14.'.$i0.'.1']
                                );
      $machtigingen[$i0]['gemachtigde']=array();
      for($i1=0;isset($r['14.'.$i0.'.2.'.$i1]);$i1++){
        $machtigingen[$i0]['gemachtigde'][$i1] = @$r['14.'.$i0.'.2.'.$i1.''];
      }
    }
    $zittingen=array();
    for($i0=0;isset($r['15.'.$i0]);$i0++){
      $zittingen[$i0] = array( 'id' => @$r['15.'.$i0.'']
                             , 'behandeling' => array( 'id' => @$r['15.'.$i0.'.0.0'], 'zitting' => @$r['15.'.$i0.'.0.0'], 'locatie' => @$r['15.'.$i0.'.0.2'], 'kamer' => @$r['15.'.$i0.'.0.3'])
                             );
    }
    $Procedure=new Procedure($ID,$eiser, $gemachtigdevooreiser, $gedaagde, $gemachtigdevoorgedaagde, $gevoegd, $gemachtigdevoorgevoegde, $rechtsgebied, $proceduresoort, $zitting, $behandeling, $bevoegd, $zorgdragervoordossier, $zaaksdossier, $cluster, $machtigingen, $zittingen);
    if($Procedure->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Procedure='.urlencode($Procedure->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Procedure'])){
    if(!$del || !delProcedure($_REQUEST['Procedure']))
      $Procedure = readProcedure($_REQUEST['Procedure']);
    else $Procedure = false; // delete was a succes!
  } else if($new) $Procedure = new Procedure();
  else $Procedure = false;
  if($Procedure){
    writeHead("<TITLE>Procedure - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Procedure->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Procedure->getId()).'" /></P>';
    else echo '<H1>'.$Procedure->getId().'</H1>';
    ?>
    <DIV class="Floater eiser">
      <DIV class="FloaterHeader">eiser</DIV>
      <DIV class="FloaterContent"><?php
          $eiser = $Procedure->get_eiser();
          echo '
          <UL>';
          foreach($eiser as $i0=>$v0){
            echo '
            <LI CLASS="item UI_eiser" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To0.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0).'">RechterlijkeAmbtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_eiser" ID="0.'.count($eiser).'">new eiser</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater gemachtigde voor eiser">
      <DIV class="FloaterHeader">gemachtigde voor eiser</DIV>
      <DIV class="FloaterContent"><?php
          $gemachtigdevooreiser = $Procedure->get_gemachtigdevooreiser();
          echo '
          <UL>';
          foreach($gemachtigdevooreiser as $i0=>$v0){
            echo '
            <LI CLASS="item UI_gemachtigdevooreiser" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To1.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0).'">RechterlijkeAmbtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_gemachtigdevooreiser" ID="1.'.count($gemachtigdevooreiser).'">new gemachtigde voor eiser</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater gedaagde">
      <DIV class="FloaterHeader">gedaagde</DIV>
      <DIV class="FloaterContent"><?php
          $gedaagde = $Procedure->get_gedaagde();
          echo '
          <UL>';
          foreach($gedaagde as $i0=>$v0){
            echo '
            <LI CLASS="item UI_gedaagde" ID="2.'.$i0.'">';
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
            <LI CLASS="new UI_gedaagde" ID="2.'.count($gedaagde).'">new gedaagde</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater gemachtigde voor gedaagde">
      <DIV class="FloaterHeader">gemachtigde voor gedaagde</DIV>
      <DIV class="FloaterContent"><?php
          $gemachtigdevoorgedaagde = $Procedure->get_gemachtigdevoorgedaagde();
          echo '
          <UL>';
          foreach($gemachtigdevoorgedaagde as $i0=>$v0){
            echo '
            <LI CLASS="item UI_gemachtigdevoorgedaagde" ID="3.'.$i0.'">';
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
            <LI CLASS="new UI_gemachtigdevoorgedaagde" ID="3.'.count($gemachtigdevoorgedaagde).'">new gemachtigde voor gedaagde</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater gevoegd">
      <DIV class="FloaterHeader">gevoegd</DIV>
      <DIV class="FloaterContent"><?php
          $gevoegd = $Procedure->get_gevoegd();
          echo '
          <UL>';
          foreach($gevoegd as $i0=>$v0){
            echo '
            <LI CLASS="item UI_gevoegd" ID="4.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To4.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo4.'.$i0.'"><UL>';
                echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0).'">RechterlijkeAmbtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_gevoegd" ID="4.'.count($gevoegd).'">new gevoegd</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater gemachtigde voor gevoegde">
      <DIV class="FloaterHeader">gemachtigde voor gevoegde</DIV>
      <DIV class="FloaterContent"><?php
          $gemachtigdevoorgevoegde = $Procedure->get_gemachtigdevoorgevoegde();
          echo '
          <UL>';
          foreach($gemachtigdevoorgevoegde as $i0=>$v0){
            echo '
            <LI CLASS="item UI_gemachtigdevoorgevoegde" ID="5.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To5.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo5.'.$i0.'"><UL>';
                echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0).'">RechterlijkeAmbtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_gemachtigdevoorgevoegde" ID="5.'.count($gemachtigdevoorgevoegde).'">new gemachtigde voor gevoegde</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater rechtsgebied">
      <DIV class="FloaterHeader">rechtsgebied</DIV>
      <DIV class="FloaterContent"><?php
          $rechtsgebied = $Procedure->get_rechtsgebied();
          echo '<SPAN CLASS="item UI_rechtsgebied" ID="6">';
          if(!$edit) echo '
          <A HREF="Rechtsgebied.php?Rechtsgebied='.urlencode($rechtsgebied).'">'.htmlspecialchars($rechtsgebied).'</A>';
          else echo htmlspecialchars($rechtsgebied);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater proceduresoort">
      <DIV class="FloaterHeader">proceduresoort</DIV>
      <DIV class="FloaterContent"><?php
          $proceduresoort = $Procedure->get_proceduresoort();
          echo '<SPAN CLASS="item UI_proceduresoort" ID="7">';
          if(!$edit) echo '
          <A HREF="Proceduresoort.php?Proceduresoort='.urlencode($proceduresoort).'">'.htmlspecialchars($proceduresoort).'</A>';
          else echo htmlspecialchars($proceduresoort);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater zitting">
      <DIV class="FloaterHeader">zitting</DIV>
      <DIV class="FloaterContent"><?php
          $zitting = $Procedure->get_zitting();
          echo '
          <UL>';
          foreach($zitting as $i0=>$v0){
            echo '
            <LI CLASS="item UI_zitting" ID="8.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Zitting.php?Zitting='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'kamer: ';
                echo '<SPAN CLASS="item UI_zitting_kamer" ID="8.'.$i0.'.0">';
                if(!$edit) echo '
                <A HREF="Kamer.php?Kamer='.urlencode($v0['kamer']).'">'.htmlspecialchars($v0['kamer']).'</A>';
                else echo htmlspecialchars($v0['kamer']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'geagendeerd: ';
                echo '<SPAN CLASS="item UI_zitting_geagendeerd" ID="8.'.$i0.'.1">';
                echo htmlspecialchars($v0['geagendeerd']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rechter: ';
                echo '
                <UL>';
                foreach($v0['rechter'] as $i1=>$rechter){
                  echo '
                  <LI CLASS="item UI_zitting_rechter" ID="8.'.$i0.'.2.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To8.'.$i0.'.2.'.$i1.'">';
                      echo htmlspecialchars($rechter).'</A>';
                      echo '<DIV class="Goto" id="GoTo8.'.$i0.'.2.'.$i1.'"><UL>';
                      echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($rechter).'">RechterlijkeAmbtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($rechter).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($rechter).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($rechter);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_zitting_rechter" ID="8.'.$i0.'.2.'.count($v0['rechter']).'">new rechter</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'griffier: ';
                echo '<SPAN CLASS="item UI_zitting_griffier" ID="8.'.$i0.'.3">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To8.'.$i0.'.3">';
                  echo htmlspecialchars($v0['griffier']).'</A>';
                  echo '<DIV class="Goto" id="GoTo8.'.$i0.'.3"><UL>';
                  echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0['griffier']).'">RechterlijkeAmbtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['griffier']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['griffier']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['griffier']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="8.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_zitting" ID="8.'.count($zitting).'">new zitting</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in zitting
      function UI_zitting(id){
        return '<DIV>kamer: <SPAN CLASS="item UI_zitting_kamer" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>geagendeerd: <SPAN CLASS="item UI_zitting_geagendeerd" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>rechter: <UL><LI CLASS="new UI_zitting_rechter" ID="'+id+'.2">new rechter</LI></UL></DIV>'
             + '<DIV>griffier: <SPAN CLASS="item UI_zitting_griffier" ID="'+id+'.3"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater behandeling">
      <DIV class="FloaterHeader">behandeling</DIV>
      <DIV class="FloaterContent"><?php
          $behandeling = $Procedure->get_behandeling();
          echo '
          <UL>';
          foreach($behandeling as $i0=>$v0){
            echo '
            <LI CLASS="item UI_behandeling" ID="9.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To9.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo9.'.$i0.'"><UL>';
                echo '<LI><A HREF="Behandeling.php?Behandeling='.urlencode($v0['id']).'">Behandeling</A></LI>';
                echo '<LI><A HREF="ZaakInplannen.php?ZaakInplannen='.urlencode($v0['id']).'">ZaakInplannen</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'rolnummer: ';
                echo '<SPAN CLASS="item UI_behandeling_rolnummer" ID="9.'.$i0.'.0">';
                echo htmlspecialchars($v0['rolnummer']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'zittingsnummer: ';
                echo '<SPAN CLASS="item UI_behandeling_zittingsnummer" ID="9.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Zitting.php?Zitting='.urlencode($v0['zittingsnummer']).'">'.htmlspecialchars($v0['zittingsnummer']).'</A>';
                else echo htmlspecialchars($v0['zittingsnummer']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'zaaknummer: ';
                echo '<SPAN CLASS="item UI_behandeling_zaaknummer" ID="9.'.$i0.'.2">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To9.'.$i0.'.2">';
                  echo htmlspecialchars($v0['zaaknummer']).'</A>';
                  echo '<DIV class="Goto" id="GoTo9.'.$i0.'.2"><UL>';
                  echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($v0['zaaknummer']).'">BasisgegevensUC001</A></LI>';
                  echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($v0['zaaknummer']).'">Procedure</A></LI>';
                  echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($v0['zaaknummer']).'">nieuweProcedure</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['zaaknummer']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="9.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_behandeling" ID="9.'.count($behandeling).'">new behandeling</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in behandeling
      function UI_behandeling(id){
        return '<DIV>rolnummer: <SPAN CLASS="item UI_behandeling_rolnummer" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>zittingsnummer: <SPAN CLASS="item UI_behandeling_zittingsnummer" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>zaaknummer: <SPAN CLASS="item UI_behandeling_zaaknummer" ID="'+id+'.2"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater bevoegd">
      <DIV class="FloaterHeader">bevoegd</DIV>
      <DIV class="FloaterContent"><?php
          $bevoegd = $Procedure->get_bevoegd();
          echo '
          <UL>';
          foreach($bevoegd as $i0=>$v0){
            echo '
            <LI CLASS="item UI_bevoegd" ID="10.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Gerecht.php?Gerecht='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_bevoegd" ID="10.'.count($bevoegd).'">new bevoegd</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater zorgdrager voor dossier">
      <DIV class="FloaterHeader">zorgdrager voor dossier</DIV>
      <DIV class="FloaterContent"><?php
          $zorgdragervoordossier = $Procedure->get_zorgdragervoordossier();
          echo '<SPAN CLASS="item UI_zorgdragervoordossier" ID="11">';
          if(!$edit) echo '
          <A HREF="Orgaan.php?Orgaan='.urlencode($zorgdragervoordossier).'">'.htmlspecialchars($zorgdragervoordossier).'</A>';
          else echo htmlspecialchars($zorgdragervoordossier);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater zaaksdossier">
      <DIV class="FloaterHeader">zaaksdossier</DIV>
      <DIV class="FloaterContent"><?php
          $zaaksdossier = $Procedure->get_zaaksdossier();
          echo '
          <UL>';
          foreach($zaaksdossier as $i0=>$v0){
            echo '
            <LI CLASS="item UI_zaaksdossier" ID="12.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To12.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo12.'.$i0.'"><UL>';
                echo '<LI><A HREF="Brief.php?Brief='.urlencode($v0['id']).'">Brief</A></LI>';
                echo '<LI><A HREF="Betaling.php?Betaling='.urlencode($v0['id']).'">Betaling</A></LI>';
                echo '<LI><A HREF="Document.php?Document='.urlencode($v0['id']).'">Document</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'Document: ';
                echo '<SPAN CLASS="item UI_zaaksdossier_Document" ID="12.'.$i0.'.0">';
                echo htmlspecialchars($v0['Document']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type: ';
                echo '<SPAN CLASS="item UI_zaaksdossier_type" ID="12.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Documenttype.php?Documenttype='.urlencode($v0['type']).'">'.htmlspecialchars($v0['type']).'</A>';
                else echo htmlspecialchars($v0['type']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="12.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_zaaksdossier" ID="12.'.count($zaaksdossier).'">new zaaksdossier</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in zaaksdossier
      function UI_zaaksdossier(id){
        return '<DIV>Document: <SPAN CLASS="item UI_zaaksdossier_Document" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>type: <SPAN CLASS="item UI_zaaksdossier_type" ID="'+id+'.1"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater cluster">
      <DIV class="FloaterHeader">cluster</DIV>
      <DIV class="FloaterContent"><?php
          $cluster = $Procedure->get_cluster();
          echo '
          <UL>';
          foreach($cluster as $i0=>$v0){
            echo '
            <LI CLASS="item UI_cluster" ID="13.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Cluster.php?Cluster='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'nr: ';
                echo '<SPAN CLASS="item UI_cluster_nr" ID="13.'.$i0.'.0">';
                echo htmlspecialchars($v0['nr']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'naam: ';
                echo '<SPAN CLASS="item UI_cluster_naam" ID="13.'.$i0.'.1">';
                echo htmlspecialchars($v0['naam']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'grond: ';
                echo '
                <UL>';
                foreach($v0['grond'] as $i1=>$grond){
                  echo '
                  <LI CLASS="item UI_cluster_grond" ID="13.'.$i0.'.2.'.$i1.'">';
                    echo htmlspecialchars($grond);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_cluster_grond" ID="13.'.$i0.'.2.'.count($v0['grond']).'">new grond</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="13.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_cluster" ID="13.'.count($cluster).'">new cluster</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in cluster
      function UI_cluster(id){
        return '<DIV>nr: <SPAN CLASS="item UI_cluster_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>naam: <SPAN CLASS="item UI_cluster_naam" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>grond: <UL><LI CLASS="new UI_cluster_grond" ID="'+id+'.2">new grond</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater machtigingen">
      <DIV class="FloaterHeader">machtigingen</DIV>
      <DIV class="FloaterContent"><?php
          $machtigingen = $Procedure->get_machtigingen();
          echo '
          <UL>';
          foreach($machtigingen as $i0=>$v0){
            echo '
            <LI CLASS="item UI_machtigingen" ID="14.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Machtiging.php?Machtiging='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'machtiging: ';
                echo '<SPAN CLASS="item UI_machtigingen_machtiging" ID="14.'.$i0.'.0">';
                echo htmlspecialchars($v0['machtiging']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'partij: ';
                echo '<SPAN CLASS="item UI_machtigingen_partij" ID="14.'.$i0.'.1">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To14.'.$i0.'.1">';
                  echo htmlspecialchars($v0['partij']).'</A>';
                  echo '<DIV class="Goto" id="GoTo14.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0['partij']).'">RechterlijkeAmbtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['partij']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['partij']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['partij']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gemachtigde: ';
                echo '
                <UL>';
                foreach($v0['gemachtigde'] as $i1=>$gemachtigde){
                  echo '
                  <LI CLASS="item UI_machtigingen_gemachtigde" ID="14.'.$i0.'.2.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To14.'.$i0.'.2.'.$i1.'">';
                      echo htmlspecialchars($gemachtigde).'</A>';
                      echo '<DIV class="Goto" id="GoTo14.'.$i0.'.2.'.$i1.'"><UL>';
                      echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($gemachtigde).'">RechterlijkeAmbtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($gemachtigde).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($gemachtigde).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($gemachtigde);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_machtigingen_gemachtigde" ID="14.'.$i0.'.2.'.count($v0['gemachtigde']).'">new gemachtigde</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="14.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_machtigingen" ID="14.'.count($machtigingen).'">new machtigingen</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in machtigingen
      function UI_machtigingen(id){
        return '<DIV>machtiging: <SPAN CLASS="item UI_machtigingen_machtiging" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>partij: <SPAN CLASS="item UI_machtigingen_partij" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>gemachtigde: <UL><LI CLASS="new UI_machtigingen_gemachtigde" ID="'+id+'.2">new gemachtigde</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater zittingen">
      <DIV class="FloaterHeader">zittingen</DIV>
      <DIV class="FloaterContent"><?php
          $zittingen = $Procedure->get_zittingen();
          echo '
          <UL>';
          foreach($zittingen as $i0=>$v0){
            echo '
            <LI CLASS="item UI_zittingen" ID="15.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To15.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo15.'.$i0.'"><UL>';
                echo '<LI><A HREF="Behandeling.php?Behandeling='.urlencode($v0['id']).'">Behandeling</A></LI>';
                echo '<LI><A HREF="ZaakInplannen.php?ZaakInplannen='.urlencode($v0['id']).'">ZaakInplannen</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                ?> 
                <DIV class ="Holder"><DIV class="HolderHeader">behandeling</DIV>
                  <DIV class="HolderContent" name="behandeling"><?php
                      echo '<DIV CLASS="UI_zittingen" ID="15.'.$i0.'.0">';
                        if(!$edit){
                          echo '
                        <A HREF="Zitting.php?Zitting='.urlencode($v0['behandeling']['id']).'">';
                          echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
                        }
                        echo '
                        <DIV>';
                          echo 'zitting: ';
                          echo '<SPAN CLASS="item UI_zittingen_zitting" ID="15.'.$i0.'.0.0">';
                          echo htmlspecialchars($v0['behandeling']['zitting']);
                          echo '</SPAN>';
                        echo '</DIV>
                        <DIV>';
                          echo 'rechter: ';
                          echo '
                          <UL>';
                          foreach($v0['behandeling']['rechter'] as $i1=>$rechter){
                            echo '
                            <LI CLASS="item UI_zittingen_rechter" ID="15.'.$i0.'.0.1.'.$i1.'">';
                              if(!$edit){
                                echo '
                              <A class="GotoLink" id="To15.'.$i0.'.0.1.'.$i1.'">';
                                echo htmlspecialchars($rechter).'</A>';
                                echo '<DIV class="Goto" id="GoTo15.'.$i0.'.0.1.'.$i1.'"><UL>';
                                echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($rechter).'">RechterlijkeAmbtenaar</A></LI>';
                                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($rechter).'">Persoon</A></LI>';
                                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($rechter).'">Belanghebbende</A></LI>';
                                echo '</UL></DIV>';
                              } else echo htmlspecialchars($rechter);
                            echo '</LI>';
                          }
                          if($edit) echo '
                            <LI CLASS="new UI_zittingen_rechter" ID="15.'.$i0.'.0.1.'.count($v0['behandeling']['rechter']).'">new rechter</LI>';
                          echo '
                          </UL>';
                        echo '</DIV>
                        <DIV>';
                          echo 'locatie: ';
                          echo '<SPAN CLASS="item UI_zittingen_locatie" ID="15.'.$i0.'.0.2">';
                          if(!$edit) echo '
                          <A HREF="Gerecht.php?Gerecht='.urlencode($v0['behandeling']['locatie']).'">'.htmlspecialchars($v0['behandeling']['locatie']).'</A>';
                          else echo htmlspecialchars($v0['behandeling']['locatie']);
                          echo '</SPAN>';
                        echo '</DIV>
                        <DIV>';
                          echo 'kamer: ';
                          echo '<SPAN CLASS="item UI_zittingen_kamer" ID="15.'.$i0.'.0.3">';
                          if(!$edit) echo '
                          <A HREF="Kamer.php?Kamer='.urlencode($v0['behandeling']['kamer']).'">'.htmlspecialchars($v0['behandeling']['kamer']).'</A>';
                          else echo htmlspecialchars($v0['behandeling']['kamer']);
                          echo '</SPAN>';
                        echo '
                        </DIV>';
                        if($edit) echo '
                        <INPUT TYPE="hidden" name="15.'.$i0.'.0.ID" VALUE="'.$v0['behandeling']['id'].'" />';
                      echo '</DIV>';
                    ?> 
                  </DIV>
                </DIV>
                <?php
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="15.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_zittingen" ID="15.'.count($zittingen).'">new zittingen</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in zittingen
      function UI_zittingen(id){
        return '<DIV>behandeling: <SPAN CLASS="item UI_zittingen_behandeling" ID="'+id+'.0"><DIV>zitting: <SPAN CLASS="item UI_zittingen_behandeling_zitting" ID="'+id+'.00"></SPAN></DIV><DIV>rechter: <UL><LI CLASS="new UI_zittingen_behandeling_rechter" ID="'+id+'.01">new rechter</LI></UL></DIV><DIV>locatie: <SPAN CLASS="item UI_zittingen_behandeling_locatie" ID="'+id+'.02"></SPAN></DIV><DIV>kamer: <SPAN CLASS="item UI_zittingen_behandeling_kamer" ID="'+id+'.03"></SPAN></DIV></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Procedure->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Procedure=".urlencode($Procedure->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Procedure=".urlencode($Procedure->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Procedure=".urlencode($Procedure->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Procedure is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Procedure object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Procedure object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>