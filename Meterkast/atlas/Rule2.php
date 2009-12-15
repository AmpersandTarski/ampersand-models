<?php // generated with ADL vs. 0.8.10-478
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
  require "Rule2.inc.php";
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
    $violations=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $violations[$i0] = @$r['2.'.$i0.''];
    }
    $explanation = @$r['3'];
    $Rule2=new Rule2($ID,$source, $target, $violations, $explanation);
    if($Rule2->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Rule2='.urlencode($Rule2->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Rule2'])){
    if(!$del || !delRule2($_REQUEST['Rule2']))
      $Rule2 = readRule2($_REQUEST['Rule2']);
    else $Rule2 = false; // delete was a succes!
  } else if($new) $Rule2 = new Rule2();
  else $Rule2 = false;
  if($Rule2){
    writeHead("<TITLE>Rule2 - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Rule2->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Rule2->getId()).'" /></P>';
    else echo '<H1>'.$Rule2->getId().'</H1>';
    ?>
    <DIV class="Floater source">
      <DIV class="FloaterHeader">source</DIV>
      <DIV class="FloaterContent"><?php
          $source = $Rule2->get_source();
          echo '<SPAN CLASS="item UI_source" ID="0">';
          echo htmlspecialchars($source);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater target">
      <DIV class="FloaterHeader">target</DIV>
      <DIV class="FloaterContent"><?php
          $target = $Rule2->get_target();
          echo '<SPAN CLASS="item UI_target" ID="1">';
          echo htmlspecialchars($target);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater violations">
      <DIV class="FloaterHeader">violations</DIV>
      <DIV class="FloaterContent"><?php
          $violations = $Rule2->get_violations();
          echo '
          <UL>';
          foreach($violations as $i0=>$v0){
            echo '
            <LI CLASS="item UI_violations" ID="2.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_violations" ID="2.'.count($violations).'">new violations</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater explanation">
      <DIV class="FloaterHeader">explanation</DIV>
      <DIV class="FloaterContent"><?php
          $explanation = $Rule2->get_explanation();
          echo '<SPAN CLASS="item UI_explanation" ID="3">';
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Rule2->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Rule2=".urlencode($Rule2->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Rule2=".urlencode($Rule2->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Rule2=".urlencode($Rule2->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Rule2 is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Rule2 object selected - Atlas - ADL Prototype</TITLE>");
      ?><i>No Rule2 object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>