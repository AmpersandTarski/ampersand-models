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
  require "Gerecht.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Zittingen=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Zittingen[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                             , 'Zitting' => @$r['0.'.$i0.'.0']
                             , 'kamer' => @$r['0.'.$i0.'.1']
                             , 'griffier' => @$r['0.'.$i0.'.3']
                             , 'geagendeerd' => @$r['0.'.$i0.'.4']
                             );
      $Zittingen[$i0]['rechter']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $Zittingen[$i0]['rechter'][$i1] = @$r['0.'.$i0.'.2.'.$i1.''];
      }
      $Zittingen[$i0]['rol']=array();
      for($i1=0;isset($r['0.'.$i0.'.5.'.$i1]);$i1++){
        $Zittingen[$i0]['rol'][$i1] = array( 'id' => @$r['0.'.$i0.'.5.'.$i1.'.0']
                                           , 'nr' => @$r['0.'.$i0.'.5.'.$i1.'.0']
                                           , 'zaak' => @$r['0.'.$i0.'.5.'.$i1.'.1']
                                           , 'proceduresoort' => @$r['0.'.$i0.'.5.'.$i1.'.2']
                                           );
      }
    }
    $kamers=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $kamers[$i0] = @$r['1.'.$i0.''];
    }
    $benoemd=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $benoemd[$i0] = @$r['2.'.$i0.''];
    }
    $zaken=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $zaken[$i0] = @$r['3.'.$i0.''];
    }
    $hoofdplaats = @$r['4'];
    $nevenvestigingsplaatsen=array();
    for($i0=0;isset($r['5.'.$i0]);$i0++){
      $nevenvestigingsplaatsen[$i0] = @$r['5.'.$i0.''];
    }
    $teAgenderen=array();
    for($i0=0;isset($r['6.'.$i0]);$i0++){
      $teAgenderen[$i0] = array( 'id' => @$r['6.'.$i0.'.0']
                               , 'zaaknr' => @$r['6.'.$i0.'.0']
                               );
      $teAgenderen[$i0]['gedaagde']=array();
      for($i1=0;isset($r['6.'.$i0.'.1.'.$i1]);$i1++){
        $teAgenderen[$i0]['gedaagde'][$i1] = @$r['6.'.$i0.'.1.'.$i1.''];
      }
      $teAgenderen[$i0]['eiser']=array();
      for($i1=0;isset($r['6.'.$i0.'.2.'.$i1]);$i1++){
        $teAgenderen[$i0]['eiser'][$i1] = @$r['6.'.$i0.'.2.'.$i1.''];
      }
      $teAgenderen[$i0]['gevoegde']=array();
      for($i1=0;isset($r['6.'.$i0.'.3.'.$i1]);$i1++){
        $teAgenderen[$i0]['gevoegde'][$i1] = @$r['6.'.$i0.'.3.'.$i1.''];
      }
    }
    $Gerecht=new Gerecht($ID,$Zittingen, $kamers, $benoemd, $zaken, $hoofdplaats, $nevenvestigingsplaatsen, $teAgenderen);
    if($Gerecht->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Gerecht='.urlencode($Gerecht->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Gerecht'])){
    if(!$del || !delGerecht($_REQUEST['Gerecht']))
      $Gerecht = readGerecht($_REQUEST['Gerecht']);
    else $Gerecht = false; // delete was a succes!
  } else if($new) $Gerecht = new Gerecht();
  else $Gerecht = false;
  if($Gerecht){
    writeHead("<TITLE>Gerecht - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Gerecht->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Gerecht->getId()).'" /></P>';
    else echo '<H1>'.$Gerecht->getId().'</H1>';
    ?>
    <DIV class="Floater Zittingen">
      <DIV class="FloaterHeader">Zittingen</DIV>
      <DIV class="FloaterContent"><?php
          $Zittingen = $Gerecht->get_Zittingen();
          echo '
          <UL>';
          foreach($Zittingen as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Zittingen" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Zitting.php?Zitting='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'Zitting: ';
                echo '<SPAN CLASS="item UI_Zittingen_Zitting" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['Zitting']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'kamer: ';
                echo '<SPAN CLASS="item UI_Zittingen_kamer" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Kamer.php?Kamer='.urlencode($v0['kamer']).'">'.htmlspecialchars($v0['kamer']).'</A>';
                else echo htmlspecialchars($v0['kamer']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rechter: ';
                echo '
                <UL>';
                foreach($v0['rechter'] as $i1=>$rechter){
                  echo '
                  <LI CLASS="item UI_Zittingen_rechter" ID="0.'.$i0.'.2.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.2.'.$i1.'">';
                      echo htmlspecialchars($rechter).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.2.'.$i1.'"><UL>';
                      echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($rechter).'">RechterlijkeAmbtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($rechter).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($rechter).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($rechter);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Zittingen_rechter" ID="0.'.$i0.'.2.'.count($v0['rechter']).'">new rechter</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'griffier: ';
                echo '<SPAN CLASS="item UI_Zittingen_griffier" ID="0.'.$i0.'.3">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To0.'.$i0.'.3">';
                  echo htmlspecialchars($v0['griffier']).'</A>';
                  echo '<DIV class="Goto" id="GoTo0.'.$i0.'.3"><UL>';
                  echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0['griffier']).'">RechterlijkeAmbtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['griffier']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['griffier']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['griffier']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'geagendeerd: ';
                echo '<SPAN CLASS="item UI_Zittingen_geagendeerd" ID="0.'.$i0.'.4">';
                echo htmlspecialchars($v0['geagendeerd']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                ?> 
                <DIV class ="Holder"><DIV class="HolderHeader">rol</DIV>
                  <DIV class="HolderContent" name="rol"><?php
                      echo '
                      <UL>';
                      foreach($v0['rol'] as $i1=>$rol){
                        echo '
                        <LI CLASS="item UI_Zittingen_rol" ID="0.'.$i0.'.5.'.$i1.'">';
                          if(!$edit){
                            echo '
                          <DIV class="GotoArrow" id="To0.'.$i0.'.5.'.$i1.'">&rArr;</DIV>';
                            echo '<DIV class="Goto" id="GoTo0.'.$i0.'.5.'.$i1.'"><UL>';
                            echo '<LI><A HREF="Behandeling.php?Behandeling='.urlencode($rol['id']).'">Behandeling</A></LI>';
                            echo '<LI><A HREF="ZaakInplannen.php?ZaakInplannen='.urlencode($rol['id']).'">ZaakInplannen</A></LI>';
                            echo '</UL></DIV>';
                          }
                          echo '
                          <DIV>';
                            echo 'nr: ';
                            echo '<SPAN CLASS="item UI_Zittingen_rol_nr" ID="0.'.$i0.'.5.'.$i1.'.0">';
                            echo htmlspecialchars($rol['nr']);
                            echo '</SPAN>';
                          echo '</DIV>
                          <DIV>';
                            echo 'zaak: ';
                            echo '<SPAN CLASS="item UI_Zittingen_rol_zaak" ID="0.'.$i0.'.5.'.$i1.'.1">';
                            if(!$edit){
                              echo '
                            <A class="GotoLink" id="To0.'.$i0.'.5.'.$i1.'.1">';
                              echo htmlspecialchars($rol['zaak']).'</A>';
                              echo '<DIV class="Goto" id="GoTo0.'.$i0.'.5.'.$i1.'.1"><UL>';
                              echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($rol['zaak']).'">BasisgegevensUC001</A></LI>';
                              echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($rol['zaak']).'">Procedure</A></LI>';
                              echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($rol['zaak']).'">nieuweProcedure</A></LI>';
                              echo '</UL></DIV>';
                            } else echo htmlspecialchars($rol['zaak']);
                            echo '</SPAN>';
                          echo '</DIV>
                          <DIV>';
                            echo 'proceduresoort: ';
                            echo '<SPAN CLASS="item UI_Zittingen_rol_proceduresoort" ID="0.'.$i0.'.5.'.$i1.'.2">';
                            if(!$edit) echo '
                            <A HREF="Proceduresoort.php?Proceduresoort='.urlencode($rol['proceduresoort']).'">'.htmlspecialchars($rol['proceduresoort']).'</A>';
                            else echo htmlspecialchars($rol['proceduresoort']);
                            echo '</SPAN>';
                          echo '
                          </DIV>';
                          if($edit) echo '
                          <INPUT TYPE="hidden" name="0.'.$i0.'.5.'.$i1.'.ID" VALUE="'.$rol['id'].'" />';
                        echo '</LI>';
                      }
                      if($edit) echo '
                        <LI CLASS="new UI_Zittingen_rol" ID="0.'.$i0.'.5.'.count($v0['rol']).'">new rol</LI>';
                      echo '
                      </UL>';
                    ?> 
                  </DIV>
                </DIV>
                <?php
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Zittingen" ID="0.'.count($Zittingen).'">new Zittingen</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Zittingen
      function UI_Zittingen(id){
        return '<DIV>Zitting: <SPAN CLASS="item UI_Zittingen_Zitting" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>kamer: <SPAN CLASS="item UI_Zittingen_kamer" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>rechter: <UL><LI CLASS="new UI_Zittingen_rechter" ID="'+id+'.2">new rechter</LI></UL></DIV>'
             + '<DIV>griffier: <SPAN CLASS="item UI_Zittingen_griffier" ID="'+id+'.3"></SPAN></DIV>'
             + '<DIV>geagendeerd: <SPAN CLASS="item UI_Zittingen_geagendeerd" ID="'+id+'.4"></SPAN></DIV>'
             + '<DIV>rol: <UL><LI CLASS="new UI_Zittingen_rol" ID="'+id+'.5">new rol</LI></UL></DIV>'
              ;
      }
      function UI_Zittingen_rol(id){
        return '<DIV>nr: <SPAN CLASS="item UI_Zittingen_rol_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>zaak: <SPAN CLASS="item UI_Zittingen_rol_zaak" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>proceduresoort: <SPAN CLASS="item UI_Zittingen_rol_proceduresoort" ID="'+id+'.2"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater kamers">
      <DIV class="FloaterHeader">kamers</DIV>
      <DIV class="FloaterContent"><?php
          $kamers = $Gerecht->get_kamers();
          echo '
          <UL>';
          foreach($kamers as $i0=>$v0){
            echo '
            <LI CLASS="item UI_kamers" ID="1.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Kamer.php?Kamer='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_kamers" ID="1.'.count($kamers).'">new kamers</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater benoemd">
      <DIV class="FloaterHeader">benoemd</DIV>
      <DIV class="FloaterContent"><?php
          $benoemd = $Gerecht->get_benoemd();
          echo '
          <UL>';
          foreach($benoemd as $i0=>$v0){
            echo '
            <LI CLASS="item UI_benoemd" ID="2.'.$i0.'">';
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
            <LI CLASS="new UI_benoemd" ID="2.'.count($benoemd).'">new benoemd</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater zaken">
      <DIV class="FloaterHeader">zaken</DIV>
      <DIV class="FloaterContent"><?php
          $zaken = $Gerecht->get_zaken();
          echo '
          <UL>';
          foreach($zaken as $i0=>$v0){
            echo '
            <LI CLASS="item UI_zaken" ID="3.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To3.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo3.'.$i0.'"><UL>';
                echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($v0).'">BasisgegevensUC001</A></LI>';
                echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($v0).'">Procedure</A></LI>';
                echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($v0).'">nieuweProcedure</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_zaken" ID="3.'.count($zaken).'">new zaken</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater hoofdplaats">
      <DIV class="FloaterHeader">hoofdplaats</DIV>
      <DIV class="FloaterContent"><?php
          $hoofdplaats = $Gerecht->get_hoofdplaats();
          echo '<SPAN CLASS="item UI_hoofdplaats" ID="4">';
          if(!$edit) echo '
          <A HREF="Plaats.php?Plaats='.urlencode($hoofdplaats).'">'.htmlspecialchars($hoofdplaats).'</A>';
          else echo htmlspecialchars($hoofdplaats);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater nevenvestigingsplaatsen">
      <DIV class="FloaterHeader">nevenvestigingsplaatsen</DIV>
      <DIV class="FloaterContent"><?php
          $nevenvestigingsplaatsen = $Gerecht->get_nevenvestigingsplaatsen();
          echo '
          <UL>';
          foreach($nevenvestigingsplaatsen as $i0=>$v0){
            echo '
            <LI CLASS="item UI_nevenvestigingsplaatsen" ID="5.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Plaats.php?Plaats='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_nevenvestigingsplaatsen" ID="5.'.count($nevenvestigingsplaatsen).'">new nevenvestigingsplaatsen</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater teAgenderen">
      <DIV class="FloaterHeader">teAgenderen</DIV>
      <DIV class="FloaterContent"><?php
          $teAgenderen = $Gerecht->get_teAgenderen();
          echo '
          <UL>';
          foreach($teAgenderen as $i0=>$v0){
            echo '
            <LI CLASS="item UI_teAgenderen" ID="6.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To6.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo6.'.$i0.'"><UL>';
                echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($v0['id']).'">BasisgegevensUC001</A></LI>';
                echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($v0['id']).'">Procedure</A></LI>';
                echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($v0['id']).'">nieuweProcedure</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'zaaknr: ';
                echo '<SPAN CLASS="item UI_teAgenderen_zaaknr" ID="6.'.$i0.'.0">';
                echo htmlspecialchars($v0['zaaknr']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gedaagde: ';
                echo '
                <UL>';
                foreach($v0['gedaagde'] as $i1=>$gedaagde){
                  echo '
                  <LI CLASS="item UI_teAgenderen_gedaagde" ID="6.'.$i0.'.1.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To6.'.$i0.'.1.'.$i1.'">';
                      echo htmlspecialchars($gedaagde).'</A>';
                      echo '<DIV class="Goto" id="GoTo6.'.$i0.'.1.'.$i1.'"><UL>';
                      echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($gedaagde).'">RechterlijkeAmbtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($gedaagde).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($gedaagde).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($gedaagde);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_teAgenderen_gedaagde" ID="6.'.$i0.'.1.'.count($v0['gedaagde']).'">new gedaagde</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'eiser: ';
                echo '
                <UL>';
                foreach($v0['eiser'] as $i1=>$eiser){
                  echo '
                  <LI CLASS="item UI_teAgenderen_eiser" ID="6.'.$i0.'.2.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To6.'.$i0.'.2.'.$i1.'">';
                      echo htmlspecialchars($eiser).'</A>';
                      echo '<DIV class="Goto" id="GoTo6.'.$i0.'.2.'.$i1.'"><UL>';
                      echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($eiser).'">RechterlijkeAmbtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($eiser).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($eiser).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($eiser);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_teAgenderen_eiser" ID="6.'.$i0.'.2.'.count($v0['eiser']).'">new eiser</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'gevoegde: ';
                echo '
                <UL>';
                foreach($v0['gevoegde'] as $i1=>$gevoegde){
                  echo '
                  <LI CLASS="item UI_teAgenderen_gevoegde" ID="6.'.$i0.'.3.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To6.'.$i0.'.3.'.$i1.'">';
                      echo htmlspecialchars($gevoegde).'</A>';
                      echo '<DIV class="Goto" id="GoTo6.'.$i0.'.3.'.$i1.'"><UL>';
                      echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($gevoegde).'">RechterlijkeAmbtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($gevoegde).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($gevoegde).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($gevoegde);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_teAgenderen_gevoegde" ID="6.'.$i0.'.3.'.count($v0['gevoegde']).'">new gevoegde</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="6.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_teAgenderen" ID="6.'.count($teAgenderen).'">new teAgenderen</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in teAgenderen
      function UI_teAgenderen(id){
        return '<DIV>zaaknr: <SPAN CLASS="item UI_teAgenderen_zaaknr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>gedaagde: <UL><LI CLASS="new UI_teAgenderen_gedaagde" ID="'+id+'.1">new gedaagde</LI></UL></DIV>'
             + '<DIV>eiser: <UL><LI CLASS="new UI_teAgenderen_eiser" ID="'+id+'.2">new eiser</LI></UL></DIV>'
             + '<DIV>gevoegde: <UL><LI CLASS="new UI_teAgenderen_gevoegde" ID="'+id+'.3">new gevoegde</LI></UL></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Gerecht->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Gerecht=".urlencode($Gerecht->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Gerecht=".urlencode($Gerecht->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Gerecht=".urlencode($Gerecht->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Gerecht is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Gerecht object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Gerecht object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>