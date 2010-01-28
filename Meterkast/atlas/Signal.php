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
  require "Signal.inc.php";
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
    $explanation = @$r['3'];
    $previous = @$r['4'];
    $next = @$r['5'];
    $pattern = @$r['6'];
    $contains=array();
    for($i0=0;isset($r['7.'.$i0]);$i0++){
      $contains[$i0] = @$r['7.'.$i0.''];
    }
    $Signal=new Signal($ID,$source, $target, $relations, $explanation, $previous, $next, $pattern, $contains);
    if($Signal->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Signal='.urlencode($Signal->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Signal'])){
    if(!$del || !delSignal($_REQUEST['Signal']))
      $Signal = readSignal($_REQUEST['Signal']);
    else $Signal = false; // delete was a succes!
  } else if($new) $Signal = new Signal();
  else $Signal = false;
  if($Signal){
    writeHead("<TITLE>Signal - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Signal->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Signal->getId()).'" /></P>';
    else echo '<H1>'.display('Signal','display',$Signal->getId()).'</H1>';
    ?>
    <DIV class="Floater source">
      <DIV class="FloaterHeader">source</DIV>
      <DIV class="FloaterContent"><?php
          $source = $Signal->get_source();
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
          $target = $Signal->get_target();
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
          $relations = $Signal->get_relations();
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
    <DIV class="Floater explanation">
      <DIV class="FloaterHeader">explanation</DIV>
      <DIV class="FloaterContent"><?php
          $explanation = $Signal->get_explanation();
          echo '<SPAN CLASS="item UI_explanation" ID="3">';
            $explanation=$explanation;
          echo htmlspecialchars($explanation);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater previous">
      <DIV class="FloaterHeader">previous</DIV>
      <DIV class="FloaterContent"><?php
          $previous = $Signal->get_previous();
          echo '<SPAN CLASS="item UI_previous" ID="4">';
            $displayprevious=display('Signal','display',$previous);
          if(!$edit) echo '
          <A HREF="'.serviceref('Signal', array('Signal'=>urlencode($previous))).'">'.htmlspecialchars($displayprevious).'</A>';
          else echo htmlspecialchars($displayprevious);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater next">
      <DIV class="FloaterHeader">next</DIV>
      <DIV class="FloaterContent"><?php
          $next = $Signal->get_next();
          echo '<SPAN CLASS="item UI_next" ID="5">';
            $displaynext=display('Signal','display',$next);
          if(!$edit) echo '
          <A HREF="'.serviceref('Signal', array('Signal'=>urlencode($next))).'">'.htmlspecialchars($displaynext).'</A>';
          else echo htmlspecialchars($displaynext);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater pattern">
      <DIV class="FloaterHeader">pattern</DIV>
      <DIV class="FloaterContent"><?php
          $pattern = $Signal->get_pattern();
          echo '<SPAN CLASS="item UI_pattern" ID="6">';
            $displaypattern=display('Pattern','display',$pattern);
          if(!$edit) echo '
          <A HREF="'.serviceref('Pattern', array('Pattern'=>urlencode($pattern))).'">'.htmlspecialchars($displaypattern).'</A>';
          else echo htmlspecialchars($displaypattern);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater contains">
      <DIV class="FloaterHeader">contains</DIV>
      <DIV class="FloaterContent"><?php
          $contains = $Signal->get_contains();
          echo '
          <UL>';
          foreach($contains as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_contains" ID="7.'.$i0.'">';
          
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_contains" ID="7.'.count($contains).'">new contains</LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Signal->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Signal'=>urlencode($Signal->getId()) )),"Cancel");
     } 
  } else {
          $buttons=$buttons;
          $buttons=$buttons;
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Signal is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Signal object selected - Atlas - ADL Prototype</TITLE>");
      ?><i>No Signal object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>