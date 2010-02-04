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
  require "Orgaan.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Handelingendoorditorgaan=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Handelingendoorditorgaan[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                                            , 'handeling' => @$r['0.'.$i0.'.0']
                                            );
      $Handelingendoorditorgaan[$i0]['prio']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $Handelingendoorditorgaan[$i0]['prio'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
      $Handelingendoorditorgaan[$i0]['usecase']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $Handelingendoorditorgaan[$i0]['usecase'][$i1] = @$r['0.'.$i0.'.2.'.$i1.''];
      }
      $Handelingendoorditorgaan[$i0]['rol']=array();
      for($i1=0;isset($r['0.'.$i0.'.3.'.$i1]);$i1++){
        $Handelingendoorditorgaan[$i0]['rol'][$i1] = @$r['0.'.$i0.'.3.'.$i1.''];
      }
    }
    $Acties=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $Acties[$i0] = array( 'id' => @$r['1.'.$i0.'.0']
                          , 'actie' => @$r['1.'.$i0.'.0']
                          , 'subject' => @$r['1.'.$i0.'.1']
                          , 'type' => @$r['1.'.$i0.'.2']
                          );
    }
    $Dossiers=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $Dossiers[$i0] = array( 'id' => @$r['2.'.$i0.'.0']
                            , 'procedure' => @$r['2.'.$i0.'.0']
                            , 'rechtsgebied' => @$r['2.'.$i0.'.1']
                            , 'proceduresoort' => @$r['2.'.$i0.'.2']
                            );
    }
    $Orgaan=new Orgaan($ID,$Handelingendoorditorgaan, $Acties, $Dossiers);
    if($Orgaan->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Orgaan='.urlencode($Orgaan->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Orgaan'])){
    if(!$del || !delOrgaan($_REQUEST['Orgaan']))
      $Orgaan = readOrgaan($_REQUEST['Orgaan']);
    else $Orgaan = false; // delete was a succes!
  } else if($new) $Orgaan = new Orgaan();
  else $Orgaan = false;
  if($Orgaan){
    writeHead("<TITLE>Orgaan - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Orgaan->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Orgaan->getId()).'" /></P>';
    else echo '<H1>'.$Orgaan->getId().'</H1>';
    ?>
    <DIV class="Floater Handelingen door dit orgaan">
      <DIV class="FloaterHeader">Handelingen door dit orgaan</DIV>
      <DIV class="FloaterContent"><?php
          $Handelingendoorditorgaan = $Orgaan->get_Handelingendoorditorgaan();
          echo '
          <UL>';
          foreach($Handelingendoorditorgaan as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Handelingendoorditorgaan" ID="0.'.$i0.'">';
              echo '
              <DIV>';
                echo 'handeling: ';
                echo '<SPAN CLASS="item UI_Handelingendoorditorgaan_handeling" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['handeling']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'prio: ';
                echo '
                <UL>';
                foreach($v0['prio'] as $i1=>$prio){
                  echo '
                  <LI CLASS="item UI_Handelingendoorditorgaan_prio" ID="0.'.$i0.'.1.'.$i1.'">';
                    echo htmlspecialchars($prio);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Handelingendoorditorgaan_prio" ID="0.'.$i0.'.1.'.count($v0['prio']).'">new prio</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'usecase: ';
                echo '
                <UL>';
                foreach($v0['usecase'] as $i1=>$usecase){
                  echo '
                  <LI CLASS="item UI_Handelingendoorditorgaan_usecase" ID="0.'.$i0.'.2.'.$i1.'">';
                    echo htmlspecialchars($usecase);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Handelingendoorditorgaan_usecase" ID="0.'.$i0.'.2.'.count($v0['usecase']).'">new usecase</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'rol: ';
                echo '
                <UL>';
                foreach($v0['rol'] as $i1=>$rol){
                  echo '
                  <LI CLASS="item UI_Handelingendoorditorgaan_rol" ID="0.'.$i0.'.3.'.$i1.'">';
                    echo htmlspecialchars($rol);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Handelingendoorditorgaan_rol" ID="0.'.$i0.'.3.'.count($v0['rol']).'">new rol</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Handelingendoorditorgaan" ID="0.'.count($Handelingendoorditorgaan).'">new Handelingen door dit orgaan</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Handelingen door dit orgaan
      function UI_Handelingendoorditorgaan(id){
        return '<DIV>handeling: <SPAN CLASS="item UI_Handelingendoorditorgaan_handeling" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>prio: <UL><LI CLASS="new UI_Handelingendoorditorgaan_prio" ID="'+id+'.1">new prio</LI></UL></DIV>'
             + '<DIV>usecase: <UL><LI CLASS="new UI_Handelingendoorditorgaan_usecase" ID="'+id+'.2">new usecase</LI></UL></DIV>'
             + '<DIV>rol: <UL><LI CLASS="new UI_Handelingendoorditorgaan_rol" ID="'+id+'.3">new rol</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater Acties">
      <DIV class="FloaterHeader">Acties</DIV>
      <DIV class="FloaterContent"><?php
          $Acties = $Orgaan->get_Acties();
          echo '
          <UL>';
          foreach($Acties as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Acties" ID="1.'.$i0.'">';
              echo '
              <DIV>';
                echo 'actie: ';
                echo '<SPAN CLASS="item UI_Acties_actie" ID="1.'.$i0.'.0">';
                echo htmlspecialchars($v0['actie']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'subject: ';
                echo '<SPAN CLASS="item UI_Acties_subject" ID="1.'.$i0.'.1">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To1.'.$i0.'.1">';
                  echo htmlspecialchars($v0['subject']).'</A>';
                  echo '<DIV class="Goto" id="GoTo1.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0['subject']).'">RechterlijkeAmbtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['subject']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['subject']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['subject']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type: ';
                echo '<SPAN CLASS="item UI_Acties_type" ID="1.'.$i0.'.2">';
                echo htmlspecialchars($v0['type']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Acties" ID="1.'.count($Acties).'">new Acties</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Acties
      function UI_Acties(id){
        return '<DIV>actie: <SPAN CLASS="item UI_Acties_actie" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>subject: <SPAN CLASS="item UI_Acties_subject" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>type: <SPAN CLASS="item UI_Acties_type" ID="'+id+'.2"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater Dossiers">
      <DIV class="FloaterHeader">Dossiers</DIV>
      <DIV class="FloaterContent"><?php
          $Dossiers = $Orgaan->get_Dossiers();
          echo '
          <UL>';
          foreach($Dossiers as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Dossiers" ID="2.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To2.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo2.'.$i0.'"><UL>';
                echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($v0['id']).'">BasisgegevensUC001</A></LI>';
                echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($v0['id']).'">Procedure</A></LI>';
                echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($v0['id']).'">nieuweProcedure</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'procedure: ';
                echo '<SPAN CLASS="item UI_Dossiers_procedure" ID="2.'.$i0.'.0">';
                echo htmlspecialchars($v0['procedure']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rechtsgebied: ';
                echo '<SPAN CLASS="item UI_Dossiers_rechtsgebied" ID="2.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Rechtsgebied.php?Rechtsgebied='.urlencode($v0['rechtsgebied']).'">'.htmlspecialchars($v0['rechtsgebied']).'</A>';
                else echo htmlspecialchars($v0['rechtsgebied']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'proceduresoort: ';
                echo '<SPAN CLASS="item UI_Dossiers_proceduresoort" ID="2.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="Proceduresoort.php?Proceduresoort='.urlencode($v0['proceduresoort']).'">'.htmlspecialchars($v0['proceduresoort']).'</A>';
                else echo htmlspecialchars($v0['proceduresoort']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="2.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Dossiers" ID="2.'.count($Dossiers).'">new Dossiers</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Dossiers
      function UI_Dossiers(id){
        return '<DIV>procedure: <SPAN CLASS="item UI_Dossiers_procedure" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>rechtsgebied: <SPAN CLASS="item UI_Dossiers_rechtsgebied" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>proceduresoort: <SPAN CLASS="item UI_Dossiers_proceduresoort" ID="'+id+'.2"></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Orgaan->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Orgaan=".urlencode($Orgaan->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Orgaan=".urlencode($Orgaan->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Orgaan=".urlencode($Orgaan->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Orgaan is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Orgaan object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Orgaan object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>