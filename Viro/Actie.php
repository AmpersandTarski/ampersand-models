<?php // generated with ADL vs. 0.8.10-451
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
  require "Actie.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $actor = @$r['0'];
    $object=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $object[$i0] = array( 'id' => @$r['1.'.$i0.'.0']
                          , 'object' => @$r['1.'.$i0.'.0']
                          );
      $object[$i0]['type']=array();
      for($i1=0;isset($r['1.'.$i0.'.1.'.$i1]);$i1++){
        $object[$i0]['type'][$i1] = @$r['1.'.$i0.'.1.'.$i1.''];
      }
    }
    $uitgevoerdnamensOrgaan=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $uitgevoerdnamensOrgaan[$i0] = @$r['2.'.$i0.''];
    }
    $typeHandeling = @$r['3'];
    $Actie=new Actie($ID,$actor, $object, $uitgevoerdnamensOrgaan, $typeHandeling);
    if($Actie->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Actie='.urlencode($Actie->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Actie'])){
    if(!$del || !delActie($_REQUEST['Actie']))
      $Actie = readActie($_REQUEST['Actie']);
    else $Actie = false; // delete was a succes!
  } else if($new) $Actie = new Actie();
  else $Actie = false;
  if($Actie){
    writeHead("<TITLE>Actie - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Actie->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Actie->getId()).'" /></P>';
    else echo '<H1>'.$Actie->getId().'</H1>';
    ?>
    <DIV class="Floater actor">
      <DIV class="FloaterHeader">actor</DIV>
      <DIV class="FloaterContent"><?php
          $actor = $Actie->get_actor();
          echo '<SPAN CLASS="item UI_actor" ID="0">';
          if(!$edit){
            echo '
          <A class="GotoLink" id="To0">';
            echo htmlspecialchars($actor).'</A>';
            echo '<DIV class="Goto" id="GoTo0"><UL>';
            echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($actor).'">Gerechtelijkeambtenaar</A></LI>';
            echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($actor).'">Persoon</A></LI>';
            echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($actor).'">Belanghebbende</A></LI>';
            echo '</UL></DIV>';
          } else echo htmlspecialchars($actor);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater object">
      <DIV class="FloaterHeader">object</DIV>
      <DIV class="FloaterContent"><?php
          $object = $Actie->get_object();
          echo '
          <UL>';
          foreach($object as $i0=>$v0){
            echo '
            <LI CLASS="item UI_object" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Ding.php?Ding='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'object: ';
                echo '<SPAN CLASS="item UI_object_object" ID="1.'.$i0.'.0">';
                echo htmlspecialchars($v0['object']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type: ';
                echo '
                <UL>';
                foreach($v0['type'] as $i1=>$type){
                  echo '
                  <LI CLASS="item UI_object_type" ID="1.'.$i0.'.1.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Objecttype.php?Objecttype='.urlencode($type).'">'.htmlspecialchars($type).'</A>';
                    else echo htmlspecialchars($type);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_object_type" ID="1.'.$i0.'.1.'.count($v0['type']).'">new type</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_object" ID="1.'.count($object).'">new object</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in object
      function UI_object(id){
        return '<DIV>object: <SPAN CLASS="item UI_object_object" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>type: <UL><LI CLASS="new UI_object_type" ID="'+id+'.1">new type</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater uitgevoerd namens (Orgaan)">
      <DIV class="FloaterHeader">uitgevoerd namens (Orgaan)</DIV>
      <DIV class="FloaterContent"><?php
          $uitgevoerdnamensOrgaan = $Actie->get_uitgevoerdnamensOrgaan();
          echo '
          <UL>';
          foreach($uitgevoerdnamensOrgaan as $i0=>$v0){
            echo '
            <LI CLASS="item UI_uitgevoerdnamensOrgaan" ID="2.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Orgaan.php?Orgaan='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_uitgevoerdnamensOrgaan" ID="2.'.count($uitgevoerdnamensOrgaan).'">new uitgevoerd namens (Orgaan)</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater type Handeling">
      <DIV class="FloaterHeader">type Handeling</DIV>
      <DIV class="FloaterContent"><?php
          $typeHandeling = $Actie->get_typeHandeling();
          echo '<SPAN CLASS="item UI_typeHandeling" ID="3">';
          if(!$edit){
            echo '
          <A class="GotoLink" id="To3">';
            echo htmlspecialchars($typeHandeling).'</A>';
            echo '<DIV class="Goto" id="GoTo3"><UL>';
            echo '<LI><A HREF="HandelingCompact.php?HandelingCompact='.urlencode($typeHandeling).'">HandelingCompact</A></LI>';
            echo '<LI><A HREF="Handeling.php?Handeling='.urlencode($typeHandeling).'">Handeling</A></LI>';
            echo '</UL></DIV>';
          } else echo htmlspecialchars($typeHandeling);
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Actie->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Actie=".urlencode($Actie->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Actie=".urlencode($Actie->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Actie=".urlencode($Actie->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Actie is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Actie object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Actie object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>