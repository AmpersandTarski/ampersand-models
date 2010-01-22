<?php // generated with ADL vs. 0.8.10-558
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
  require "Violations.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $violatedrules=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $violatedrules[$i0] = array( 'id' => @$r['0.'.$i0.'']
                                 );
      $violatedrules[$i0]['is violated by']=array();
      for($i1=0;isset($r['0.'.$i0.'.0.'.$i1]);$i1++){
        $violatedrules[$i0]['is violated by'][$i1] = @$r['0.'.$i0.'.0.'.$i1.''];
      }
    }
    $propertyviolationson=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $propertyviolationson[$i0] = array( 'id' => @$r['1.'.$i0.'']
                                        );
      $propertyviolationson[$i0]['is violated by']=array();
      for($i1=0;isset($r['1.'.$i0.'.0.'.$i1]);$i1++){
        $propertyviolationson[$i0]['is violated by'][$i1] = @$r['1.'.$i0.'.0.'.$i1.''];
      }
    }
    $Violations=new Violations($violatedrules, $propertyviolationson);
    if($Violations->save()!==false) die('ok:'.serviceref($_REQUEST['content'])); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Violations=new Violations();
    writeHead("<TITLE>Violations - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Violations</H1>
    <DIV class="Floater violated_rules">
      <DIV class="FloaterHeader">violated_rules</DIV>
      <DIV class="FloaterContent"><?php
          $violatedrules = $Violations->get_violatedrules();
          echo '
          <UL>';
          foreach($violatedrules as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_violatedrules" ID="0.'.$i0.'">';
            echo display('UserRule','display',$idv0['id']);
              if(!$edit){
                echo '
              <A HREF="'.serviceref('UserRule', array('UserRule'=>urlencode($idv0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'is violated by: ';
                echo '
                <UL>';
                foreach($v0['is violated by'] as $i1=>$idisviolatedby){
                  $isviolatedby=$idisviolatedby;
                  echo '
                  <LI CLASS="item UI_violatedrules" ID="0.'.$i0.'.0.'.$i1.'">';
                
                    echo htmlspecialchars($isviolatedby);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_violatedrules" ID="0.'.$i0.'.0.'.count($v0['is violated by']).'">new is violated by</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_violatedrules" ID="0.'.count($violatedrules).'">new violated_rules</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in violated_rules
      function UI_violatedrules(id){
        return '<DIV>is violated by: <UL><LI CLASS="new UI_violatedrules_isviolatedby" ID="'+id+'.0">new is violated by</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater property_violations_on">
      <DIV class="FloaterHeader">property_violations_on</DIV>
      <DIV class="FloaterContent"><?php
          $propertyviolationson = $Violations->get_propertyviolationson();
          echo '
          <UL>';
          foreach($propertyviolationson as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_propertyviolationson" ID="1.'.$i0.'">';
            echo display('Relation','display',$idv0['id']);
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To1.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="'.serviceref('RelationDetails', array('RelationDetails'=>urlencode($idv0['id']))).'">RelationDetails</A></LI>';
                echo '<LI><A HREF="'.serviceref('Population', array('Population'=>urlencode($idv0['id']))).'">Population</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'is violated by: ';
                echo '
                <UL>';
                foreach($v0['is violated by'] as $i1=>$idisviolatedby){
                  $isviolatedby=$idisviolatedby;
                  echo '
                  <LI CLASS="item UI_propertyviolationson" ID="1.'.$i0.'.0.'.$i1.'">';
                
                    echo htmlspecialchars($isviolatedby);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_propertyviolationson" ID="1.'.$i0.'.0.'.count($v0['is violated by']).'">new is violated by</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_propertyviolationson" ID="1.'.count($propertyviolationson).'">new property_violations_on</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in property_violations_on
      function UI_propertyviolationson(id){
        return '<DIV>is violated by: <UL><LI CLASS="new UI_propertyviolationson_isviolatedby" ID="'+id+'.0">new is violated by</LI></UL></DIV>'
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