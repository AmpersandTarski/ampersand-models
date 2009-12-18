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
      $multiplicityproperties[$i0] = array( 'id' => @$r['3.'.$i0.'']
                                          , 'property' => @$r['3.'.$i0.'.0']
                                          , 'derived rule' => @$r['3.'.$i0.'.1']
                                          );
      $multiplicityproperties[$i0]['violations']=array();
      for($i1=0;isset($r['3.'.$i0.'.2.'.$i1]);$i1++){
        $multiplicityproperties[$i0]['violations'][$i1] = @$r['3.'.$i0.'.2.'.$i1.''];
      }
    }
    $homogeneousproperties=array();
    for($i0=0;isset($r['4.'.$i0]);$i0++){
      $homogeneousproperties[$i0] = array( 'id' => @$r['4.'.$i0.'']
                                         , 'property' => @$r['4.'.$i0.'.0']
                                         , 'derived rule' => @$r['4.'.$i0.'.1']
                                         );
      $homogeneousproperties[$i0]['violations']=array();
      for($i1=0;isset($r['4.'.$i0.'.2.'.$i1]);$i1++){
        $homogeneousproperties[$i0]['violations'][$i1] = @$r['4.'.$i0.'.2.'.$i1.''];
      }
    }
    $population=array();
    for($i0=0;isset($r['5.'.$i0]);$i0++){
      $population[$i0] = @$r['5.'.$i0.''];
    }
    $usedinrules=array();
    for($i0=0;isset($r['6.'.$i0]);$i0++){
      $usedinrules[$i0] = @$r['6.'.$i0.''];
    }
    $Relation=new Relation($ID,$type, $sources, $targets, $multiplicityproperties, $homogeneousproperties, $population, $usedinrules);
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
              if(!$edit){
                echo '
              <A HREF="'.serviceref('Rule2', array('Rule2'=>urlencode($idv0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'property: ';
                echo '<SPAN CLASS="item UI_multiplicityproperties_property" ID="3.'.$i0.'.0">';
                  $v0['property']=$v0['property'];
                echo htmlspecialchars($v0['property']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'derived rule: ';
                echo '<SPAN CLASS="item UI_multiplicityproperties_derivedrule" ID="3.'.$i0.'.1">';
                  $v0['derived rule']=$v0['derived rule'];
                echo htmlspecialchars($v0['derived rule']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'violations: ';
                echo '
                <UL>';
                foreach($v0['violations'] as $i1=>$idviolations){
                  $violations=$idviolations;
                  echo '
                  <LI CLASS="item UI_multiplicityproperties_violations" ID="3.'.$i0.'.2.'.$i1.'">';
                    echo htmlspecialchars($violations);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_multiplicityproperties_violations" ID="3.'.$i0.'.2.'.count($v0['violations']).'">new violations</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="3.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_multiplicityproperties" ID="3.'.count($multiplicityproperties).'">new multiplicity properties</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in multiplicity properties
      function UI_multiplicityproperties(id){
        return '<DIV>property: <SPAN CLASS="item UI_multiplicityproperties_property" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>derived rule: <SPAN CLASS="item UI_multiplicityproperties_derivedrule" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>violations: <UL><LI CLASS="new UI_multiplicityproperties_violations" ID="'+id+'.2">new violations</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
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
              if(!$edit){
                echo '
              <A HREF="'.serviceref('Rule3', array('Rule3'=>urlencode($idv0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'property: ';
                echo '<SPAN CLASS="item UI_homogeneousproperties_property" ID="4.'.$i0.'.0">';
                  $v0['property']=$v0['property'];
                echo htmlspecialchars($v0['property']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'derived rule: ';
                echo '<SPAN CLASS="item UI_homogeneousproperties_derivedrule" ID="4.'.$i0.'.1">';
                  $v0['derived rule']=$v0['derived rule'];
                echo htmlspecialchars($v0['derived rule']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'violations: ';
                echo '
                <UL>';
                foreach($v0['violations'] as $i1=>$idviolations){
                  $violations=$idviolations;
                  echo '
                  <LI CLASS="item UI_homogeneousproperties_violations" ID="4.'.$i0.'.2.'.$i1.'">';
                    echo htmlspecialchars($violations);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_homogeneousproperties_violations" ID="4.'.$i0.'.2.'.count($v0['violations']).'">new violations</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="4.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_homogeneousproperties" ID="4.'.count($homogeneousproperties).'">new homogeneous properties</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in homogeneous properties
      function UI_homogeneousproperties(id){
        return '<DIV>property: <SPAN CLASS="item UI_homogeneousproperties_property" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>derived rule: <SPAN CLASS="item UI_homogeneousproperties_derivedrule" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>violations: <UL><LI CLASS="new UI_homogeneousproperties_violations" ID="'+id+'.2">new violations</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
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
    <DIV class="Floater used in rules">
      <DIV class="FloaterHeader">used in rules</DIV>
      <DIV class="FloaterContent"><?php
          $usedinrules = $Relation->get_usedinrules();
          echo '
          <UL>';
          foreach($usedinrules as $i0=>$idv0){
            $v0=display('UserRule','display',$idv0);
            echo '
            <LI CLASS="item UI_usedinrules" ID="6.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="'.serviceref('Rule1', array('Rule1'=>urlencode($idv0))).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_usedinrules" ID="6.'.count($usedinrules).'">new used in rules</LI>';
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