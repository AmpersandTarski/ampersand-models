<?php // generated with ADL vs. 1.1.0.801
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
  require "inhoud.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $inhoud = @$r['0'];
    $naam = @$r['1'];
    $versie = @$r['2'];
    $opvolger=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $opvolger[$i0] = @$r['3.'.$i0.''];
    }
    $voorganger=array();
    for($i0=0;isset($r['4.'.$i0]);$i0++){
      $voorganger[$i0] = @$r['4.'.$i0.''];
    }
    $inhoud=new inhoud(@$_REQUEST['ID'],$inhoud, $naam, $versie, $opvolger, $voorganger);
    if($inhoud->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&inhoud='.urlencode($inhoud->getId()));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['inhoud'])){
    if(!$del || !delinhoud($_REQUEST['inhoud']))
      $inhoud = readinhoud($_REQUEST['inhoud']);
    else $inhoud = false; // delete was a succes!
  } else if($new) $inhoud = new inhoud();
  else $inhoud = false;
  if($inhoud){
    writeHead("<TITLE>inhoud - ctxHistorie - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $inhoud->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($inhoud->getId()).'" /></P>';
    else echo '<H1>'.$inhoud->getId().'</H1>';
    ?>
    <DIV class="Floater inhoud">
      <DIV class="FloaterHeader">inhoud</DIV>
      <DIV class="FloaterContent"><?php
          $inhoud = $inhoud->get_inhoud();
          //PICK an existing item0. Creating instances should at most be possible for simple Concepts.
          if(isset($inhoud)){
            echo '<DIV CLASS="item UI_inhoud" ID="0">';
          }else{
            echo '<DIV CLASS="new UI_inhoud" ID="0">';
          }
              if(isset($inhoud) && $inhoud!=''){
                echo htmlspecialchars($inhoud);
              } else {echo '<I>Nothing</I>';}
          echo '</DIV>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater naam">
      <DIV class="FloaterHeader">naam</DIV>
      <DIV class="FloaterContent"><?php
          $naam = $inhoud->get_naam();
          //PICK an existing item1. Creating instances should at most be possible for simple Concepts.
          if(isset($naam)){
            echo '<DIV CLASS="item UI_naam" ID="1">';
          }else{
            echo '<DIV CLASS="new UI_naam" ID="1">';
          }
              if(isset($naam) && $naam!=''){
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To1">';
                  echo htmlspecialchars($naam).'</A>';
                  echo '<DIV class="Goto" id="GoTo1"><UL>';
                  echo '<LI><A HREF="'.serviceref('Inhoud toevoegen',false,$edit, array('Inhoudtoevoegen'=>urlencode($naam))).'">Inhoud toevoegen</A></LI>';
                  echo '<LI><A HREF="'.serviceref('object',false,$edit, array('object'=>urlencode($naam))).'">object</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($naam);
              } else {echo '<I>Nothing</I>';}
          echo '</DIV>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater versie">
      <DIV class="FloaterHeader">versie</DIV>
      <DIV class="FloaterContent"><?php
          $versie = $inhoud->get_versie();
          //PICK an existing item2. Creating instances should at most be possible for simple Concepts.
          if(isset($versie)){
            echo '<DIV CLASS="item UI_versie" ID="2">';
          }else{
            echo '<DIV CLASS="new UI_versie" ID="2">';
          }
              if(isset($versie) && $versie!=''){
                echo htmlspecialchars($versie);
              } else {echo '<I>Nothing</I>';}
          echo '</DIV>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater opvolger">
      <DIV class="FloaterHeader">opvolger</DIV>
      <DIV class="FloaterContent"><?php
          $opvolger = $inhoud->get_opvolger();
          echo '
          <UL>';
          foreach($opvolger as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_opvolger" ID="3.'.$i0.'">';
          
              if($v0==''){echo '<I>Nothing</I>';}
              else{
              if(!$edit) echo '
              <A HREF="'.serviceref('inhoud',false,$edit, array('inhoud'=>urlencode($idv0))).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
              }
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_opvolger" ID="3.'.count($opvolger).'">enter instance of opvolger</LI>
            <LI CLASS="newlink UI_opvolger" ID="3.'.(count($opvolger)+1).'">
              <A HREF="'.serviceref('inhoud',$edit).'">new instance of opvolger</A>
            </LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater voorganger">
      <DIV class="FloaterHeader">voorganger</DIV>
      <DIV class="FloaterContent"><?php
          $voorganger = $inhoud->get_voorganger();
          echo '
          <UL>';
          foreach($voorganger as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_voorganger" ID="4.'.$i0.'">';
          
              if($v0==''){echo '<I>Nothing</I>';}
              else{
              if(!$edit) echo '
              <A HREF="'.serviceref('inhoud',false,$edit, array('inhoud'=>urlencode($idv0))).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
              }
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_voorganger" ID="4.'.count($voorganger).'">enter instance of voorganger</LI>
            <LI CLASS="newlink UI_voorganger" ID="4.'.(count($voorganger)+1).'">
              <A HREF="'.serviceref('inhoud',$edit).'">new instance of voorganger</A>
            </LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1', document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($inhoud->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('inhoud'=>urlencode($inhoud->getId()) )),"Cancel");
     } 
  } else {
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('inhoud'=>urlencode($inhoud->getId()),'edit'=>1)),"Edit");
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('inhoud'=>urlencode($inhoud->getId()),'del'=>1)),"Delete");
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The inhoud is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No inhoud object selected - ctxHistorie - ADL Prototype</TITLE>");
      ?><i>No inhoud object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>