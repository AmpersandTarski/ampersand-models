<?php // generated with ADL vs. 0.8.10-515
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
  require "Rule3.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $propertyofrelation = @$r['0'];
    $violations=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $violations[$i0] = @$r['1.'.$i0.''];
    }
    $explanation = @$r['2'];
    $Rule3=new Rule3($ID,$propertyofrelation, $violations, $explanation);
    if($Rule3->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Rule3='.urlencode($Rule3->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Rule3'])){
    if(!$del || !delRule3($_REQUEST['Rule3']))
      $Rule3 = readRule3($_REQUEST['Rule3']);
    else $Rule3 = false; // delete was a succes!
  } else if($new) $Rule3 = new Rule3();
  else $Rule3 = false;
  if($Rule3){
    writeHead("<TITLE>Rule3 - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Rule3->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Rule3->getId()).'" /></P>';
    else echo '<H1>'.display('HomogeneousRule','display',$Rule3->getId()).'</H1>';
    ?>
    <DIV class="Floater property of relation">
      <DIV class="FloaterHeader">property of relation</DIV>
      <DIV class="FloaterContent"><?php
          $propertyofrelation = $Rule3->get_propertyofrelation();
          echo '<SPAN CLASS="item UI_propertyofrelation" ID="0">';
            $displaypropertyofrelation=display('Relation','display',$propertyofrelation);
          if(!$edit){
            echo '
          <A class="GotoLink" id="To0">';
            echo htmlspecialchars($displaypropertyofrelation).'</A>';
            echo '<DIV class="Goto" id="GoTo0"><UL>';
            echo '<LI><A HREF="'.serviceref('RelationDetails', array('RelationDetails'=>urlencode($propertyofrelation))).'">RelationDetails</A></LI>';
            echo '<LI><A HREF="'.serviceref('Population', array('Population'=>urlencode($propertyofrelation))).'">Population</A></LI>';
            echo '</UL></DIV>';
          } else echo htmlspecialchars($displaypropertyofrelation);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater violations">
      <DIV class="FloaterHeader">violations</DIV>
      <DIV class="FloaterContent"><?php
          $violations = $Rule3->get_violations();
          echo '
          <UL>';
          foreach($violations as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_violations" ID="1.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_violations" ID="1.'.count($violations).'">new violations</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater explanation">
      <DIV class="FloaterHeader">explanation</DIV>
      <DIV class="FloaterContent"><?php
          $explanation = $Rule3->get_explanation();
          echo '<SPAN CLASS="item UI_explanation" ID="2">';
            $explanation=$explanation;
          echo htmlspecialchars($explanation);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Rule3->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Rule3'=>urlencode($Rule3->getId()) )),"Cancel");
     } 
  } else $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Rule3'=>urlencode($Rule3->getId()),'edit'=>1)),"Edit")
                 .ifaceButton(serviceref($_REQUEST['content'], array('Rule3'=>urlencode($Rule3->getId()),'del'=>1)),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Rule3 is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Rule3 object selected - Atlas - ADL Prototype</TITLE>");
      ?><i>No Rule3 object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>