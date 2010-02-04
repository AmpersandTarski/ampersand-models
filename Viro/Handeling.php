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
  require "Handeling.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $door=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $door[$i0] = @$r['0.'.$i0.''];
    }
    $objectObjecttype=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $objectObjecttype[$i0] = @$r['1.'.$i0.''];
    }
    $werkwoord=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $werkwoord[$i0] = @$r['2.'.$i0.''];
    }
    $usecase=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $usecase[$i0] = array( 'id' => @$r['3.'.$i0.'']
                           , 'omschrijving' => @$r['3.'.$i0.'.0']
                           , 'categorie' => @$r['3.'.$i0.'.4']
                           , 'opmerkingen' => @$r['3.'.$i0.'.5']
                           , 'formuliercodes' => @$r['3.'.$i0.'.6']
                           , 'bron' => @$r['3.'.$i0.'.7']
                           , 'MoSCoW' => @$r['3.'.$i0.'.8']
                           , 'Component' => @$r['3.'.$i0.'.9']
                           );
      $usecase[$i0]['super']=array();
      for($i1=0;isset($r['3.'.$i0.'.1.'.$i1]);$i1++){
        $usecase[$i0]['super'][$i1] = @$r['3.'.$i0.'.1.'.$i1.''];
      }
      $usecase[$i0]['sub']=array();
      for($i1=0;isset($r['3.'.$i0.'.2.'.$i1]);$i1++){
        $usecase[$i0]['sub'][$i1] = @$r['3.'.$i0.'.2.'.$i1.''];
      }
      $usecase[$i0]['fase']=array();
      for($i1=0;isset($r['3.'.$i0.'.3.'.$i1]);$i1++){
        $usecase[$i0]['fase'][$i1] = @$r['3.'.$i0.'.3.'.$i1.''];
      }
    }
    $rol=array();
    for($i0=0;isset($r['4.'.$i0]);$i0++){
      $rol[$i0] = @$r['4.'.$i0.''];
    }
    $grondslag=array();
    for($i0=0;isset($r['5.'.$i0]);$i0++){
      $grondslag[$i0] = array( 'id' => @$r['5.'.$i0.'.0']
                             , 'artikel' => @$r['5.'.$i0.'.0']
                             );
      $grondslag[$i0]['tekst']=array();
      for($i1=0;isset($r['5.'.$i0.'.1.'.$i1]);$i1++){
        $grondslag[$i0]['tekst'][$i1] = @$r['5.'.$i0.'.1.'.$i1.''];
      }
    }
    $geregistreerdeacties=array();
    for($i0=0;isset($r['6.'.$i0]);$i0++){
      $geregistreerdeacties[$i0] = array( 'id' => @$r['6.'.$i0.'.0']
                                        , 'Actie' => @$r['6.'.$i0.'.0']
                                        , 'door' => @$r['6.'.$i0.'.1']
                                        , 'type' => @$r['6.'.$i0.'.2']
                                        );
    }
    $Handeling=new Handeling($ID,$door, $objectObjecttype, $werkwoord, $usecase, $rol, $grondslag, $geregistreerdeacties);
    if($Handeling->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Handeling='.urlencode($Handeling->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Handeling'])){
    if(!$del || !delHandeling($_REQUEST['Handeling']))
      $Handeling = readHandeling($_REQUEST['Handeling']);
    else $Handeling = false; // delete was a succes!
  } else if($new) $Handeling = new Handeling();
  else $Handeling = false;
  if($Handeling){
    writeHead("<TITLE>Handeling - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Handeling->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Handeling->getId()).'" /></P>';
    else echo '<H1>'.$Handeling->getId().'</H1>';
    ?>
    <DIV class="Floater door">
      <DIV class="FloaterHeader">door</DIV>
      <DIV class="FloaterContent"><?php
          $door = $Handeling->get_door();
          echo '
          <UL>';
          foreach($door as $i0=>$v0){
            echo '
            <LI CLASS="item UI_door" ID="0.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Orgaan.php?Orgaan='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_door" ID="0.'.count($door).'">new door</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater object Objecttype">
      <DIV class="FloaterHeader">object Objecttype</DIV>
      <DIV class="FloaterContent"><?php
          $objectObjecttype = $Handeling->get_objectObjecttype();
          echo '
          <UL>';
          foreach($objectObjecttype as $i0=>$v0){
            echo '
            <LI CLASS="item UI_objectObjecttype" ID="1.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Objecttype.php?Objecttype='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_objectObjecttype" ID="1.'.count($objectObjecttype).'">new object Objecttype</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater werkwoord">
      <DIV class="FloaterHeader">werkwoord</DIV>
      <DIV class="FloaterContent"><?php
          $werkwoord = $Handeling->get_werkwoord();
          echo '
          <UL>';
          foreach($werkwoord as $i0=>$v0){
            echo '
            <LI CLASS="item UI_werkwoord" ID="2.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Werkwoord.php?Werkwoord='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_werkwoord" ID="2.'.count($werkwoord).'">new werkwoord</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater usecase">
      <DIV class="FloaterHeader">usecase</DIV>
      <DIV class="FloaterContent"><?php
          $usecase = $Handeling->get_usecase();
          echo '
          <UL>';
          foreach($usecase as $i0=>$v0){
            echo '
            <LI CLASS="item UI_usecase" ID="3.'.$i0.'">';
              echo '
              <DIV>';
                echo 'omschrijving: ';
                echo '<SPAN CLASS="item UI_usecase_omschrijving" ID="3.'.$i0.'.0">';
                if(isset($v0['omschrijving'])){
                  echo htmlspecialchars($v0['omschrijving']);
                }
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'super: ';
                echo '
                <UL>';
                foreach($v0['super'] as $i1=>$super){
                  echo '
                  <LI CLASS="item UI_usecase_super" ID="3.'.$i0.'.1.'.$i1.'">';
                    echo htmlspecialchars($super);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_usecase_super" ID="3.'.$i0.'.1.'.count($v0['super']).'">new super</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'sub: ';
                echo '
                <UL>';
                foreach($v0['sub'] as $i1=>$sub){
                  echo '
                  <LI CLASS="item UI_usecase_sub" ID="3.'.$i0.'.2.'.$i1.'">';
                    echo htmlspecialchars($sub);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_usecase_sub" ID="3.'.$i0.'.2.'.count($v0['sub']).'">new sub</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'fase: ';
                echo '
                <UL>';
                foreach($v0['fase'] as $i1=>$fase){
                  echo '
                  <LI CLASS="item UI_usecase_fase" ID="3.'.$i0.'.3.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Fase.php?Fase='.urlencode($fase).'">'.htmlspecialchars($fase).'</A>';
                    else echo htmlspecialchars($fase);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_usecase_fase" ID="3.'.$i0.'.3.'.count($v0['fase']).'">new fase</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'categorie: ';
                echo '<SPAN CLASS="item UI_usecase_categorie" ID="3.'.$i0.'.4">';
                if(isset($v0['categorie'])){
                  if(!$edit) echo '
                  <A HREF="Gpstap.php?Gpstap='.urlencode($v0['categorie']).'">'.htmlspecialchars($v0['categorie']).'</A>';
                  else echo htmlspecialchars($v0['categorie']);
                }
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'opmerkingen: ';
                echo '<SPAN CLASS="item UI_usecase_opmerkingen" ID="3.'.$i0.'.5">';
                if(isset($v0['opmerkingen'])){
                  echo htmlspecialchars($v0['opmerkingen']);
                }
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'formuliercodes: ';
                echo '<SPAN CLASS="item UI_usecase_formuliercodes" ID="3.'.$i0.'.6">';
                if(isset($v0['formuliercodes'])){
                  if(!$edit) echo '
                  <A HREF="FormCodes.php?FormCodes='.urlencode($v0['formuliercodes']).'">'.htmlspecialchars($v0['formuliercodes']).'</A>';
                  else echo htmlspecialchars($v0['formuliercodes']);
                }
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'bron: ';
                echo '<SPAN CLASS="item UI_usecase_bron" ID="3.'.$i0.'.7">';
                if(isset($v0['bron'])){
                  if(!$edit) echo '
                  <A HREF="Referentie.php?Referentie='.urlencode($v0['bron']).'">'.htmlspecialchars($v0['bron']).'</A>';
                  else echo htmlspecialchars($v0['bron']);
                }
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'MoSCoW: ';
                echo '<SPAN CLASS="item UI_usecase_MoSCoW" ID="3.'.$i0.'.8">';
                if(isset($v0['MoSCoW'])){
                  if(!$edit) echo '
                  <A HREF="Moscow.php?Moscow='.urlencode($v0['MoSCoW']).'">'.htmlspecialchars($v0['MoSCoW']).'</A>';
                  else echo htmlspecialchars($v0['MoSCoW']);
                }
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'Component: ';
                echo '<SPAN CLASS="item UI_usecase_Component" ID="3.'.$i0.'.9">';
                if(isset($v0['Component'])){
                  if(!$edit) echo '
                  <A HREF="Component.php?Component='.urlencode($v0['Component']).'">'.htmlspecialchars($v0['Component']).'</A>';
                  else echo htmlspecialchars($v0['Component']);
                }
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="3.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_usecase" ID="3.'.count($usecase).'">new usecase</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in usecase
      function UI_usecase(id){
        return '<DIV>omschrijving: <DIV CLASS="new UI_usecase_omschrijving" ID="'+id+'.0"><I>Nothing</I></DIV></DIV>'
             + '<DIV>super: <UL><LI CLASS="new UI_usecase_super" ID="'+id+'.1">new super</LI></UL></DIV>'
             + '<DIV>sub: <UL><LI CLASS="new UI_usecase_sub" ID="'+id+'.2">new sub</LI></UL></DIV>'
             + '<DIV>fase: <UL><LI CLASS="new UI_usecase_fase" ID="'+id+'.3">new fase</LI></UL></DIV>'
             + '<DIV>categorie: <DIV CLASS="new UI_usecase_categorie" ID="'+id+'.4"><I>Nothing</I></DIV></DIV>'
             + '<DIV>opmerkingen: <DIV CLASS="new UI_usecase_opmerkingen" ID="'+id+'.5"><I>Nothing</I></DIV></DIV>'
             + '<DIV>formuliercodes: <DIV CLASS="new UI_usecase_formuliercodes" ID="'+id+'.6"><I>Nothing</I></DIV></DIV>'
             + '<DIV>bron: <DIV CLASS="new UI_usecase_bron" ID="'+id+'.7"><I>Nothing</I></DIV></DIV>'
             + '<DIV>MoSCoW: <DIV CLASS="new UI_usecase_MoSCoW" ID="'+id+'.8"><I>Nothing</I></DIV></DIV>'
             + '<DIV>Component: <DIV CLASS="new UI_usecase_Component" ID="'+id+'.9"><I>Nothing</I></DIV></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater rol">
      <DIV class="FloaterHeader">rol</DIV>
      <DIV class="FloaterContent"><?php
          $rol = $Handeling->get_rol();
          echo '
          <UL>';
          foreach($rol as $i0=>$v0){
            echo '
            <LI CLASS="item UI_rol" ID="4.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Rol.php?Rol='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_rol" ID="4.'.count($rol).'">new rol</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater grondslag">
      <DIV class="FloaterHeader">grondslag</DIV>
      <DIV class="FloaterContent"><?php
          $grondslag = $Handeling->get_grondslag();
          echo '
          <UL>';
          foreach($grondslag as $i0=>$v0){
            echo '
            <LI CLASS="item UI_grondslag" ID="5.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Artikel.php?Artikel='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'artikel: ';
                echo '<SPAN CLASS="item UI_grondslag_artikel" ID="5.'.$i0.'.0">';
                echo htmlspecialchars($v0['artikel']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'tekst: ';
                echo '
                <UL>';
                foreach($v0['tekst'] as $i1=>$tekst){
                  echo '
                  <LI CLASS="item UI_grondslag_tekst" ID="5.'.$i0.'.1.'.$i1.'">';
                    echo htmlspecialchars($tekst);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_grondslag_tekst" ID="5.'.$i0.'.1.'.count($v0['tekst']).'">new tekst</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="5.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_grondslag" ID="5.'.count($grondslag).'">new grondslag</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in grondslag
      function UI_grondslag(id){
        return '<DIV>artikel: <SPAN CLASS="item UI_grondslag_artikel" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>tekst: <UL><LI CLASS="new UI_grondslag_tekst" ID="'+id+'.1">new tekst</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater geregistreerde acties">
      <DIV class="FloaterHeader">geregistreerde acties</DIV>
      <DIV class="FloaterContent"><?php
          $geregistreerdeacties = $Handeling->get_geregistreerdeacties();
          echo '
          <UL>';
          foreach($geregistreerdeacties as $i0=>$v0){
            echo '
            <LI CLASS="item UI_geregistreerdeacties" ID="6.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Actie.php?Actie='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'Actie: ';
                echo '<SPAN CLASS="item UI_geregistreerdeacties_Actie" ID="6.'.$i0.'.0">';
                echo htmlspecialchars($v0['Actie']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'door: ';
                echo '<SPAN CLASS="item UI_geregistreerdeacties_door" ID="6.'.$i0.'.1">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To6.'.$i0.'.1">';
                  echo htmlspecialchars($v0['door']).'</A>';
                  echo '<DIV class="Goto" id="GoTo6.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0['door']).'">Gerechtelijkeambtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['door']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['door']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['door']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type: ';
                echo '<SPAN CLASS="item UI_geregistreerdeacties_type" ID="6.'.$i0.'.2">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To6.'.$i0.'.2">';
                  echo htmlspecialchars($v0['type']).'</A>';
                  echo '<DIV class="Goto" id="GoTo6.'.$i0.'.2"><UL>';
                  echo '<LI><A HREF="HandelingCompact.php?HandelingCompact='.urlencode($v0['type']).'">HandelingCompact</A></LI>';
                  echo '<LI><A HREF="Handeling.php?Handeling='.urlencode($v0['type']).'">Handeling</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['type']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="6.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_geregistreerdeacties" ID="6.'.count($geregistreerdeacties).'">new geregistreerde acties</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in geregistreerde acties
      function UI_geregistreerdeacties(id){
        return '<DIV>Actie: <SPAN CLASS="item UI_geregistreerdeacties_Actie" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>door: <SPAN CLASS="item UI_geregistreerdeacties_door" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>type: <SPAN CLASS="item UI_geregistreerdeacties_type" ID="'+id+'.2"></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Handeling->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Handeling=".urlencode($Handeling->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Handeling=".urlencode($Handeling->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Handeling=".urlencode($Handeling->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Handeling is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Handeling object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Handeling object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>