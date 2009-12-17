<?php // generated with ADL vs. 0.8.10-492
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
  require "Relation.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $type=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $type[$i0] = @$r['0.'.$i0.''];
    }
    $sources=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $sources[$i0] = @$r['1.'.$i0.''];
    }
    $targets=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $targets[$i0] = @$r['2.'.$i0.''];
    }
    $multiplicityproperties=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $multiplicityproperties[$i0] = @$r['3.'.$i0.''];
    }
    $homogeneousproperties=array();
    for($i0=0;isset($r['4.'.$i0]);$i0++){
      $homogeneousproperties[$i0] = @$r['4.'.$i0.''];
    }
    $population=array();
    for($i0=0;isset($r['5.'.$i0]);$i0++){
      $population[$i0] = @$r['5.'.$i0.''];
    }
    $Relation=new Relation($ID,$type, $sources, $targets, $multiplicityproperties, $homogeneousproperties, $population);
    if($Relation->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Relation='.urlencode($Relation->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Relation'])){
    if(!$del || !delRelation($_REQUEST['Relation']))
      $Relation = readRelation($_REQUEST['Relation']);
    else $Relation = false; // delete was a succes!
  } else if($new) $Relation = new Relation();
  else $Relation = false;
  if($Relation){
    writeHead("<TITLE>Relation - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Relation->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Relation->getId()).'" /></P>';
    else echo '<H1>'.display('Relation','display',$Relation->getId()).'</H1>';
    ?>
    <DIV class="Floater type">
      <DIV class="FloaterHeader">type</DIV>
      <DIV class="FloaterContent"><?php
          $type = $Relation->get_type();
          echo '
          <UL>';
          foreach($type as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_type" ID="0.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_type" ID="0.'.count($type).'">new type</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater source(s)">
      <DIV class="FloaterHeader">source(s)</DIV>
      <DIV class="FloaterContent"><?php
          $sources = $Relation->get_sources();
          echo '
          <UL>';
          foreach($sources as $i0=>$idv0){
            $v0=display('Concept','display',$idv0);
            echo '
            <LI CLASS="item UI_sources" ID="1.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="'.serviceref('Concept', array('Concept'=>urlencode($idv0))).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_sources" ID="1.'.count($sources).'">new source(s)</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater target(s)">
      <DIV class="FloaterHeader">target(s)</DIV>
      <DIV class="FloaterContent"><?php
          $targets = $Relation->get_targets();
          echo '
          <UL>';
          foreach($targets as $i0=>$idv0){
            $v0=display('Concept','display',$idv0);
            echo '
            <LI CLASS="item UI_targets" ID="2.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="'.serviceref('Concept', array('Concept'=>urlencode($idv0))).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_targets" ID="2.'.count($targets).'">new target(s)</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater multiplicity properties">
      <DIV class="FloaterHeader">multiplicity properties</DIV>
      <DIV class="FloaterContent"><?php
          $multiplicityproperties = $Relation->get_multiplicityproperties();
          echo '
          <UL>';
          foreach($multiplicityproperties as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_multiplicityproperties" ID="3.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_multiplicityproperties" ID="3.'.count($multiplicityproperties).'">new multiplicity properties</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater homogeneous properties">
      <DIV class="FloaterHeader">homogeneous properties</DIV>
      <DIV class="FloaterContent"><?php
          $homogeneousproperties = $Relation->get_homogeneousproperties();
          echo '
          <UL>';
          foreach($homogeneousproperties as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_homogeneousproperties" ID="4.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_homogeneousproperties" ID="4.'.count($homogeneousproperties).'">new homogeneous properties</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater population">
      <DIV class="FloaterHeader">population</DIV>
      <DIV class="FloaterContent"><?php
          $population = $Relation->get_population();
          echo '
          <UL>';
          foreach($population as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_population" ID="5.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_population" ID="5.'.count($population).'">new population</LI>';
          echo '
          </UL>';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Relation->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Relation'=>urlencode($Relation->getId()) )),"Cancel");
     } 
  } else $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Relation'=>urlencode($Relation->getId()),'edit'=>1)),"Edit")
                 .ifaceButton(serviceref($_REQUEST['content'], array('Relation'=>urlencode($Relation->getId()),'del'=>1)),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Relation is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Relation object selected - Atlas - ADL Prototype</TITLE>");
      ?><i>No Relation object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>