<?php // generated with ADL vs. 0.8.10-443
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
  require "Partij.inc.php";
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
      $eiser[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                         , 'Procedure' => @$r['0.'.$i0.'.0']
                         , 'rechtsgebied' => @$r['0.'.$i0.'.1']
                         , 'proceduresoort' => @$r['0.'.$i0.'.2']
                         );
      $eiser[$i0]['gerecht']=array();
      for($i1=0;isset($r['0.'.$i0.'.3.'.$i1]);$i1++){
        $eiser[$i0]['gerecht'][$i1] = @$r['0.'.$i0.'.3.'.$i1.''];
      }
      $eiser[$i0]['zitting']=array();
      for($i1=0;isset($r['0.'.$i0.'.4.'.$i1]);$i1++){
        $eiser[$i0]['zitting'][$i1] = @$r['0.'.$i0.'.4.'.$i1.''];
      }
    }
    $gedaagde=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $gedaagde[$i0] = array( 'id' => @$r['1.'.$i0.'.0']
                            , 'Procedure' => @$r['1.'.$i0.'.0']
                            , 'rechtsgebied' => @$r['1.'.$i0.'.1']
                            , 'proceduresoort' => @$r['1.'.$i0.'.2']
                            );
      $gedaagde[$i0]['gerecht']=array();
      for($i1=0;isset($r['1.'.$i0.'.3.'.$i1]);$i1++){
        $gedaagde[$i0]['gerecht'][$i1] = @$r['1.'.$i0.'.3.'.$i1.''];
      }
      $gedaagde[$i0]['zitting']=array();
      for($i1=0;isset($r['1.'.$i0.'.4.'.$i1]);$i1++){
        $gedaagde[$i0]['zitting'][$i1] = @$r['1.'.$i0.'.4.'.$i1.''];
      }
    }
    $gevoegde=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $gevoegde[$i0] = array( 'id' => @$r['2.'.$i0.'.0']
                            , 'Procedure' => @$r['2.'.$i0.'.0']
                            , 'rechtsgebied' => @$r['2.'.$i0.'.1']
                            , 'proceduresoort' => @$r['2.'.$i0.'.2']
                            );
      $gevoegde[$i0]['gerecht']=array();
      for($i1=0;isset($r['2.'.$i0.'.3.'.$i1]);$i1++){
        $gevoegde[$i0]['gerecht'][$i1] = @$r['2.'.$i0.'.3.'.$i1.''];
      }
      $gevoegde[$i0]['zitting']=array();
      for($i1=0;isset($r['2.'.$i0.'.4.'.$i1]);$i1++){
        $gevoegde[$i0]['zitting'][$i1] = @$r['2.'.$i0.'.4.'.$i1.''];
      }
    }
    $machtiging=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $machtiging[$i0] = array( 'id' => @$r['3.'.$i0.'.0']
                              , 'Machtiging' => @$r['3.'.$i0.'.0']
                              );
      $machtiging[$i0]['gemachtigde']=array();
      for($i1=0;isset($r['3.'.$i0.'.1.'.$i1]);$i1++){
        $machtiging[$i0]['gemachtigde'][$i1] = @$r['3.'.$i0.'.1.'.$i1.''];
      }
    }
    $Partij=new Partij($ID,$eiser, $gedaagde, $gevoegde, $machtiging);
    if($Partij->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Partij='.urlencode($Partij->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Partij'])){
    if(!$del || !delPartij($_REQUEST['Partij']))
      $Partij = readPartij($_REQUEST['Partij']);
    else $Partij = false; // delete was a succes!
  } else if($new) $Partij = new Partij();
  else $Partij = false;
  if($Partij){
    writeHead("<TITLE>Partij - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Partij->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Partij->getId()).'" /></P>';
    else echo '<H1>'.$Partij->getId().'</H1>';
    ?>
    <DIV class="Floater eiser">
      <DIV class="FloaterHeader">eiser</DIV>
      <DIV class="FloaterContent"><?php
          $eiser = $Partij->get_eiser();
          echo '
          <UL>';
          foreach($eiser as $i0=>$v0){
            echo '
            <LI CLASS="item UI_eiser" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To0.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($v0['id']).'">BasisgegevensUC001</A></LI>';
                echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($v0['id']).'">Procedure</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'Procedure: ';
                echo '<SPAN CLASS="item UI_eiser_Procedure" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['Procedure']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rechtsgebied: ';
                echo '<SPAN CLASS="item UI_eiser_rechtsgebied" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Rechtsgebied.php?Rechtsgebied='.urlencode($v0['rechtsgebied']).'">'.htmlspecialchars($v0['rechtsgebied']).'</A>';
                else echo htmlspecialchars($v0['rechtsgebied']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'proceduresoort: ';
                echo '<SPAN CLASS="item UI_eiser_proceduresoort" ID="0.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="Proceduresoort.php?Proceduresoort='.urlencode($v0['proceduresoort']).'">'.htmlspecialchars($v0['proceduresoort']).'</A>';
                else echo htmlspecialchars($v0['proceduresoort']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gerecht: ';
                echo '
                <UL>';
                foreach($v0['gerecht'] as $i1=>$gerecht){
                  echo '
                  <LI CLASS="item UI_eiser_gerecht" ID="0.'.$i0.'.3.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Gerecht.php?Gerecht='.urlencode($gerecht).'">'.htmlspecialchars($gerecht).'</A>';
                    else echo htmlspecialchars($gerecht);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_eiser_gerecht" ID="0.'.$i0.'.3.'.count($v0['gerecht']).'">new gerecht</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'zitting: ';
                echo '
                <UL>';
                foreach($v0['zitting'] as $i1=>$zitting){
                  echo '
                  <LI CLASS="item UI_eiser_zitting" ID="0.'.$i0.'.4.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Zitting.php?Zitting='.urlencode($zitting).'">'.htmlspecialchars($zitting).'</A>';
                    else echo htmlspecialchars($zitting);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_eiser_zitting" ID="0.'.$i0.'.4.'.count($v0['zitting']).'">new zitting</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_eiser" ID="0.'.count($eiser).'">new eiser</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in eiser
      function UI_eiser(id){
        return '<DIV>Procedure: <SPAN CLASS="item UI_eiser_Procedure" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>rechtsgebied: <SPAN CLASS="item UI_eiser_rechtsgebied" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>proceduresoort: <SPAN CLASS="item UI_eiser_proceduresoort" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>gerecht: <UL><LI CLASS="new UI_eiser_gerecht" ID="'+id+'.3">new gerecht</LI></UL></DIV>'
             + '<DIV>zitting: <UL><LI CLASS="new UI_eiser_zitting" ID="'+id+'.4">new zitting</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater gedaagde">
      <DIV class="FloaterHeader">gedaagde</DIV>
      <DIV class="FloaterContent"><?php
          $gedaagde = $Partij->get_gedaagde();
          echo '
          <UL>';
          foreach($gedaagde as $i0=>$v0){
            echo '
            <LI CLASS="item UI_gedaagde" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To1.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($v0['id']).'">BasisgegevensUC001</A></LI>';
                echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($v0['id']).'">Procedure</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'Procedure: ';
                echo '<SPAN CLASS="item UI_gedaagde_Procedure" ID="1.'.$i0.'.0">';
                echo htmlspecialchars($v0['Procedure']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rechtsgebied: ';
                echo '<SPAN CLASS="item UI_gedaagde_rechtsgebied" ID="1.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Rechtsgebied.php?Rechtsgebied='.urlencode($v0['rechtsgebied']).'">'.htmlspecialchars($v0['rechtsgebied']).'</A>';
                else echo htmlspecialchars($v0['rechtsgebied']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'proceduresoort: ';
                echo '<SPAN CLASS="item UI_gedaagde_proceduresoort" ID="1.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="Proceduresoort.php?Proceduresoort='.urlencode($v0['proceduresoort']).'">'.htmlspecialchars($v0['proceduresoort']).'</A>';
                else echo htmlspecialchars($v0['proceduresoort']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gerecht: ';
                echo '
                <UL>';
                foreach($v0['gerecht'] as $i1=>$gerecht){
                  echo '
                  <LI CLASS="item UI_gedaagde_gerecht" ID="1.'.$i0.'.3.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Gerecht.php?Gerecht='.urlencode($gerecht).'">'.htmlspecialchars($gerecht).'</A>';
                    else echo htmlspecialchars($gerecht);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_gedaagde_gerecht" ID="1.'.$i0.'.3.'.count($v0['gerecht']).'">new gerecht</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'zitting: ';
                echo '
                <UL>';
                foreach($v0['zitting'] as $i1=>$zitting){
                  echo '
                  <LI CLASS="item UI_gedaagde_zitting" ID="1.'.$i0.'.4.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Zitting.php?Zitting='.urlencode($zitting).'">'.htmlspecialchars($zitting).'</A>';
                    else echo htmlspecialchars($zitting);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_gedaagde_zitting" ID="1.'.$i0.'.4.'.count($v0['zitting']).'">new zitting</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_gedaagde" ID="1.'.count($gedaagde).'">new gedaagde</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in gedaagde
      function UI_gedaagde(id){
        return '<DIV>Procedure: <SPAN CLASS="item UI_gedaagde_Procedure" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>rechtsgebied: <SPAN CLASS="item UI_gedaagde_rechtsgebied" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>proceduresoort: <SPAN CLASS="item UI_gedaagde_proceduresoort" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>gerecht: <UL><LI CLASS="new UI_gedaagde_gerecht" ID="'+id+'.3">new gerecht</LI></UL></DIV>'
             + '<DIV>zitting: <UL><LI CLASS="new UI_gedaagde_zitting" ID="'+id+'.4">new zitting</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater gevoegde">
      <DIV class="FloaterHeader">gevoegde</DIV>
      <DIV class="FloaterContent"><?php
          $gevoegde = $Partij->get_gevoegde();
          echo '
          <UL>';
          foreach($gevoegde as $i0=>$v0){
            echo '
            <LI CLASS="item UI_gevoegde" ID="2.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To2.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo2.'.$i0.'"><UL>';
                echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($v0['id']).'">BasisgegevensUC001</A></LI>';
                echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($v0['id']).'">Procedure</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'Procedure: ';
                echo '<SPAN CLASS="item UI_gevoegde_Procedure" ID="2.'.$i0.'.0">';
                echo htmlspecialchars($v0['Procedure']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rechtsgebied: ';
                echo '<SPAN CLASS="item UI_gevoegde_rechtsgebied" ID="2.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Rechtsgebied.php?Rechtsgebied='.urlencode($v0['rechtsgebied']).'">'.htmlspecialchars($v0['rechtsgebied']).'</A>';
                else echo htmlspecialchars($v0['rechtsgebied']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'proceduresoort: ';
                echo '<SPAN CLASS="item UI_gevoegde_proceduresoort" ID="2.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="Proceduresoort.php?Proceduresoort='.urlencode($v0['proceduresoort']).'">'.htmlspecialchars($v0['proceduresoort']).'</A>';
                else echo htmlspecialchars($v0['proceduresoort']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gerecht: ';
                echo '
                <UL>';
                foreach($v0['gerecht'] as $i1=>$gerecht){
                  echo '
                  <LI CLASS="item UI_gevoegde_gerecht" ID="2.'.$i0.'.3.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Gerecht.php?Gerecht='.urlencode($gerecht).'">'.htmlspecialchars($gerecht).'</A>';
                    else echo htmlspecialchars($gerecht);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_gevoegde_gerecht" ID="2.'.$i0.'.3.'.count($v0['gerecht']).'">new gerecht</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'zitting: ';
                echo '
                <UL>';
                foreach($v0['zitting'] as $i1=>$zitting){
                  echo '
                  <LI CLASS="item UI_gevoegde_zitting" ID="2.'.$i0.'.4.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Zitting.php?Zitting='.urlencode($zitting).'">'.htmlspecialchars($zitting).'</A>';
                    else echo htmlspecialchars($zitting);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_gevoegde_zitting" ID="2.'.$i0.'.4.'.count($v0['zitting']).'">new zitting</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="2.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_gevoegde" ID="2.'.count($gevoegde).'">new gevoegde</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in gevoegde
      function UI_gevoegde(id){
        return '<DIV>Procedure: <SPAN CLASS="item UI_gevoegde_Procedure" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>rechtsgebied: <SPAN CLASS="item UI_gevoegde_rechtsgebied" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>proceduresoort: <SPAN CLASS="item UI_gevoegde_proceduresoort" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>gerecht: <UL><LI CLASS="new UI_gevoegde_gerecht" ID="'+id+'.3">new gerecht</LI></UL></DIV>'
             + '<DIV>zitting: <UL><LI CLASS="new UI_gevoegde_zitting" ID="'+id+'.4">new zitting</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater machtiging">
      <DIV class="FloaterHeader">machtiging</DIV>
      <DIV class="FloaterContent"><?php
          $machtiging = $Partij->get_machtiging();
          echo '
          <UL>';
          foreach($machtiging as $i0=>$v0){
            echo '
            <LI CLASS="item UI_machtiging" ID="3.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Machtiging.php?Machtiging='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'Machtiging: ';
                echo '<SPAN CLASS="item UI_machtiging_Machtiging" ID="3.'.$i0.'.0">';
                echo htmlspecialchars($v0['Machtiging']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gemachtigde: ';
                echo '
                <UL>';
                foreach($v0['gemachtigde'] as $i1=>$gemachtigde){
                  echo '
                  <LI CLASS="item UI_machtiging_gemachtigde" ID="3.'.$i0.'.1.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Persoon.php?Persoon='.urlencode($gemachtigde).'">'.htmlspecialchars($gemachtigde).'</A>';
                    else echo htmlspecialchars($gemachtigde);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_machtiging_gemachtigde" ID="3.'.$i0.'.1.'.count($v0['gemachtigde']).'">new gemachtigde</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="3.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_machtiging" ID="3.'.count($machtiging).'">new machtiging</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in machtiging
      function UI_machtiging(id){
        return '<DIV>Machtiging: <SPAN CLASS="item UI_machtiging_Machtiging" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>gemachtigde: <UL><LI CLASS="new UI_machtiging_gemachtigde" ID="'+id+'.1">new gemachtigde</LI></UL></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Partij->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Partij=".urlencode($Partij->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Partij=".urlencode($Partij->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Partij=".urlencode($Partij->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Partij is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Partij object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Partij object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>