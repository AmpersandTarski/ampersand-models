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
  require "Assets1.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Assets=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Assets[$i0] = array( 'id' => @$r['0.'.$i0.'']
                          , 'manager' => @$r['0.'.$i0.'.0']
                          , 'accepted' => @$r['0.'.$i0.'.1']
                          );
      $Assets[$i0]['obligations']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $Assets[$i0]['obligations'][$i1] = @$r['0.'.$i0.'.2.'.$i1.''];
      }
    }
    $Assets1=new Assets1($Assets);
    if($Assets1->save()!==false) die('ok:'.serviceref($_REQUEST['content']));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Assets1=new Assets1();
    writeHead("<TITLE>Assets1 - ctxELMTest - Ampersand Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Assets1</H1>
    <DIV class="Floater Assets">
      <DIV class="FloaterHeader">Assets</DIV>
      <DIV class="FloaterContent"><?php
          $Assets = $Assets1->get_Assets();
          echo '
          <UL>';
          foreach($Assets as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
          
              if(!$edit){
                echo '
              <A class="GotoLink" id="To0.'.$i0.'">';
                echo htmlspecialchars($idv0['id']).'</A>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="'.serviceref('Asset1',false,$edit, array('Asset1'=>urlencode($idv0['id']))).'">Asset1</A></LI>';
                echo '<LI><A HREF="'.serviceref('Assets2',false,$edit, array('Assets2'=>urlencode($idv0['id']))).'">Assets2</A></LI>';
                echo '<LI><A HREF="'.serviceref('decideAssetRisks',false,$edit, array('decideAssetRisks'=>urlencode($idv0['id']))).'">decideAssetRisks</A></LI>';
                echo '<LI><A HREF="'.serviceref('decideAllRisks',false,$edit, array('decideAllRisks'=>urlencode($idv0['id']))).'">decideAllRisks</A></LI>';
                echo '<LI><A HREF="'.serviceref('estimateRisk1',false,$edit, array('estimateRisk1'=>urlencode($idv0['id']))).'">estimateRisk1</A></LI>';
                echo '<LI><A HREF="'.serviceref('estimateRisk3',false,$edit, array('estimateRisk3'=>urlencode($idv0['id']))).'">estimateRisk3</A></LI>';
                echo '</UL></DIV>';
              } else echo '<DIV CLASS="item UI" ID="0.'.$i0.'">'.htmlspecialchars($idv0['id']).'</DIV>';
              echo '
              <DIV>';
                echo 'manager: ';
                //PICK an existing item0.'.$i0.'.0. Creating instances should at most be possible for simple Concepts.
                if(isset($v0['manager'])){
                  echo '<DIV CLASS="item UImanager" ID="0.'.$i0.'.0">';
                }else{
                  echo '<DIV CLASS="new UImanager" ID="0.'.$i0.'.0">';
                }
                    if(isset($v0['manager']) && $v0['manager']!=''){
                      if(!$edit) echo '
                      <A HREF="'.serviceref('Person',false,$edit, array('Person'=>urlencode($v0['manager']))).'">'.htmlspecialchars($v0['manager']).'</A>';
                      else echo htmlspecialchars($v0['manager']);
                    } else {echo '<I>Nothing</I>';}
                echo '</DIV>';
              echo '</DIV>
              <DIV>';
                echo 'accepted: ';
                //PICK an existing item0.'.$i0.'.1. Creating instances should at most be possible for simple Concepts.
                if(isset($v0['accepted'])){
                  echo '<DIV CLASS="item UIaccepted" ID="0.'.$i0.'.1">';
                }else{
                  echo '<DIV CLASS="new UIaccepted" ID="0.'.$i0.'.1">';
                }
                    if(isset($v0['accepted']) && $v0['accepted']!=''){
                      if(!$edit){
                        echo '
                      <A class="GotoLink" id="To0.'.$i0.'.1">';
                        echo htmlspecialchars($v0['accepted']).'</A>';
                        echo '<DIV class="Goto" id="GoTo0.'.$i0.'.1"><UL>';
                        echo '<LI><A HREF="'.serviceref('Asset1',false,$edit, array('Asset1'=>urlencode($v0['accepted']))).'">Asset1</A></LI>';
                        echo '<LI><A HREF="'.serviceref('Assets2',false,$edit, array('Assets2'=>urlencode($v0['accepted']))).'">Assets2</A></LI>';
                        echo '<LI><A HREF="'.serviceref('decideAssetRisks',false,$edit, array('decideAssetRisks'=>urlencode($v0['accepted']))).'">decideAssetRisks</A></LI>';
                        echo '<LI><A HREF="'.serviceref('decideAllRisks',false,$edit, array('decideAllRisks'=>urlencode($v0['accepted']))).'">decideAllRisks</A></LI>';
                        echo '<LI><A HREF="'.serviceref('estimateRisk1',false,$edit, array('estimateRisk1'=>urlencode($v0['accepted']))).'">estimateRisk1</A></LI>';
                        echo '<LI><A HREF="'.serviceref('estimateRisk3',false,$edit, array('estimateRisk3'=>urlencode($v0['accepted']))).'">estimateRisk3</A></LI>';
                        echo '</UL></DIV>';
                      } else echo htmlspecialchars($v0['accepted']);
                    } else {echo '<I>Nothing</I>';}
                echo '</DIV>';
              echo '</DIV>
              <DIV>';
                echo 'obligations: ';
                echo '
                <UL>';
                foreach($v0['obligations'] as $i1=>$idobligations){
                  $obligations=$idobligations;
                  echo '
                  <LI CLASS="item UIobligations" ID="0.'.$i0.'.2.'.$i1.'">';
                
                    if($obligations==''){echo '<I>Nothing</I>';}
                    else{
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.2.'.$i1.'">';
                      echo htmlspecialchars($obligations).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.2.'.$i1.'"><UL>';
                      echo '<LI><A HREF="'.serviceref('decideObligationRisks',false,$edit, array('decideObligationRisks'=>urlencode($idobligations))).'">decideObligationRisks</A></LI>';
                      echo '<LI><A HREF="'.serviceref('estimateRisk2',false,$edit, array('estimateRisk2'=>urlencode($idobligations))).'">estimateRisk2</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($obligations);
                    }
                  echo '</LI>';
                }
                if($edit) { //["Select","Edit","Delete","New"]
                  echo '<LI CLASS="new UIobligations" ID="0.'.$i0.'.2.'.count($v0['obligations']).'">enter instance of obligations</LI>';
                  echo '<LI CLASS="newlink UIobligations" ID="0.'.$i0.'.2.'.(count($v0['obligations'])+1).'">';
                  echo '<A class="GotoLink" id="To0.'.$i0.'.2">new instance of obligations</A>';
                  echo '<DIV class="Goto" id="GoTo0.'.$i0.'.2"><UL>';
                  echo '<LI><A HREF="'.serviceref('decideObligationRisks',$edit).'">new decideObligationRisks</A></LI>';
                  echo '<LI><A HREF="'.serviceref('estimateRisk2',$edit).'">new estimateRisk2</A></LI>';
                  echo '</UL></DIV>';
                  echo '</LI>';
                }
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) { //["Select","Edit","Delete","New"]
            echo '<LI CLASS="new UI" ID="0.'.count($Assets).'">enter instance of Assets</LI>';
            echo '<LI CLASS="newlink UI" ID="0.'.(count($Assets)+1).'">';
            echo '<A class="GotoLink" id="To0">new instance of Assets</A>';
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
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Assets
      function UI(id){
        return '<DIV>manager: <SPAN CLASS="item UI_manager" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>accepted: <DIV CLASS="new UI_accepted" ID="'+id+'.1"><I>Nothing</I></DIV></DIV>'
             + '<DIV>obligations: <UL><LI CLASS="new UI_obligations" ID="'+id+'.2">new obligations</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
    if($edit) echo '</FORM>';
  if(!$edit) $buttons.=ifaceButton(serviceref($_REQUEST['content'])."&edit=1","Edit");
  else
    $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1');","Save")
             .ifaceButton(serviceref($_REQUEST['content']),"Cancel");
  writeTail($buttons);
?>