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
  require "RechterlijkeAmbtenaren.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Rechters=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Rechters[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                            , 'naam' => @$r['0.'.$i0.'.0']
                            );
      $Rechters[$i0]['gerecht']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $Rechters[$i0]['gerecht'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
      $Rechters[$i0]['rol']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $Rechters[$i0]['rol'][$i1] = @$r['0.'.$i0.'.2.'.$i1.''];
      }
    }
    $Griffiers=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $Griffiers[$i0] = array( 'id' => @$r['1.'.$i0.'.0']
                             , 'naam' => @$r['1.'.$i0.'.0']
                             );
      $Griffiers[$i0]['gerecht']=array();
      for($i1=0;isset($r['1.'.$i0.'.1.'.$i1]);$i1++){
        $Griffiers[$i0]['gerecht'][$i1] = @$r['1.'.$i0.'.1.'.$i1.''];
      }
      $Griffiers[$i0]['rol']=array();
      for($i1=0;isset($r['1.'.$i0.'.2.'.$i1]);$i1++){
        $Griffiers[$i0]['rol'][$i1] = @$r['1.'.$i0.'.2.'.$i1.''];
      }
    }
    $RechterlijkeAmbtenaren=new RechterlijkeAmbtenaren($Rechters, $Griffiers);
    if($RechterlijkeAmbtenaren->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $RechterlijkeAmbtenaren=new RechterlijkeAmbtenaren();
    writeHead("<TITLE>RechterlijkeAmbtenaren - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>RechterlijkeAmbtenaren</H1>
    <DIV class="Floater Rechters">
      <DIV class="FloaterHeader">Rechters</DIV>
      <DIV class="FloaterContent"><?php
          $Rechters = $RechterlijkeAmbtenaren->get_Rechters();
          echo '
          <UL>';
          foreach($Rechters as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Rechters" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To0.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0['id']).'">RechterlijkeAmbtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['id']).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['id']).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'naam: ';
                echo '<SPAN CLASS="item UI_Rechters_naam" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['naam']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gerecht: ';
                echo '
                <UL>';
                foreach($v0['gerecht'] as $i1=>$gerecht){
                  echo '
                  <LI CLASS="item UI_Rechters_gerecht" ID="0.'.$i0.'.1.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Gerecht.php?Gerecht='.urlencode($gerecht).'">'.htmlspecialchars($gerecht).'</A>';
                    else echo htmlspecialchars($gerecht);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Rechters_gerecht" ID="0.'.$i0.'.1.'.count($v0['gerecht']).'">new gerecht</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'rol: ';
                echo '
                <UL>';
                foreach($v0['rol'] as $i1=>$rol){
                  echo '
                  <LI CLASS="item UI_Rechters_rol" ID="0.'.$i0.'.2.'.$i1.'">';
                    echo htmlspecialchars($rol);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Rechters_rol" ID="0.'.$i0.'.2.'.count($v0['rol']).'">new rol</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Rechters" ID="0.'.count($Rechters).'">new Rechters</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Rechters
      function UI_Rechters(id){
        return '<DIV>naam: <SPAN CLASS="item UI_Rechters_naam" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>gerecht: <UL><LI CLASS="new UI_Rechters_gerecht" ID="'+id+'.1">new gerecht</LI></UL></DIV>'
             + '<DIV>rol: <UL><LI CLASS="new UI_Rechters_rol" ID="'+id+'.2">new rol</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater Griffiers">
      <DIV class="FloaterHeader">Griffiers</DIV>
      <DIV class="FloaterContent"><?php
          $Griffiers = $RechterlijkeAmbtenaren->get_Griffiers();
          echo '
          <UL>';
          foreach($Griffiers as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Griffiers" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To1.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0['id']).'">RechterlijkeAmbtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['id']).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['id']).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'naam: ';
                echo '<SPAN CLASS="item UI_Griffiers_naam" ID="1.'.$i0.'.0">';
                echo htmlspecialchars($v0['naam']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gerecht: ';
                echo '
                <UL>';
                foreach($v0['gerecht'] as $i1=>$gerecht){
                  echo '
                  <LI CLASS="item UI_Griffiers_gerecht" ID="1.'.$i0.'.1.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Gerecht.php?Gerecht='.urlencode($gerecht).'">'.htmlspecialchars($gerecht).'</A>';
                    else echo htmlspecialchars($gerecht);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Griffiers_gerecht" ID="1.'.$i0.'.1.'.count($v0['gerecht']).'">new gerecht</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'rol: ';
                echo '
                <UL>';
                foreach($v0['rol'] as $i1=>$rol){
                  echo '
                  <LI CLASS="item UI_Griffiers_rol" ID="1.'.$i0.'.2.'.$i1.'">';
                    echo htmlspecialchars($rol);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Griffiers_rol" ID="1.'.$i0.'.2.'.count($v0['rol']).'">new rol</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Griffiers" ID="1.'.count($Griffiers).'">new Griffiers</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Griffiers
      function UI_Griffiers(id){
        return '<DIV>naam: <SPAN CLASS="item UI_Griffiers_naam" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>gerecht: <UL><LI CLASS="new UI_Griffiers_gerecht" ID="'+id+'.1">new gerecht</LI></UL></DIV>'
             + '<DIV>rol: <UL><LI CLASS="new UI_Griffiers_rol" ID="'+id+'.2">new rol</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
    if($edit) echo '</FORM>';
  if(!$edit) $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1","Edit");
  else
    $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1');","Save")
             .ifaceButton($_SERVER['PHP_SELF'],"Cancel");
  writeTail($buttons);
?>