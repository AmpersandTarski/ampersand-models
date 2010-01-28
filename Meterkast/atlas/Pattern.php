<?php // generated with ADL vs. 0.8.10-564
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
  require "Pattern.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $signals=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $signals[$i0] = @$r['0.'.$i0.''];
    }
    $rules=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $rules[$i0] = @$r['1.'.$i0.''];
    }
    $relations=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $relations[$i0] = @$r['2.'.$i0.''];
    }
    $isarelations=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $isarelations[$i0] = @$r['3.'.$i0.''];
    }
    $Conceptualdiagram = @$r['4'];
    $Pattern=new Pattern($ID,$signals, $rules, $relations, $isarelations, $Conceptualdiagram);
    if($Pattern->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Pattern='.urlencode($Pattern->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Pattern'])){
    if(!$del || !delPattern($_REQUEST['Pattern']))
      $Pattern = readPattern($_REQUEST['Pattern']);
    else $Pattern = false; // delete was a succes!
  } else if($new) $Pattern = new Pattern();
  else $Pattern = false;
  if($Pattern){
    writeHead("<TITLE>Pattern - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Pattern->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Pattern->getId()).'" /></P>';
    else echo '<H1>'.display('Pattern','display',$Pattern->getId()).'</H1>';
    ?>
    <DIV class="Floater signals">
      <DIV class="FloaterHeader">signals</DIV>
      <DIV class="FloaterContent"><?php
          $signals = $Pattern->get_signals();
          echo '
          <UL>';
          foreach($signals as $i0=>$idv0){
            $v0=display('Signal','display',$idv0);
            echo '
            <LI CLASS="item UI_signals" ID="0.'.$i0.'">';
          
              if(!$edit) echo '
              <A HREF="'.serviceref('Signal', array('Signal'=>urlencode($idv0))).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_signals" ID="0.'.count($signals).'">new signals</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater rules">
      <DIV class="FloaterHeader">rules</DIV>
      <DIV class="FloaterContent"><?php
          $rules = $Pattern->get_rules();
          echo '
          <UL>';
          foreach($rules as $i0=>$idv0){
            $v0=display('UserRule','display',$idv0);
            echo '
            <LI CLASS="item UI_rules" ID="1.'.$i0.'">';
          
              if(!$edit) echo '
              <A HREF="'.serviceref('UserRule', array('UserRule'=>urlencode($idv0))).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_rules" ID="1.'.count($rules).'">new rules</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater relations">
      <DIV class="FloaterHeader">relations</DIV>
      <DIV class="FloaterContent"><?php
          $relations = $Pattern->get_relations();
          echo '
          <UL>';
          foreach($relations as $i0=>$idv0){
            $v0=display('Relation','display',$idv0);
            echo '
            <LI CLASS="item UI_relations" ID="2.'.$i0.'">';
          
              if(!$edit){
                echo '
              <A class="GotoLink" id="To2.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo2.'.$i0.'"><UL>';
                echo '<LI><A HREF="'.serviceref('RelationDetails', array('RelationDetails'=>urlencode($idv0))).'">RelationDetails</A></LI>';
                echo '<LI><A HREF="'.serviceref('Population', array('Population'=>urlencode($idv0))).'">Population</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_relations" ID="2.'.count($relations).'">new relations</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater isa_relations">
      <DIV class="FloaterHeader">isa_relations</DIV>
      <DIV class="FloaterContent"><?php
          $isarelations = $Pattern->get_isarelations();
          echo '
          <UL>';
          foreach($isarelations as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_isarelations" ID="3.'.$i0.'">';
          
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_isarelations" ID="3.'.count($isarelations).'">new isa_relations</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php
          $Conceptualdiagram = $Pattern->get_Conceptualdiagram();
          echo '<IMG src="'.$Conceptualdiagram.'"/>';
        ?> 
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Pattern->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Pattern'=>urlencode($Pattern->getId()) )),"Cancel");
     } 
  } else {
          $buttons=$buttons;
          $buttons=$buttons;
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Pattern is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Pattern object selected - Atlas - ADL Prototype</TITLE>");
      ?><i>No Pattern object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>