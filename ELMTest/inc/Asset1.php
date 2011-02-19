<?php // generated with Prototype vs. 1.1.0.874(core vs. 2.0.0.13)
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
  require "Asset1.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $manager = @$r['0'];
    if(@$r['1']!=''){
      $accepted = @$r['1'];
    }else $accepted=null;
    $obligations=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $obligations[$i0] = @$r['2.'.$i0.''];
    }
    $Asset1=new Asset1(@$_REQUEST['ID'],$manager, $accepted, $obligations);
    if($Asset1->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Asset1='.urlencode($Asset1->getId()));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Asset1'])){
    if(!$del || !delAsset1($_REQUEST['Asset1']))
      $Asset1 = readAsset1($_REQUEST['Asset1']);
    else $Asset1 = false; // delete was a succes!
  } else if($new) $Asset1 = new Asset1();
  else $Asset1 = false;
  if($Asset1){
    writeHead("<TITLE>Asset1 - ctxELMTest - Ampersand Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Asset1->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Asset1->getId()).'" /></P>';
    else echo '<H1>'.$Asset1->getId().'</H1>';
    ?>
    <DIV class="Floater manager">
      <DIV class="FloaterHeader">manager</DIV>
      <DIV class="FloaterContent"><?php
          $manager = $Asset1->get_manager();
          //PICK an existing item0. Creating instances should at most be possible for simple Concepts.
          if(isset($manager)){
            echo '<DIV CLASS="item UI_manager" ID="0">';
          }else{
            echo '<DIV CLASS="new UI_manager" ID="0">';
          }
              if(isset($manager) && $manager!=''){
                if(!$edit) echo '
                <A HREF="'.serviceref('Person',false,$edit, array('Person'=>urlencode($manager))).'">'.htmlspecialchars($manager).'</A>';
                else echo htmlspecialchars($manager);
              } else {echo '<I>Nothing</I>';}
          echo '</DIV>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater accepted">
      <DIV class="FloaterHeader">accepted</DIV>
      <DIV class="FloaterContent"><?php
          $accepted = $Asset1->get_accepted();
          //PICK an existing item1. Creating instances should at most be possible for simple Concepts.
          if(isset($accepted)){
            echo '<DIV CLASS="item UI_accepted" ID="1">';
          }else{
            echo '<DIV CLASS="new UI_accepted" ID="1">';
          }
              if(isset($accepted) && $accepted!=''){
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To1">';
                  echo htmlspecialchars($accepted).'</A>';
                  echo '<DIV class="Goto" id="GoTo1"><UL>';
                  echo '<LI><A HREF="'.serviceref('Asset1',false,$edit, array('Asset1'=>urlencode($accepted))).'">Asset1</A></LI>';
                  echo '<LI><A HREF="'.serviceref('Assets2',false,$edit, array('Assets2'=>urlencode($accepted))).'">Assets2</A></LI>';
                  echo '<LI><A HREF="'.serviceref('decideAssetRisks',false,$edit, array('decideAssetRisks'=>urlencode($accepted))).'">decideAssetRisks</A></LI>';
                  echo '<LI><A HREF="'.serviceref('decideAllRisks',false,$edit, array('decideAllRisks'=>urlencode($accepted))).'">decideAllRisks</A></LI>';
                  echo '<LI><A HREF="'.serviceref('estimateRisk1',false,$edit, array('estimateRisk1'=>urlencode($accepted))).'">estimateRisk1</A></LI>';
                  echo '<LI><A HREF="'.serviceref('estimateRisk3',false,$edit, array('estimateRisk3'=>urlencode($accepted))).'">estimateRisk3</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($accepted);
              } else {echo '<I>Nothing</I>';}
          echo '</DIV>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater obligations">
      <DIV class="FloaterHeader">obligations</DIV>
      <DIV class="FloaterContent"><?php
          $obligations = $Asset1->get_obligations();
          echo '
          <UL>';
          foreach($obligations as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_obligations" ID="2.'.$i0.'">';
          
              if($v0==''){echo '<I>Nothing</I>';}
              else{
              if(!$edit){
                echo '
              <A class="GotoLink" id="To2.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo2.'.$i0.'"><UL>';
                echo '<LI><A HREF="'.serviceref('decideObligationRisks',false,$edit, array('decideObligationRisks'=>urlencode($idv0))).'">decideObligationRisks</A></LI>';
                echo '<LI><A HREF="'.serviceref('estimateRisk2',false,$edit, array('estimateRisk2'=>urlencode($idv0))).'">estimateRisk2</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
              }
            echo '</LI>';
          }
          if($edit) { //["Select","Edit","Delete","New"]
            echo '<LI CLASS="new UI_obligations" ID="2.'.count($obligations).'">enter instance of obligations</LI>';
            echo '<LI CLASS="newlink UI_obligations" ID="2.'.(count($obligations)+1).'">';
            echo '<A class="GotoLink" id="To2">new instance of obligations</A>';
            echo '<DIV class="Goto" id="GoTo2"><UL>';
            echo '<LI><A HREF="'.serviceref('decideObligationRisks',$edit).'">new decideObligationRisks</A></LI>';
            echo '<LI><A HREF="'.serviceref('estimateRisk2',$edit).'">new estimateRisk2</A></LI>';
            echo '</UL></DIV>';
            echo '</LI>';
          }
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Asset1->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('Asset1'=>urlencode($Asset1->getId()) )),"Cancel");
     } 
  } else {
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('Asset1'=>urlencode($Asset1->getId()),'edit'=>1)),"Edit");
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('Asset1'=>urlencode($Asset1->getId()),'del'=>1)),"Delete");
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Asset1 is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Asset1 object selected - ctxELMTest - Ampersand Prototype</TITLE>");
      ?><i>No Asset1 object selected</i><?php 
    }
  }
  writeTail($buttons);
?>