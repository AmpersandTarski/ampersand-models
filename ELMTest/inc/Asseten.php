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
  require "Asseten.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Asset=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Asset[$i0] = @$r['0.'.$i0.''];
    }
    $Asseten=new Asseten($Asset);
    if($Asseten->save()!==false) die('ok:'.serviceref($_REQUEST['content']));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Asseten=new Asseten();
    writeHead("<TITLE>Asseten - ctxELMtest - Ampersand Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Asseten</H1>
    <DIV class="Floater Asset">
      <DIV class="FloaterHeader">Asset</DIV>
      <DIV class="FloaterContent"><?php
          $Asset = $Asseten->get_Asset();
          echo '
          <UL>';
          foreach($Asset as $i0=>$idv0){
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
                echo '<LI><A HREF="'.serviceref('Asset1',false,$edit, array('Asset1'=>urlencode($idv0))).'">Asset1</A></LI>';
                echo '<LI><A HREF="'.serviceref('Assets2',false,$edit, array('Assets2'=>urlencode($idv0))).'">Assets2</A></LI>';
                echo '<LI><A HREF="'.serviceref('decideAssetRisks',false,$edit, array('decideAssetRisks'=>urlencode($idv0))).'">decideAssetRisks</A></LI>';
                echo '<LI><A HREF="'.serviceref('decideAllRisks',false,$edit, array('decideAllRisks'=>urlencode($idv0))).'">decideAllRisks</A></LI>';
                echo '<LI><A HREF="'.serviceref('estimateRisk1',false,$edit, array('estimateRisk1'=>urlencode($idv0))).'">estimateRisk1</A></LI>';
                echo '<LI><A HREF="'.serviceref('estimateRisk3',false,$edit, array('estimateRisk3'=>urlencode($idv0))).'">estimateRisk3</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
              }
            echo '</LI>';
          }
          if($edit) { //["Select","Edit","Delete","New"]
            echo '<LI CLASS="new UI" ID="0.'.count($Asset).'">enter instance of Asset</LI>';
            echo '<LI CLASS="newlink UI" ID="0.'.(count($Asset)+1).'">';
            echo '<A class="GotoLink" id="To0">new instance of Asset</A>';
            echo '<DIV class="Goto" id="GoTo0"><UL>';
            echo '<LI><A HREF="'.serviceref('Asset1',$edit).'">new Asset1</A></LI>';
            echo '<LI><A HREF="'.serviceref('Assets2',$edit).'">new Assets2</A></LI>';
            echo '<LI><A HREF="'.serviceref('decideAssetRisks',$edit).'">new decideAssetRisks</A></LI>';
            echo '<LI><A HREF="'.serviceref('decideAllRisks',$edit).'">new decideAllRisks</A></LI>';
            echo '<LI><A HREF="'.serviceref('estimateRisk1',$edit).'">new estimateRisk1</A></LI>';
            echo '<LI><A HREF="'.serviceref('estimateRisk3',$edit).'">new estimateRisk3</A></LI>';
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
  if(!$edit) $buttons.=ifaceButton(serviceref($_REQUEST['content'])."&edit=1","Edit");
  else
    $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1');","Save")
             .ifaceButton(serviceref($_REQUEST['content']),"Cancel");
  writeTail($buttons);
?>