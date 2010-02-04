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
  require "Gerechtelijkeambtenaar.inc.php";
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
                       , 'gerechtGerecht' => @$r['0.'.$i0.'.1']
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
                             , 'griffierPersoon' => @$r['3.'.$i0.'.1']
                             , 'geagendeerdDatum' => @$r['3.'.$i0.'.2']
                             , 'plaatsPlaats' => @$r['3.'.$i0.'.3']
                             , 'locatieGerecht' => array( 'id' => @$r['3.'.$i0.'.4'], 'ressortGerechtshof' => @$r['3.'.$i0.'.4.0'], 'hoofdplaatsPlaats' => @$r['3.'.$i0.'.4.1'])
                             , 'kamerKamer' => array( 'id' => @$r['3.'.$i0.'.5'], 'gerechtGerecht' => array( 'id' => @$r['3.'.$i0.'.5.0'], 'ressortGerechtshof' => @$r['3.'.$i0.'.5.0.0'], 'hoofdplaatsPlaats' => @$r['3.'.$i0.'.5.0.1']), 'sectorSector' => @$r['3.'.$i0.'.5.1'])
                             );
      $Zittingen[$i0]['rechterPersoon']=array();
      for($i1=0;isset($r['3.'.$i0.'.0.'.$i1]);$i1++){
        $Zittingen[$i0]['rechterPersoon'][$i1] = @$r['3.'.$i0.'.0.'.$i1.''];
      }
    }
    $Actieofsubject=array();
    for($i0=0;isset($r['4.'.$i0]);$i0++){
      $Actieofsubject[$i0] = array( 'id' => @$r['4.'.$i0.'']
                                  , 'subjectPersoon' => @$r['4.'.$i0.'.0']
                                  , 'typeHandeling' => @$r['4.'.$i0.'.1']
                                  );
    }
    $ontvangen=array();
    for($i0=0;isset($r['5.'.$i0]);$i0++){
      $ontvangen[$i0] = array( 'id' => @$r['5.'.$i0.'.0']
                             , 'bericht' => @$r['5.'.$i0.'.0']
                             , 'van' => @$r['5.'.$i0.'.1']
                             , 'verzonden' => @$r['5.'.$i0.'.2']
                             , 'ontvangen' => @$r['5.'.$i0.'.3']
                             );
    }
    $verzonden=array();
    for($i0=0;isset($r['6.'.$i0]);$i0++){
      $verzonden[$i0] = array( 'id' => @$r['6.'.$i0.'.0']
                             , 'bericht' => @$r['6.'.$i0.'.0']
                             , 'van' => @$r['6.'.$i0.'.1']
                             , 'verzonden' => @$r['6.'.$i0.'.2']
                             );
    }
    $Gerechtelijkeambtenaar=new Gerechtelijkeambtenaar($ID,$lid, $rol, $geautoriseerdvoor, $Zittingen, $Actieofsubject, $ontvangen, $verzonden);
    if($Gerechtelijkeambtenaar->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Gerechtelijkeambtenaar='.urlencode($Gerechtelijkeambtenaar->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Gerechtelijkeambtenaar'])){
    if(!$del || !delGerechtelijkeambtenaar($_REQUEST['Gerechtelijkeambtenaar']))
      $Gerechtelijkeambtenaar = readGerechtelijkeambtenaar($_REQUEST['Gerechtelijkeambtenaar']);
    else $Gerechtelijkeambtenaar = false; // delete was a succes!
  } else if($new) $Gerechtelijkeambtenaar = new Gerechtelijkeambtenaar();
  else $Gerechtelijkeambtenaar = false;
  if($Gerechtelijkeambtenaar){
    writeHead("<TITLE>Gerechtelijkeambtenaar - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Gerechtelijkeambtenaar->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Gerechtelijkeambtenaar->getId()).'" /></P>';
    else echo '<H1>'.$Gerechtelijkeambtenaar->getId().'</H1>';
    ?>
    <DIV class="Floater lid">
      <DIV class="FloaterHeader">lid</DIV>
      <DIV class="FloaterContent"><?php
          $lid = $Gerechtelijkeambtenaar->get_lid();
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
                echo 'gerechtGerecht: ';
                echo '<SPAN CLASS="item UI_lid_gerechtGerecht" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Gerecht.php?Gerecht='.urlencode($v0['gerechtGerecht']).'">'.htmlspecialchars($v0['gerechtGerecht']).'</A>';
                else echo htmlspecialchars($v0['gerechtGerecht']);
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
             + '<DIV>gerechtGerecht: <SPAN CLASS="item UI_lid_gerechtGerecht" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>sectorSector: <SPAN CLASS="item UI_lid_sectorSector" ID="'+id+'.2"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater rol">
      <DIV class="FloaterHeader">rol</DIV>
      <DIV class="FloaterContent"><?php
          $rol = $Gerechtelijkeambtenaar->get_rol();
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
    <DIV class="Floater geautoriseerd voor">
      <DIV class="FloaterHeader">geautoriseerd voor</DIV>
      <DIV class="FloaterContent"><?php
          $geautoriseerdvoor = $Gerechtelijkeambtenaar->get_geautoriseerdvoor();
          echo '
          <UL>';
          foreach($geautoriseerdvoor as $i0=>$v0){
            echo '
            <LI CLASS="item UI_geautoriseerdvoor" ID="2.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Rol.php?Rol='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
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
          $Zittingen = $Gerechtelijkeambtenaar->get_Zittingen();
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
                echo 'rechterPersoon: ';
                echo '
                <UL>';
                foreach($v0['rechterPersoon'] as $i1=>$rechterPersoon){
                  echo '
                  <LI CLASS="item UI_Zittingen_rechterPersoon" ID="3.'.$i0.'.0.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To3.'.$i0.'.0.'.$i1.'">';
                      echo htmlspecialchars($rechterPersoon).'</A>';
                      echo '<DIV class="Goto" id="GoTo3.'.$i0.'.0.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($rechterPersoon).'">Gerechtelijkeambtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($rechterPersoon).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($rechterPersoon).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($rechterPersoon);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Zittingen_rechterPersoon" ID="3.'.$i0.'.0.'.count($v0['rechterPersoon']).'">new rechterPersoon</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'griffierPersoon: ';
                echo '<SPAN CLASS="item UI_Zittingen_griffierPersoon" ID="3.'.$i0.'.1">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To3.'.$i0.'.1">';
                  echo htmlspecialchars($v0['griffierPersoon']).'</A>';
                  echo '<DIV class="Goto" id="GoTo3.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0['griffierPersoon']).'">Gerechtelijkeambtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['griffierPersoon']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['griffierPersoon']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['griffierPersoon']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'geagendeerdDatum: ';
                echo '<SPAN CLASS="item UI_Zittingen_geagendeerdDatum" ID="3.'.$i0.'.2">';
                echo htmlspecialchars($v0['geagendeerdDatum']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'plaatsPlaats: ';
                echo '<SPAN CLASS="item UI_Zittingen_plaatsPlaats" ID="3.'.$i0.'.3">';
                if(!$edit) echo '
                <A HREF="Plaats.php?Plaats='.urlencode($v0['plaatsPlaats']).'">'.htmlspecialchars($v0['plaatsPlaats']).'</A>';
                else echo htmlspecialchars($v0['plaatsPlaats']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                ?> 
                <DIV class ="Holder"><DIV class="HolderHeader">locatieGerecht</DIV>
                  <DIV class="HolderContent" name="locatieGerecht"><?php
                      echo '<DIV CLASS="UI_Zittingen_locatieGerecht" ID="3.'.$i0.'.4">';
                        if(!$edit){
                          echo '
                        <A HREF="Gerecht.php?Gerecht='.urlencode($v0['locatieGerecht']['id']).'">';
                          echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
                        }
                        echo '
                        <DIV>';
                          echo 'ressortGerechtshof: ';
                          echo '<SPAN CLASS="item UI_Zittingen_locatieGerecht_ressortGerechtshof" ID="3.'.$i0.'.4.0">';
                          echo htmlspecialchars($v0['locatieGerecht']['ressortGerechtshof']);
                          echo '</SPAN>';
                        echo '</DIV>
                        <DIV>';
                          echo 'hoofdplaatsPlaats: ';
                          echo '<SPAN CLASS="item UI_Zittingen_locatieGerecht_hoofdplaatsPlaats" ID="3.'.$i0.'.4.1">';
                          if(!$edit) echo '
                          <A HREF="Plaats.php?Plaats='.urlencode($v0['locatieGerecht']['hoofdplaatsPlaats']).'">'.htmlspecialchars($v0['locatieGerecht']['hoofdplaatsPlaats']).'</A>';
                          else echo htmlspecialchars($v0['locatieGerecht']['hoofdplaatsPlaats']);
                          echo '</SPAN>';
                        echo '
                        </DIV>';
                        if($edit) echo '
                        <INPUT TYPE="hidden" name="3.'.$i0.'.4.ID" VALUE="'.$v0['locatieGerecht']['id'].'" />';
                      echo '</DIV>';
                    ?> 
                  </DIV>
                </DIV>
                <?php
              echo '</DIV>
              <DIV>';
                ?> 
                <DIV class ="Holder"><DIV class="HolderHeader">kamerKamer</DIV>
                  <DIV class="HolderContent" name="kamerKamer"><?php
                      echo '<DIV CLASS="UI_Zittingen_kamerKamer" ID="3.'.$i0.'.5">';
                        if(!$edit){
                          echo '
                        <A HREF="Kamer.php?Kamer='.urlencode($v0['kamerKamer']['id']).'">';
                          echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
                        }
                        echo '
                        <DIV>';
                          ?> 
                          <DIV class ="Holder"><DIV class="HolderHeader">gerechtGerecht</DIV>
                            <DIV class="HolderContent" name="gerechtGerecht"><?php
                                echo '<DIV CLASS="UI_Zittingen_kamerKamer_gerechtGerecht" ID="3.'.$i0.'.5.0">';
                                  if(!$edit){
                                    echo '
                                  <A HREF="Gerecht.php?Gerecht='.urlencode($v0['kamerKamer']['gerechtGerecht']['id']).'">';
                                    echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
                                  }
                                  echo '
                                  <DIV>';
                                    echo 'ressortGerechtshof: ';
                                    echo '<SPAN CLASS="item UI_Zittingen_kamerKamer_gerechtGerecht_ressortGerechtshof" ID="3.'.$i0.'.5.0.0">';
                                    echo htmlspecialchars($v0['kamerKamer']['gerechtGerecht']['ressortGerechtshof']);
                                    echo '</SPAN>';
                                  echo '</DIV>
                                  <DIV>';
                                    echo 'hoofdplaatsPlaats: ';
                                    echo '<SPAN CLASS="item UI_Zittingen_kamerKamer_gerechtGerecht_hoofdplaatsPlaats" ID="3.'.$i0.'.5.0.1">';
                                    if(!$edit) echo '
                                    <A HREF="Plaats.php?Plaats='.urlencode($v0['kamerKamer']['gerechtGerecht']['hoofdplaatsPlaats']).'">'.htmlspecialchars($v0['kamerKamer']['gerechtGerecht']['hoofdplaatsPlaats']).'</A>';
                                    else echo htmlspecialchars($v0['kamerKamer']['gerechtGerecht']['hoofdplaatsPlaats']);
                                    echo '</SPAN>';
                                  echo '
                                  </DIV>';
                                  if($edit) echo '
                                  <INPUT TYPE="hidden" name="3.'.$i0.'.5.0.ID" VALUE="'.$v0['kamerKamer']['gerechtGerecht']['id'].'" />';
                                echo '</DIV>';
                              ?> 
                            </DIV>
                          </DIV>
                          <?php
                        echo '</DIV>
                        <DIV>';
                          echo 'sectorSector: ';
                          echo '<SPAN CLASS="item UI_Zittingen_kamerKamer_sectorSector" ID="3.'.$i0.'.5.1">';
                          if(!$edit) echo '
                          <A HREF="Sector.php?Sector='.urlencode($v0['kamerKamer']['sectorSector']).'">'.htmlspecialchars($v0['kamerKamer']['sectorSector']).'</A>';
                          else echo htmlspecialchars($v0['kamerKamer']['sectorSector']);
                          echo '</SPAN>';
                        echo '
                        </DIV>';
                        if($edit) echo '
                        <INPUT TYPE="hidden" name="3.'.$i0.'.5.ID" VALUE="'.$v0['kamerKamer']['id'].'" />';
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
        return '<DIV>rechterPersoon: <UL><LI CLASS="new UI_Zittingen_rechterPersoon" ID="'+id+'.0">new rechterPersoon</LI></UL></DIV>'
             + '<DIV>griffierPersoon: <SPAN CLASS="item UI_Zittingen_griffierPersoon" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>geagendeerdDatum: <SPAN CLASS="item UI_Zittingen_geagendeerdDatum" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>plaatsPlaats: <SPAN CLASS="item UI_Zittingen_plaatsPlaats" ID="'+id+'.3"></SPAN></DIV>'
             + '<DIV>locatieGerecht: <SPAN CLASS="item UI_Zittingen_locatieGerecht" ID="'+id+'.4"><DIV>ressortGerechtshof: <SPAN CLASS="item UI_Zittingen_locatieGerecht_ressortGerechtshof" ID="'+id+'.40"></SPAN></DIV><DIV>hoofdplaatsPlaats: <SPAN CLASS="item UI_Zittingen_locatieGerecht_hoofdplaatsPlaats" ID="'+id+'.41"></SPAN></DIV></SPAN></DIV>'
             + '<DIV>kamerKamer: <SPAN CLASS="item UI_Zittingen_kamerKamer" ID="'+id+'.5"><DIV>gerechtGerecht: <SPAN CLASS="item UI_Zittingen_kamerKamer_gerechtGerecht" ID="'+id+'.50"><DIV>ressortGerechtshof: <SPAN CLASS="item UI_Zittingen_kamerKamer_gerechtGerecht_ressortGerechtshof" ID="'+id+'.500"></SPAN></DIV><DIV>hoofdplaatsPlaats: <SPAN CLASS="item UI_Zittingen_kamerKamer_gerechtGerecht_hoofdplaatsPlaats" ID="'+id+'.501"></SPAN></DIV></SPAN></DIV><DIV>sectorSector: <SPAN CLASS="item UI_Zittingen_kamerKamer_sectorSector" ID="'+id+'.51"></SPAN></DIV></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater Actie_of_subject">
      <DIV class="FloaterHeader">Actie_of_subject</DIV>
      <DIV class="FloaterContent"><?php
          $Actieofsubject = $Gerechtelijkeambtenaar->get_Actieofsubject();
          echo '
          <UL>';
          foreach($Actieofsubject as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Actieofsubject" ID="4.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Actie.php?Actie='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'subjectPersoon: ';
                echo '<SPAN CLASS="item UI_Actieofsubject_subjectPersoon" ID="4.'.$i0.'.0">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To4.'.$i0.'.0">';
                  echo htmlspecialchars($v0['subjectPersoon']).'</A>';
                  echo '<DIV class="Goto" id="GoTo4.'.$i0.'.0"><UL>';
                  echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0['subjectPersoon']).'">Gerechtelijkeambtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['subjectPersoon']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['subjectPersoon']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['subjectPersoon']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'typeHandeling: ';
                echo '<SPAN CLASS="item UI_Actieofsubject_typeHandeling" ID="4.'.$i0.'.1">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To4.'.$i0.'.1">';
                  echo htmlspecialchars($v0['typeHandeling']).'</A>';
                  echo '<DIV class="Goto" id="GoTo4.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="HandelingCompact.php?HandelingCompact='.urlencode($v0['typeHandeling']).'">HandelingCompact</A></LI>';
                  echo '<LI><A HREF="Handeling.php?Handeling='.urlencode($v0['typeHandeling']).'">Handeling</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['typeHandeling']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="4.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Actieofsubject" ID="4.'.count($Actieofsubject).'">new Actie_of_subject</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Actie_of_subject
      function UI_Actieofsubject(id){
        return '<DIV>subjectPersoon: <SPAN CLASS="item UI_Actieofsubject_subjectPersoon" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>typeHandeling: <SPAN CLASS="item UI_Actieofsubject_typeHandeling" ID="'+id+'.1"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater ontvangen">
      <DIV class="FloaterHeader">ontvangen</DIV>
      <DIV class="FloaterContent"><?php
          $ontvangen = $Gerechtelijkeambtenaar->get_ontvangen();
          echo '
          <UL>';
          foreach($ontvangen as $i0=>$v0){
            echo '
            <LI CLASS="item UI_ontvangen" ID="5.'.$i0.'">';
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
                echo '<SPAN CLASS="item UI_ontvangen_bericht" ID="5.'.$i0.'.0">';
                echo htmlspecialchars($v0['bericht']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'van: ';
                echo '<SPAN CLASS="item UI_ontvangen_van" ID="5.'.$i0.'.1">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To5.'.$i0.'.1">';
                  echo htmlspecialchars($v0['van']).'</A>';
                  echo '<DIV class="Goto" id="GoTo5.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0['van']).'">Gerechtelijkeambtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['van']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['van']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['van']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'verzonden: ';
                echo '<SPAN CLASS="item UI_ontvangen_verzonden" ID="5.'.$i0.'.2">';
                echo htmlspecialchars($v0['verzonden']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'ontvangen: ';
                echo '<SPAN CLASS="item UI_ontvangen_ontvangen" ID="5.'.$i0.'.3">';
                echo htmlspecialchars($v0['ontvangen']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="5.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_ontvangen" ID="5.'.count($ontvangen).'">new ontvangen</LI>';
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
          $verzonden = $Gerechtelijkeambtenaar->get_verzonden();
          echo '
          <UL>';
          foreach($verzonden as $i0=>$v0){
            echo '
            <LI CLASS="item UI_verzonden" ID="6.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To6.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo6.'.$i0.'"><UL>';
                echo '<LI><A HREF="Brief.php?Brief='.urlencode($v0['id']).'">Brief</A></LI>';
                echo '<LI><A HREF="Betaling.php?Betaling='.urlencode($v0['id']).'">Betaling</A></LI>';
                echo '<LI><A HREF="Document.php?Document='.urlencode($v0['id']).'">Document</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'bericht: ';
                echo '<SPAN CLASS="item UI_verzonden_bericht" ID="6.'.$i0.'.0">';
                echo htmlspecialchars($v0['bericht']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'van: ';
                echo '<SPAN CLASS="item UI_verzonden_van" ID="6.'.$i0.'.1">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To6.'.$i0.'.1">';
                  echo htmlspecialchars($v0['van']).'</A>';
                  echo '<DIV class="Goto" id="GoTo6.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0['van']).'">Gerechtelijkeambtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['van']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['van']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['van']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'verzonden: ';
                echo '<SPAN CLASS="item UI_verzonden_verzonden" ID="6.'.$i0.'.2">';
                echo htmlspecialchars($v0['verzonden']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="6.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_verzonden" ID="6.'.count($verzonden).'">new verzonden</LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Gerechtelijkeambtenaar->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Gerechtelijkeambtenaar=".urlencode($Gerechtelijkeambtenaar->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Gerechtelijkeambtenaar=".urlencode($Gerechtelijkeambtenaar->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Gerechtelijkeambtenaar=".urlencode($Gerechtelijkeambtenaar->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Gerechtelijkeambtenaar is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Gerechtelijkeambtenaar object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Gerechtelijkeambtenaar object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>