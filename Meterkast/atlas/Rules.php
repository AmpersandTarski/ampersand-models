<?php // generated with ADL vs. 0.8.10-490
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
  require "Rules.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Conceptualdiagram=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Conceptualdiagram[$i0] = @$r['0.'.$i0.''];
    }
    $Userdefinedrules=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $Userdefinedrules[$i0] = array( 'id' => @$r['1.'.$i0.'']
                                    , 'rule' => @$r['1.'.$i0.'.0']
                                    , 'source' => @$r['1.'.$i0.'.1']
                                    , 'target' => @$r['1.'.$i0.'.2']
                                    );
      $Userdefinedrules[$i0]['violations']=array();
      for($i1=0;isset($r['1.'.$i0.'.3.'.$i1]);$i1++){
        $Userdefinedrules[$i0]['violations'][$i1] = @$r['1.'.$i0.'.3.'.$i1.''];
      }
    }
    $Multiplicities=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $Multiplicities[$i0] = array( 'id' => @$r['2.'.$i0.'']
                                  , 'property' => @$r['2.'.$i0.'.0']
                                  , 'source' => @$r['2.'.$i0.'.1']
                                  , 'on' => @$r['2.'.$i0.'.2']
                                  , 'rule' => @$r['2.'.$i0.'.3']
                                  );
      $Multiplicities[$i0]['violations']=array();
      for($i1=0;isset($r['2.'.$i0.'.4.'.$i1]);$i1++){
        $Multiplicities[$i0]['violations'][$i1] = @$r['2.'.$i0.'.4.'.$i1.''];
      }
    }
    $Homogeneousproperties=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $Homogeneousproperties[$i0] = array( 'id' => @$r['3.'.$i0.'']
                                         , 'property' => @$r['3.'.$i0.'.0']
                                         , 'on' => @$r['3.'.$i0.'.1']
                                         , 'rule' => @$r['3.'.$i0.'.2']
                                         );
      $Homogeneousproperties[$i0]['violations']=array();
      for($i1=0;isset($r['3.'.$i0.'.3.'.$i1]);$i1++){
        $Homogeneousproperties[$i0]['violations'][$i1] = @$r['3.'.$i0.'.3.'.$i1.''];
      }
    }
    $Rules=new Rules($Conceptualdiagram, $Userdefinedrules, $Multiplicities, $Homogeneousproperties);
    if($Rules->save()!==false) die('ok:'.serviceref($_REQUEST['content'])); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Rules=new Rules();
    writeHead("<TITLE>Rules - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Rules</H1>
    <?php
          $Conceptualdiagram = $Rules->get_Conceptualdiagram();
          foreach($Conceptualdiagram as $i0=>$v0){
            echo '<IMG src="'.$v0.'"/>';
          }
        ?> 
    <DIV class="Floater User-defined rules">
      <DIV class="FloaterHeader">User-defined rules</DIV>
      <DIV class="FloaterContent"><?php
          $Userdefinedrules = $Rules->get_Userdefinedrules();
          echo '
          <UL>';
          foreach($Userdefinedrules as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Userdefinedrules" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="'.serviceref('Rule1', array('Rule1'=>urlencode($v0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'rule: ';
                echo '<SPAN CLASS="item UI_Userdefinedrules_rule" ID="1.'.$i0.'.0">';
                echo htmlspecialchars($v0['rule']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'source: ';
                echo '<SPAN CLASS="item UI_Userdefinedrules_source" ID="1.'.$i0.'.1">';
                echo htmlspecialchars($v0['source']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'target: ';
                echo '<SPAN CLASS="item UI_Userdefinedrules_target" ID="1.'.$i0.'.2">';
                echo htmlspecialchars($v0['target']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'violations: ';
                echo '
                <UL>';
                foreach($v0['violations'] as $i1=>$violations){
                  echo '
                  <LI CLASS="item UI_Userdefinedrules_violations" ID="1.'.$i0.'.3.'.$i1.'">';
                    echo htmlspecialchars($violations);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Userdefinedrules_violations" ID="1.'.$i0.'.3.'.count($v0['violations']).'">new violations</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Userdefinedrules" ID="1.'.count($Userdefinedrules).'">new User-defined rules</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in User-defined rules
      function UI_Userdefinedrules(id){
        return '<DIV>rule: <SPAN CLASS="item UI_Userdefinedrules_rule" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>source: <SPAN CLASS="item UI_Userdefinedrules_source" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>target: <SPAN CLASS="item UI_Userdefinedrules_target" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>violations: <UL><LI CLASS="new UI_Userdefinedrules_violations" ID="'+id+'.3">new violations</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater Multiplicities">
      <DIV class="FloaterHeader">Multiplicities</DIV>
      <DIV class="FloaterContent"><?php
          $Multiplicities = $Rules->get_Multiplicities();
          echo '
          <UL>';
          foreach($Multiplicities as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Multiplicities" ID="2.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="'.serviceref('Rule2', array('Rule2'=>urlencode($v0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'property: ';
                echo '<SPAN CLASS="item UI_Multiplicities_property" ID="2.'.$i0.'.0">';
                echo htmlspecialchars($v0['property']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'source: ';
                echo '<SPAN CLASS="item UI_Multiplicities_source" ID="2.'.$i0.'.1">';
                echo htmlspecialchars($v0['source']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'on: ';
                echo '<SPAN CLASS="item UI_Multiplicities_on" ID="2.'.$i0.'.2">';
                echo htmlspecialchars($v0['on']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rule: ';
                echo '<SPAN CLASS="item UI_Multiplicities_rule" ID="2.'.$i0.'.3">';
                echo htmlspecialchars($v0['rule']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'violations: ';
                echo '
                <UL>';
                foreach($v0['violations'] as $i1=>$violations){
                  echo '
                  <LI CLASS="item UI_Multiplicities_violations" ID="2.'.$i0.'.4.'.$i1.'">';
                    echo htmlspecialchars($violations);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Multiplicities_violations" ID="2.'.$i0.'.4.'.count($v0['violations']).'">new violations</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="2.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Multiplicities" ID="2.'.count($Multiplicities).'">new Multiplicities</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Multiplicities
      function UI_Multiplicities(id){
        return '<DIV>property: <SPAN CLASS="item UI_Multiplicities_property" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>source: <SPAN CLASS="item UI_Multiplicities_source" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>on: <SPAN CLASS="item UI_Multiplicities_on" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>rule: <SPAN CLASS="item UI_Multiplicities_rule" ID="'+id+'.3"></SPAN></DIV>'
             + '<DIV>violations: <UL><LI CLASS="new UI_Multiplicities_violations" ID="'+id+'.4">new violations</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater Homogeneous properties">
      <DIV class="FloaterHeader">Homogeneous properties</DIV>
      <DIV class="FloaterContent"><?php
          $Homogeneousproperties = $Rules->get_Homogeneousproperties();
          echo '
          <UL>';
          foreach($Homogeneousproperties as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Homogeneousproperties" ID="3.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="'.serviceref('Rule3', array('Rule3'=>urlencode($v0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'property: ';
                echo '<SPAN CLASS="item UI_Homogeneousproperties_property" ID="3.'.$i0.'.0">';
                echo htmlspecialchars($v0['property']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'on: ';
                echo '<SPAN CLASS="item UI_Homogeneousproperties_on" ID="3.'.$i0.'.1">';
                echo htmlspecialchars($v0['on']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rule: ';
                echo '<SPAN CLASS="item UI_Homogeneousproperties_rule" ID="3.'.$i0.'.2">';
                echo htmlspecialchars($v0['rule']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'violations: ';
                echo '
                <UL>';
                foreach($v0['violations'] as $i1=>$violations){
                  echo '
                  <LI CLASS="item UI_Homogeneousproperties_violations" ID="3.'.$i0.'.3.'.$i1.'">';
                    echo htmlspecialchars($violations);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Homogeneousproperties_violations" ID="3.'.$i0.'.3.'.count($v0['violations']).'">new violations</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="3.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Homogeneousproperties" ID="3.'.count($Homogeneousproperties).'">new Homogeneous properties</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Homogeneous properties
      function UI_Homogeneousproperties(id){
        return '<DIV>property: <SPAN CLASS="item UI_Homogeneousproperties_property" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>on: <SPAN CLASS="item UI_Homogeneousproperties_on" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>rule: <SPAN CLASS="item UI_Homogeneousproperties_rule" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>violations: <UL><LI CLASS="new UI_Homogeneousproperties_violations" ID="'+id+'.3">new violations</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
    if($edit) echo '</FORM>';
  if(!$edit) $buttons.=ifaceButton(serviceref($_REQUEST['content'])."&edit=1","Edit");
  else
    $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1');","Save")
             .ifaceButton(serviceref($_REQUEST['content']),"Cancel");
  writeTail($buttons);
?>