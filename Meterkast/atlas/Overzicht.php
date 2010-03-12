<?php // generated with ADL vs. 1.1-632
/**********************\
*                      *
*   Interface V1.3.1   *
*                      *
*                      *
*   Using interfaceDef *
*                      *
\**********************/
  error_reporting(E_ALL); 
  ini_set("display_errors", 1);
  require "interfaceDef.inc.php";
  require "Overzicht.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Patternlijst=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Patternlijst[$i0] = array( 'id' => @$r['0.'.$i0.'']
                                );
      $Patternlijst[$i0]['Dit pattern heeft regelovertredingen op de regel(s)']=array();
      for($i1=0;isset($r['0.'.$i0.'.0.'.$i1]);$i1++){
        $Patternlijst[$i0]['Dit pattern heeft regelovertredingen op de regel(s)'][$i1] = @$r['0.'.$i0.'.0.'.$i1.''];
      }
      $Patternlijst[$i0]['Dit pattern heeft overtredingen op eigenschap(pen) van relatie(s)']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $Patternlijst[$i0]['Dit pattern heeft overtredingen op eigenschap(pen) van relatie(s)'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
    }
    $Overzicht=new Overzicht($Patternlijst);
    if($Overzicht->save()!==false) die('ok:'.serviceref($_REQUEST['content'])); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Overzicht=new Overzicht();
    writeHead("<TITLE>Overzicht - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Overzicht</H1>
    <DIV class="Floater Patternlijst">
      <DIV class="FloaterHeader">Patternlijst</DIV>
      <DIV class="FloaterContent"><?php
          $Patternlijst = $Overzicht->get_Patternlijst();
          echo '
          <UL>';
          foreach($Patternlijst as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
            echo display('Pattern','display',$idv0['id']);
              if(!$edit){
                echo '
              <A HREF="'.serviceref('Pattern', array('Pattern'=>urlencode($idv0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'Dit pattern heeft regelovertredingen op de regel(s): ';
                echo '
                <UL>';
                foreach($v0['Dit pattern heeft regelovertredingen op de regel(s)'] as $i1=>$idDitpatternheeftregelovertredingenopderegels){
                  $Ditpatternheeftregelovertredingenopderegels=display('UserRule','display',$idDitpatternheeftregelovertredingenopderegels);
                  echo '
                  <LI CLASS="item UIDitpatternheeftregelovertredingenopderegels" ID="0.'.$i0.'.0.'.$i1.'">';
                
                    if(!$edit) echo '
                    <A HREF="'.serviceref('UserRule', array('UserRule'=>urlencode($idDitpatternheeftregelovertredingenopderegels))).'">'.htmlspecialchars($Ditpatternheeftregelovertredingenopderegels).'</A>';
                    else echo htmlspecialchars($Ditpatternheeftregelovertredingenopderegels);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIDitpatternheeftregelovertredingenopderegels" ID="0.'.$i0.'.0.'.count($v0['Dit pattern heeft regelovertredingen op de regel(s)']).'">new Dit pattern heeft regelovertredingen op de regel(s)</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'Dit pattern heeft overtredingen op eigenschap(pen) van relatie(s): ';
                echo '
                <UL>';
                foreach($v0['Dit pattern heeft overtredingen op eigenschap(pen) van relatie(s)'] as $i1=>$idDitpatternheeftovertredingenopeigenschappenvanrelaties){
                  $Ditpatternheeftovertredingenopeigenschappenvanrelaties=display('Relation','display',$idDitpatternheeftovertredingenopeigenschappenvanrelaties);
                  echo '
                  <LI CLASS="item UIDitpatternheeftovertredingenopeigenschappenvanrelaties" ID="0.'.$i0.'.1.'.$i1.'">';
                
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.1.'.$i1.'">';
                      echo htmlspecialchars($Ditpatternheeftovertredingenopeigenschappenvanrelaties).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.1.'.$i1.'"><UL>';
                      echo '<LI><A HREF="'.serviceref('Relatiedetails', array('Relatiedetails'=>urlencode($idDitpatternheeftovertredingenopeigenschappenvanrelaties))).'">Relatiedetails</A></LI>';
                      echo '<LI><A HREF="'.serviceref('Populatie', array('Populatie'=>urlencode($idDitpatternheeftovertredingenopeigenschappenvanrelaties))).'">Populatie</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($Ditpatternheeftovertredingenopeigenschappenvanrelaties);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIDitpatternheeftovertredingenopeigenschappenvanrelaties" ID="0.'.$i0.'.1.'.count($v0['Dit pattern heeft overtredingen op eigenschap(pen) van relatie(s)']).'">new Dit pattern heeft overtredingen op eigenschap(pen) van relatie(s)</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Patternlijst).'">new Patternlijst</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Patternlijst
      function UI(id){
        return '<DIV>Dit pattern heeft regelovertredingen op de regel(s): <UL><LI CLASS="new UI_Ditpatternheeftregelovertredingenopderegels" ID="'+id+'.0">new Dit pattern heeft regelovertredingen op de regel(s)</LI></UL></DIV>'
             + '<DIV>Dit pattern heeft overtredingen op eigenschap(pen) van relatie(s): <UL><LI CLASS="new UI_Ditpatternheeftovertredingenopeigenschappenvanrelaties" ID="'+id+'.1">new Dit pattern heeft overtredingen op eigenschap(pen) van relatie(s)</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
    if($edit) echo '</FORM>';
  if(!$edit) $buttons=$buttons;
  else
    $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1');","Save")
             .ifaceButton(serviceref($_REQUEST['content']),"Cancel");
  writeTail($buttons);
?>