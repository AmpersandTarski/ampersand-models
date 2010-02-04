<?php // generated with ADL vs. 0.8.10-451
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
  require "Rechterlijke ambtenaar.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $lid=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $lid[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                       , 'kamer' => @$r['0.'.$i0.'.0']
                       , 'gerecht' => @$r['0.'.$i0.'.1']
                       , 'sectorSector' => @$r['0.'.$i0.'.2']
                       );
    }
    $rol=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $rol[$i0] = @$r['1.'.$i0.''];
    }
    $geautoriseerdvoor=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $geautoriseerdvoor[$i0] = @$r['2.'.$i0.''];
    }
    $Zittingen=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $Zittingen[$i0] = array( 'id' => @$r['3.'.$i0.'']
                             , 'griffier' => @$r['3.'.$i0.'.1']
                             , 'geagendeerd' => @$r['3.'.$i0.'.2']
                             , 'plaats' => @$r['3.'.$i0.'.3']
                             , 'locatie' => @$r['3.'.$i0.'.4']
                             , 'kamer' => array( 'id' => @$r['3.'.$i0.'.5'], 'gerecht' => @$r['3.'.$i0.'.5.0'], 'sectorSector' => @$r['3.'.$i0.'.5.1'])
                             );
      $Zittingen[$i0]['rechter']=array();
      for($i1=0;isset($r['3.'.$i0.'.0.'.$i1]);$i1++){
        $Zittingen[$i0]['rechter'][$i1] = @$r['3.'.$i0.'.0.'.$i1.''];
      }
    }
    $ontvangen=array();
    for($i0=0;isset($r['4.'.$i0]);$i0++){
      $ontvangen[$i0] = array( 'id' => @$r['4.'.$i0.'.0']
                             , 'bericht' => @$r['4.'.$i0.'.0']
                             , 'van' => @$r['4.'.$i0.'.1']
                             , 'verzonden' => @$r['4.'.$i0.'.2']
                             , 'ontvangen' => @$r['4.'.$i0.'.3']
                             );
    }
    $verzonden=array();
    for($i0=0;isset($r['5.'.$i0]);$i0++){
      $verzonden[$i0] = array( 'id' => @$r['5.'.$i0.'.0']
                             , 'bericht' => @$r['5.'.$i0.'.0']
                             , 'van' => @$r['5.'.$i0.'.1']
                             , 'verzonden' => @$r['5.'.$i0.'.2']
                             );
    }
    $Rechterlijkeambtenaar=new Rechterlijkeambtenaar($ID,$lid, $rol, $geautoriseerdvoor, $Zittingen, $ontvangen, $verzonden);
    if($Rechterlijkeambtenaar->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Rechterlijkeambtenaar='.urlencode($Rechterlijkeambtenaar->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Rechterlijkeambtenaar'])){
    if(!$del || !delRechterlijkeambtenaar($_REQUEST['Rechterlijkeambtenaar']))
      $Rechterlijkeambtenaar = readRechterlijkeambtenaar($_REQUEST['Rechterlijkeambtenaar']);
    else $Rechterlijkeambtenaar = false; // delete was a succes!
  } else if($new) $Rechterlijkeambtenaar = new Rechterlijkeambtenaar();
  else $Rechterlijkeambtenaar = false;
  if($Rechterlijkeambtenaar){
    writeHead("<TITLE>Rechterlijke ambtenaar - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Rechterlijkeambtenaar->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Rechterlijkeambtenaar->getId()).'" /></P>';
    else echo '<H1>'.$Rechterlijkeambtenaar->getId().'</H1>';
    ?>
    <DIV class="Floater lid">
      <DIV class="FloaterHeader">lid</DIV>
      <DIV class="FloaterContent"><?php
          $lid = $Rechterlijkeambtenaar->get_lid();
          echo '
          <UL>';
          foreach($lid as $i0=>$v0){
            echo '
            <LI CLASS="item UI_lid" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Kamer.php?Kamer='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'kamer: ';
                echo '<SPAN CLASS="item UI_lid_kamer" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['kamer']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gerecht: ';
                echo '<SPAN CLASS="item UI_lid_gerecht" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Gerecht.php?Gerecht='.urlencode($v0['gerecht']).'">'.htmlspecialchars($v0['gerecht']).'</A>';
                else echo htmlspecialchars($v0['gerecht']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'sectorSector: ';
                echo '<SPAN CLASS="item UI_lid_sectorSector" ID="0.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="Sector.php?Sector='.urlencode($v0['sectorSector']).'">'.htmlspecialchars($v0['sectorSector']).'</A>';
                else echo htmlspecialchars($v0['sectorSector']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_lid" ID="0.'.count($lid).'">new lid</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in lid
      function UI_lid(id){
        return '<DIV>kamer: <SPAN CLASS="item UI_lid_kamer" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>gerecht: <SPAN CLASS="item UI_lid_gerecht" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>sectorSector: <SPAN CLASS="item UI_lid_sectorSector" ID="'+id+'.2"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater rol">
      <DIV class="FloaterHeader">rol</DIV>
      <DIV class="FloaterContent"><?php
          $rol = $Rechterlijkeambtenaar->get_rol();
          echo '
          <UL>';
          foreach($rol as $i0=>$v0){
            echo '
            <LI CLASS="item UI_rol" ID="1.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_rol" ID="1.'.count($rol).'">new rol</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater geautoriseerd voor">
      <DIV class="FloaterHeader">geautoriseerd voor</DIV>
      <DIV class="FloaterContent"><?php
          $geautoriseerdvoor = $Rechterlijkeambtenaar->get_geautoriseerdvoor();
          echo '
          <UL>';
          foreach($geautoriseerdvoor as $i0=>$v0){
            echo '
            <LI CLASS="item UI_geautoriseerdvoor" ID="2.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_geautoriseerdvoor" ID="2.'.count($geautoriseerdvoor).'">new geautoriseerd voor</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater Zittingen">
      <DIV class="FloaterHeader">Zittingen</DIV>
      <DIV class="FloaterContent"><?php
          $Zittingen = $Rechterlijkeambtenaar->get_Zittingen();
          echo '
          <UL>';
          foreach($Zittingen as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Zittingen" ID="3.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Zitting.php?Zitting='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'rechter: ';
                echo '
                <UL>';
                foreach($v0['rechter'] as $i1=>$rechter){
                  echo '
                  <LI CLASS="item UI_Zittingen_rechter" ID="3.'.$i0.'.0.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To3.'.$i0.'.0.'.$i1.'">';
                      echo htmlspecialchars($rechter).'</A>';
                      echo '<DIV class="Goto" id="GoTo3.'.$i0.'.0.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Rechterlijke ambtenaar.php?Rechterlijkeambtenaar='.urlencode($rechter).'">Rechterlijke ambtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($rechter).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($rechter).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($rechter);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Zittingen_rechter" ID="3.'.$i0.'.0.'.count($v0['rechter']).'">new rechter</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'griffier: ';
                echo '<SPAN CLASS="item UI_Zittingen_griffier" ID="3.'.$i0.'.1">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To3.'.$i0.'.1">';
                  echo htmlspecialchars($v0['griffier']).'</A>';
                  echo '<DIV class="Goto" id="GoTo3.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="Rechterlijke ambtenaar.php?Rechterlijkeambtenaar='.urlencode($v0['griffier']).'">Rechterlijke ambtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['griffier']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['griffier']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['griffier']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'geagendeerd: ';
                echo '<SPAN CLASS="item UI_Zittingen_geagendeerd" ID="3.'.$i0.'.2">';
                echo htmlspecialchars($v0['geagendeerd']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'plaats: ';
                echo '<SPAN CLASS="item UI_Zittingen_plaats" ID="3.'.$i0.'.3">';
                if(!$edit) echo '
                <A HREF="Plaats.php?Plaats='.urlencode($v0['plaats']).'">'.htmlspecialchars($v0['plaats']).'</A>';
                else echo htmlspecialchars($v0['plaats']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'locatie: ';
                echo '<SPAN CLASS="item UI_Zittingen_locatie" ID="3.'.$i0.'.4">';
                if(!$edit) echo '
                <A HREF="Gerecht.php?Gerecht='.urlencode($v0['locatie']).'">'.htmlspecialchars($v0['locatie']).'</A>';
                else echo htmlspecialchars($v0['locatie']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                ?> 
                <DIV class ="Holder"><DIV class="HolderHeader">kamer</DIV>
                  <DIV class="HolderContent" name="kamer"><?php
                      echo '<DIV CLASS="UI_Zittingen_kamer" ID="3.'.$i0.'.5">';
                        if(!$edit){
                          echo '
                        <A HREF="Kamer.php?Kamer='.urlencode($v0['kamer']['id']).'">';
                          echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
                        }
                        echo '
                        <DIV>';
                          echo 'gerecht: ';
                          echo '<SPAN CLASS="item UI_Zittingen_kamer_gerecht" ID="3.'.$i0.'.5.0">';
                          if(!$edit) echo '
                          <A HREF="Gerecht.php?Gerecht='.urlencode($v0['kamer']['gerecht']).'">'.htmlspecialchars($v0['kamer']['gerecht']).'</A>';
                          else echo htmlspecialchars($v0['kamer']['gerecht']);
                          echo '</SPAN>';
                        echo '</DIV>
                        <DIV>';
                          echo 'sectorSector: ';
                          echo '<SPAN CLASS="item UI_Zittingen_kamer_sectorSector" ID="3.'.$i0.'.5.1">';
                          if(!$edit) echo '
                          <A HREF="Sector.php?Sector='.urlencode($v0['kamer']['sectorSector']).'">'.htmlspecialchars($v0['kamer']['sectorSector']).'</A>';
                          else echo htmlspecialchars($v0['kamer']['sectorSector']);
                          echo '</SPAN>';
                        echo '
                        </DIV>';
                        if($edit) echo '
                        <INPUT TYPE="hidden" name="3.'.$i0.'.5.ID" VALUE="'.$v0['kamer']['id'].'" />';
                      echo '</DIV>';
                    ?> 
                  </DIV>
                </DIV>
                <?php
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="3.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Zittingen" ID="3.'.count($Zittingen).'">new Zittingen</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Zittingen
      function UI_Zittingen(id){
        return '<DIV>rechter: <UL><LI CLASS="new UI_Zittingen_rechter" ID="'+id+'.0">new rechter</LI></UL></DIV>'
             + '<DIV>griffier: <SPAN CLASS="item UI_Zittingen_griffier" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>geagendeerd: <SPAN CLASS="item UI_Zittingen_geagendeerd" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>plaats: <SPAN CLASS="item UI_Zittingen_plaats" ID="'+id+'.3"></SPAN></DIV>'
             + '<DIV>locatie: <SPAN CLASS="item UI_Zittingen_locatie" ID="'+id+'.4"></SPAN></DIV>'
             + '<DIV>kamer: <SPAN CLASS="item UI_Zittingen_kamer" ID="'+id+'.5"><DIV>gerecht: <SPAN CLASS="item UI_Zittingen_kamer_gerecht" ID="'+id+'.50"></SPAN></DIV><DIV>sectorSector: <SPAN CLASS="item UI_Zittingen_kamer_sectorSector" ID="'+id+'.51"></SPAN></DIV></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater ontvangen">
      <DIV class="FloaterHeader">ontvangen</DIV>
      <DIV class="FloaterContent"><?php
          $ontvangen = $Rechterlijkeambtenaar->get_ontvangen();
          echo '
          <UL>';
          foreach($ontvangen as $i0=>$v0){
            echo '
            <LI CLASS="item UI_ontvangen" ID="4.'.$i0.'">';
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
                echo 'bericht: ';
                echo '<SPAN CLASS="item UI_ontvangen_bericht" ID="4.'.$i0.'.0">';
                echo htmlspecialchars($v0['bericht']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'van: ';
                echo '<SPAN CLASS="item UI_ontvangen_van" ID="4.'.$i0.'.1">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To4.'.$i0.'.1">';
                  echo htmlspecialchars($v0['van']).'</A>';
                  echo '<DIV class="Goto" id="GoTo4.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="Rechterlijke ambtenaar.php?Rechterlijkeambtenaar='.urlencode($v0['van']).'">Rechterlijke ambtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['van']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['van']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['van']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'verzonden: ';
                echo '<SPAN CLASS="item UI_ontvangen_verzonden" ID="4.'.$i0.'.2">';
                echo htmlspecialchars($v0['verzonden']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'ontvangen: ';
                echo '<SPAN CLASS="item UI_ontvangen_ontvangen" ID="4.'.$i0.'.3">';
                echo htmlspecialchars($v0['ontvangen']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="4.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_ontvangen" ID="4.'.count($ontvangen).'">new ontvangen</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in ontvangen
      function UI_ontvangen(id){
        return '<DIV>bericht: <SPAN CLASS="item UI_ontvangen_bericht" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>van: <SPAN CLASS="item UI_ontvangen_van" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>verzonden: <SPAN CLASS="item UI_ontvangen_verzonden" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>ontvangen: <SPAN CLASS="item UI_ontvangen_ontvangen" ID="'+id+'.3"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater verzonden">
      <DIV class="FloaterHeader">verzonden</DIV>
      <DIV class="FloaterContent"><?php
          $verzonden = $Rechterlijkeambtenaar->get_verzonden();
          echo '
          <UL>';
          foreach($verzonden as $i0=>$v0){
            echo '
            <LI CLASS="item UI_verzonden" ID="5.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To5.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo5.'.$i0.'"><UL>';
                echo '<LI><A HREF="Brief.php?Brief='.urlencode($v0['id']).'">Brief</A></LI>';
                echo '<LI><A HREF="Betaling.php?Betaling='.urlencode($v0['id']).'">Betaling</A></LI>';
                echo '<LI><A HREF="Document.php?Document='.urlencode($v0['id']).'">Document</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'bericht: ';
                echo '<SPAN CLASS="item UI_verzonden_bericht" ID="5.'.$i0.'.0">';
                echo htmlspecialchars($v0['bericht']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'van: ';
                echo '<SPAN CLASS="item UI_verzonden_van" ID="5.'.$i0.'.1">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To5.'.$i0.'.1">';
                  echo htmlspecialchars($v0['van']).'</A>';
                  echo '<DIV class="Goto" id="GoTo5.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="Rechterlijke ambtenaar.php?Rechterlijkeambtenaar='.urlencode($v0['van']).'">Rechterlijke ambtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['van']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['van']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['van']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'verzonden: ';
                echo '<SPAN CLASS="item UI_verzonden_verzonden" ID="5.'.$i0.'.2">';
                echo htmlspecialchars($v0['verzonden']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="5.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_verzonden" ID="5.'.count($verzonden).'">new verzonden</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in verzonden
      function UI_verzonden(id){
        return '<DIV>bericht: <SPAN CLASS="item UI_verzonden_bericht" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>van: <SPAN CLASS="item UI_verzonden_van" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>verzonden: <SPAN CLASS="item UI_verzonden_verzonden" ID="'+id+'.2"></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Rechterlijkeambtenaar->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Rechterlijkeambtenaar=".urlencode($Rechterlijkeambtenaar->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Rechterlijkeambtenaar=".urlencode($Rechterlijkeambtenaar->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Rechterlijkeambtenaar=".urlencode($Rechterlijkeambtenaar->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Rechterlijke ambtenaar is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Rechterlijke ambtenaar object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Rechterlijke ambtenaar object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>