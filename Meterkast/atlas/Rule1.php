<?php // generated with ADL vs. 0.8.10-493
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
  require "Rule1.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $source = @$r['0'];
    $target = @$r['1'];
    $relations=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $relations[$i0] = @$r['2.'.$i0.''];
    }
    $violations=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $violations[$i0] = @$r['3.'.$i0.''];
    }
    $explanation = @$r['4'];
    $Rule1=new Rule1($ID,$source, $target, $relations, $violations, $explanation);
    if($Rule1->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Rule1='.urlencode($Rule1->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Rule1'])){
    if(!$del || !delRule1($_REQUEST['Rule1']))
      $Rule1 = readRule1($_REQUEST['Rule1']);
    else $Rule1 = false; // delete was a succes!
  } else if($new) $Rule1 = new Rule1();
  else $Rule1 = false;
  if($Rule1){
    writeHead("<TITLE>Rule1 - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Rule1->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Rule1->getId()).'" /></P>';
    else echo '<H1>'.display('UserRule','display',$Rule1->getId()).'</H1>';
    ?>
    <DIV class="Floater source">
      <DIV class="FloaterHeader">source</DIV>
      <DIV class="FloaterContent"><?php
          $source = $Rule1->get_source();
          echo '<SPAN CLASS="item UI_source" ID="0">';
            $displaysource=display('Concept','display',$source);
          if(!$edit) echo '
          <A HREF="'.serviceref('Concept', array('Concept'=>urlencode($source))).'">'.htmlspecialchars($displaysource).'</A>';
          else echo htmlspecialchars($displaysource);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater target">
      <DIV class="FloaterHeader">target</DIV>
      <DIV class="FloaterContent"><?php
          $target = $Rule1->get_target();
          echo '<SPAN CLASS="item UI_target" ID="1">';
            $displaytarget=display('Concept','display',$target);
          if(!$edit) echo '
          <A HREF="'.serviceref('Concept', array('Concept'=>urlencode($target))).'">'.htmlspecialchars($displaytarget).'</A>';
          else echo htmlspecialchars($displaytarget);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater relations">
      <DIV class="FloaterHeader">relations</DIV>
      <DIV class="FloaterContent"><?php
          $relations = $Rule1->get_relations();
          echo '
          <UL>';
          foreach($relations as $i0=>$idv0){
            $v0=display('Relation','display',$idv0);
            echo '
            <LI CLASS="item UI_relations" ID="2.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="'.serviceref('Relation', array('Relation'=>urlencode($idv0))).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_relations" ID="2.'.count($relations).'">new relations</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater violations">
      <DIV class="FloaterHeader">violations</DIV>
      <DIV class="FloaterContent"><?php
          $violations = $Rule1->get_violations();
          echo '
          <UL>';
          foreach($violations as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_violations" ID="3.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_violations" ID="3.'.count($violations).'">new violations</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater explanation">
      <DIV class="FloaterHeader">explanation</DIV>
      <DIV class="FloaterContent"><?php
          $explanation = $Rule1->get_explanation();
          echo '<SPAN CLASS="item UI_explanation" ID="4">';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Rule1->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Rule1'=>urlencode($Rule1->getId()) )),"Cancel");
     } 
  } else $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Rule1'=>urlencode($Rule1->getId()),'edit'=>1)),"Edit")
                 .ifaceButton(serviceref($_REQUEST['content'], array('Rule1'=>urlencode($Rule1->getId()),'del'=>1)),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Rule1 is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Rule1 object selected - Atlas - ADL Prototype</TITLE>");
      ?><i>No Rule1 object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>