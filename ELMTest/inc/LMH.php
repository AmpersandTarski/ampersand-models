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
  require "LMH.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $oblRisk=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $oblRisk[$i0] = @$r['0.'.$i0.''];
    }
    $LMH=new LMH(@$_REQUEST['ID'],$oblRisk);
    if($LMH->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&LMH='.urlencode($LMH->getId()));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['LMH'])){
    if(!$del || !delLMH($_REQUEST['LMH']))
      $LMH = readLMH($_REQUEST['LMH']);
    else $LMH = false; // delete was a succes!
  } else if($new) $LMH = new LMH();
  else $LMH = false;
  if($LMH){
    writeHead("<TITLE>LMH - ctxELMTest - Ampersand Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $LMH->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($LMH->getId()).'" /></P>';
    else echo '<H1>'.$LMH->getId().'</H1>';
    ?>
    <DIV class="Floater oblRisk~">
      <DIV class="FloaterHeader">oblRisk~</DIV>
      <DIV class="FloaterContent"><?php
          $oblRisk = $LMH->get_oblRisk();
          echo '
          <UL>';
          foreach($oblRisk as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
          
              if($v0==''){echo '<I>Nothing</I>';}
              else{
              if(!$edit){
                echo '
              <A class="GotoLink" id="To0.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="'.serviceref('decideObligationRisks',false,$edit, array('decideObligationRisks'=>urlencode($idv0))).'">decideObligationRisks</A></LI>';
                echo '<LI><A HREF="'.serviceref('estimateRisk2',false,$edit, array('estimateRisk2'=>urlencode($idv0))).'">estimateRisk2</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
              }
            echo '</LI>';
          }
          if($edit) { //["Select","Edit","Delete","New"]
            echo '<LI CLASS="new UI" ID="0.'.count($oblRisk).'">enter instance of oblRisk~</LI>';
            echo '<LI CLASS="newlink UI" ID="0.'.(count($oblRisk)+1).'">';
            echo '<A class="GotoLink" id="To0">new instance of oblRisk~</A>';
            echo '<DIV class="Goto" id="GoTo0"><UL>';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($LMH->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('LMH'=>urlencode($LMH->getId()) )),"Cancel");
     } 
  } else {
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('LMH'=>urlencode($LMH->getId()),'edit'=>1)),"Edit");
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('LMH'=>urlencode($LMH->getId()),'del'=>1)),"Delete");
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The LMH is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No LMH object selected - ctxELMTest - Ampersand Prototype</TITLE>");
      ?><i>No LMH object selected</i><?php 
    }
  }
  writeTail($buttons);
?>