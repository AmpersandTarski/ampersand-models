<?php // generated with Prototype vs. 1.1.0.899(core vs. 2.0.0.25)
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
  require "Assets2.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    if(@$r['0']!=''){
      $accepted = @$r['0'];
    }else $accepted=null;
    $obligations=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $obligations[$i0] = @$r['1.'.$i0.''];
    }
    $Assets2=new Assets2(@$_REQUEST['ID'],$accepted, $obligations);
    if($Assets2->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Assets2='.urlencode($Assets2->getId()));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Assets2'])){
    if(!$del || !delAssets2($_REQUEST['Assets2']))
      $Assets2 = readAssets2($_REQUEST['Assets2']);
    else $Assets2 = false; // delete was a succes!
  } else if($new) $Assets2 = new Assets2();
  else $Assets2 = false;
  if($Assets2){
    writeHead("<TITLE>Assets2 - ctxELMtest - Ampersand Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Assets2->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Assets2->getId()).'" /></P>';
    else echo '<H1>'.$Assets2->getId().'</H1>';
    ?>
    <DIV class="Floater accepted">
      <DIV class="FloaterHeader">accepted</DIV>
      <DIV class="FloaterContent"><?php
          $accepted = $Assets2->get_accepted();
          //PICK an existing item0. Creating instances should at most be possible for simple Concepts.
          if(isset($accepted)){
            echo '<DIV CLASS="item UI_accepted" ID="0">';
          }else{
            echo '<DIV CLASS="new UI_accepted" ID="0">';
          }
              if(isset($accepted) && $accepted!=''){
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To0">';
                  echo htmlspecialchars($accepted).'</A>';
                  echo '<DIV class="Goto" id="GoTo0"><UL>';
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
          $obligations = $Assets2->get_obligations();
          echo '
          <UL>';
          foreach($obligations as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_obligations" ID="1.'.$i0.'">';
          
              if($v0==''){echo '<I>Nothing</I>';}
              else{
              if(!$edit){
                echo '
              <A class="GotoLink" id="To1.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="'.serviceref('decideObligationRisks',false,$edit, array('decideObligationRisks'=>urlencode($idv0))).'">decideObligationRisks</A></LI>';
                echo '<LI><A HREF="'.serviceref('estimateRisk2',false,$edit, array('estimateRisk2'=>urlencode($idv0))).'">estimateRisk2</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
              }
            echo '</LI>';
          }
          if($edit) { //["Select","Edit","Delete","New"]
            echo '<LI CLASS="new UI_obligations" ID="1.'.count($obligations).'">enter instance of obligations</LI>';
            echo '<LI CLASS="newlink UI_obligations" ID="1.'.(count($obligations)+1).'">';
            echo '<A class="GotoLink" id="To1">new instance of obligations</A>';
            echo '<DIV class="Goto" id="GoTo1"><UL>';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Assets2->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('Assets2'=>urlencode($Assets2->getId()) )),"Cancel");
     } 
  } else {
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('Assets2'=>urlencode($Assets2->getId()),'edit'=>1)),"Edit");
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('Assets2'=>urlencode($Assets2->getId()),'del'=>1)),"Delete");
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Assets2 is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Assets2 object selected - ctxELMtest - Ampersand Prototype</TITLE>");
      ?><i>No Assets2 object selected</i><?php 
    }
  }
  writeTail($buttons);
?>