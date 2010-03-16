<?php // generated with ADL vs. 1.1-640
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
  require "UserRule.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $uitleg = @$r['0'];
    $overtredingen=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $overtredingen[$i0] = @$r['1.'.$i0.''];
    }
    $populatievansubexpressies=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $populatievansubexpressies[$i0] = @$r['2.'.$i0.''];
    }
    $relaties=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $relaties[$i0] = @$r['3.'.$i0.''];
    }
    $source = @$r['4'];
    $target = @$r['5'];
    $ganaarpattern = @$r['6'];
    $ganaarvorigeregel = @$r['7'];
    $ganaarvolgenderegel = @$r['8'];
    $Conceptueeldiagram = @$r['9'];
    $UserRule=new UserRule($ID,$uitleg, $overtredingen, $populatievansubexpressies, $relaties, $source, $target, $ganaarpattern, $ganaarvorigeregel, $ganaarvolgenderegel, $Conceptueeldiagram);
    if($UserRule->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&UserRule='.urlencode($UserRule->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['UserRule'])){
    if(!$del || !delUserRule($_REQUEST['UserRule']))
      $UserRule = readUserRule($_REQUEST['UserRule']);
    else $UserRule = false; // delete was a succes!
  } else if($new) $UserRule = new UserRule();
  else $UserRule = false;
  if($UserRule){
    writeHead("<TITLE>UserRule - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $UserRule->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($UserRule->getId()).'" /></P>';
    else echo '<H1>'.display('UserRule','display',$UserRule->getId()).'</H1>';
    ?>
    <DIV class="Floater uitleg">
      <DIV class="FloaterHeader">uitleg</DIV>
      <DIV class="FloaterContent"><?php
          $uitleg = $UserRule->get_uitleg();
          echo '<SPAN CLASS="item UI_uitleg" ID="0">';
            $uitleg=$uitleg;
          echo htmlspecialchars($uitleg);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater overtredingen">
      <DIV class="FloaterHeader">overtredingen</DIV>
      <DIV class="FloaterContent"><?php
          $overtredingen = $UserRule->get_overtredingen();
          echo '
          <UL>';
          foreach($overtredingen as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_overtredingen" ID="1.'.$i0.'">';
          
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_overtredingen" ID="1.'.count($overtredingen).'">new overtredingen</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater populatie van subexpressies">
      <DIV class="FloaterHeader">populatie van subexpressies</DIV>
      <DIV class="FloaterContent"><?php
          $populatievansubexpressies = $UserRule->get_populatievansubexpressies();
          echo '
          <UL>';
          foreach($populatievansubexpressies as $i0=>$idv0){
            $v0=display('SubExpression','display',$idv0);
            echo '
            <LI CLASS="item UI_populatievansubexpressies" ID="2.'.$i0.'">';
          
              if(!$edit) echo '
              <A HREF="'.serviceref('Population2', array('Population2'=>urlencode($idv0))).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_populatievansubexpressies" ID="2.'.count($populatievansubexpressies).'">new populatie van subexpressies</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater relaties">
      <DIV class="FloaterHeader">relaties</DIV>
      <DIV class="FloaterContent"><?php
          $relaties = $UserRule->get_relaties();
          echo '
          <UL>';
          foreach($relaties as $i0=>$idv0){
            $v0=display('Relation','display',$idv0);
            echo '
            <LI CLASS="item UI_relaties" ID="3.'.$i0.'">';
          
              if(!$edit){
                echo '
              <A class="GotoLink" id="To3.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo3.'.$i0.'"><UL>';
                echo '<LI><A HREF="'.serviceref('Relatiedetails', array('Relatiedetails'=>urlencode($idv0))).'">Relatiedetails</A></LI>';
                echo '<LI><A HREF="'.serviceref('Populatie', array('Populatie'=>urlencode($idv0))).'">Populatie</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_relaties" ID="3.'.count($relaties).'">new relaties</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater source">
      <DIV class="FloaterHeader">source</DIV>
      <DIV class="FloaterContent"><?php
          $source = $UserRule->get_source();
          echo '<SPAN CLASS="item UI_source" ID="4">';
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
          $target = $UserRule->get_target();
          echo '<SPAN CLASS="item UI_target" ID="5">';
            $displaytarget=display('Concept','display',$target);
          if(!$edit) echo '
          <A HREF="'.serviceref('Concept', array('Concept'=>urlencode($target))).'">'.htmlspecialchars($displaytarget).'</A>';
          else echo htmlspecialchars($displaytarget);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater ga naar pattern">
      <DIV class="FloaterHeader">ga naar pattern</DIV>
      <DIV class="FloaterContent"><?php
          $ganaarpattern = $UserRule->get_ganaarpattern();
          echo '<SPAN CLASS="item UI_ganaarpattern" ID="6">';
            $displayganaarpattern=display('Pattern','display',$ganaarpattern);
          if(!$edit) echo '
          <A HREF="'.serviceref('Pattern', array('Pattern'=>urlencode($ganaarpattern))).'">'.htmlspecialchars($displayganaarpattern).'</A>';
          else echo htmlspecialchars($displayganaarpattern);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater ga naar vorige regel">
      <DIV class="FloaterHeader">ga naar vorige regel</DIV>
      <DIV class="FloaterContent"><?php
          $ganaarvorigeregel = $UserRule->get_ganaarvorigeregel();
          echo '<SPAN CLASS="item UI_ganaarvorigeregel" ID="7">';
            $displayganaarvorigeregel=display('UserRule','display',$ganaarvorigeregel);
          if(!$edit) echo '
          <A HREF="'.serviceref('UserRule', array('UserRule'=>urlencode($ganaarvorigeregel))).'">'.htmlspecialchars($displayganaarvorigeregel).'</A>';
          else echo htmlspecialchars($displayganaarvorigeregel);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater ga naar volgende regel">
      <DIV class="FloaterHeader">ga naar volgende regel</DIV>
      <DIV class="FloaterContent"><?php
          $ganaarvolgenderegel = $UserRule->get_ganaarvolgenderegel();
          echo '<SPAN CLASS="item UI_ganaarvolgenderegel" ID="8">';
            $displayganaarvolgenderegel=display('UserRule','display',$ganaarvolgenderegel);
          if(!$edit) echo '
          <A HREF="'.serviceref('UserRule', array('UserRule'=>urlencode($ganaarvolgenderegel))).'">'.htmlspecialchars($displayganaarvolgenderegel).'</A>';
          else echo htmlspecialchars($displayganaarvolgenderegel);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <?php
          $Conceptueeldiagram = $UserRule->get_Conceptueeldiagram();
          echo '<IMG src="'.$Conceptueeldiagram.'"/>';
        ?> 
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($UserRule->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('UserRule'=>urlencode($UserRule->getId()) )),"Cancel");
     } 
  } else {
          $buttons=$buttons;
          $buttons=$buttons;
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The UserRule is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No UserRule object selected - Atlas - ADL Prototype</TITLE>");
      ?><i>No UserRule object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>