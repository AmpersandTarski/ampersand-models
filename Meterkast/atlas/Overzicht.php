<?php // generated with ADL vs. 0.8.10-556
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
    $Patterns=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Patterns[$i0] = array( 'id' => @$r['0.'.$i0.'']
                            );
      $Patterns[$i0]['violated_rules']=array();
      for($i1=0;isset($r['0.'.$i0.'.0.'.$i1]);$i1++){
        $Patterns[$i0]['violated_rules'][$i1] = @$r['0.'.$i0.'.0.'.$i1.''];
      }
      $Patterns[$i0]['property_violations_on']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $Patterns[$i0]['property_violations_on'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
    }
    $Conceptualdiagram=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $Conceptualdiagram[$i0] = @$r['1.'.$i0.''];
    }
    $Overzicht=new Overzicht($Patterns, $Conceptualdiagram);
    if($Overzicht->save()!==false) die('ok:'.serviceref($_REQUEST['content'])); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Overzicht=new Overzicht();
    writeHead("<TITLE>Overzicht - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Overzicht</H1>
    <DIV class="Floater Patterns">
      <DIV class="FloaterHeader">Patterns</DIV>
      <DIV class="FloaterContent"><?php
          $Patterns = $Overzicht->get_Patterns();
          echo '
          <UL>';
          foreach($Patterns as $i0=>$idv0){
            $v0=$idv0;
            echo display('Pattern','display',$idv0['id']);
            echo '
            <LI CLASS="item UI_Patterns" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="'.serviceref('Pattern', array('Pattern'=>urlencode($idv0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'violated_rules: ';
                echo '
                <UL>';
                foreach($v0['violated_rules'] as $i1=>$idviolatedrules){
                  $violatedrules=display('UserRule','display',$idviolatedrules);
                
                  echo '
                  <LI CLASS="item UI_Patterns_violatedrules" ID="0.'.$i0.'.0.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="'.serviceref('UserRule', array('UserRule'=>urlencode($idviolatedrules))).'">'.htmlspecialchars($violatedrules).'</A>';
                    else echo htmlspecialchars($violatedrules);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Patterns_violatedrules" ID="0.'.$i0.'.0.'.count($v0['violated_rules']).'">new violated_rules</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'property_violations_on: ';
                echo '
                <UL>';
                foreach($v0['property_violations_on'] as $i1=>$idpropertyviolationson){
                  $propertyviolationson=display('Relation','display',$idpropertyviolationson);
                
                  echo '
                  <LI CLASS="item UI_Patterns_propertyviolationson" ID="0.'.$i0.'.1.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.1.'.$i1.'">';
                      echo htmlspecialchars($propertyviolationson).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.1.'.$i1.'"><UL>';
                      echo '<LI><A HREF="'.serviceref('RelationDetails', array('RelationDetails'=>urlencode($idpropertyviolationson))).'">RelationDetails</A></LI>';
                      echo '<LI><A HREF="'.serviceref('Population', array('Population'=>urlencode($idpropertyviolationson))).'">Population</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($propertyviolationson);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Patterns_propertyviolationson" ID="0.'.$i0.'.1.'.count($v0['property_violations_on']).'">new property_violations_on</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Patterns" ID="0.'.count($Patterns).'">new Patterns</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Patterns
      function UI_Patterns(id){
        return '<DIV>violated_rules: <UL><LI CLASS="new UI_Patterns_violatedrules" ID="'+id+'.0">new violated_rules</LI></UL></DIV>'
             + '<DIV>property_violations_on: <UL><LI CLASS="new UI_Patterns_propertyviolationson" ID="'+id+'.1">new property_violations_on</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
          $Conceptualdiagram = $Overzicht->get_Conceptualdiagram();
          foreach($Conceptualdiagram as $i0=>$v0){
            echo '<IMG src="'.$v0.'"/>';
          }
        ?> 
    <?php
    if($edit) echo '</FORM>';
  if(!$edit) $buttons.=ifaceButton(serviceref($_REQUEST['content'])."&edit=1","Edit");
  else
    $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1');","Save")
             .ifaceButton(serviceref($_REQUEST['content']),"Cancel");
  writeTail($buttons);
?>