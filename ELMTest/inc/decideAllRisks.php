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
  require "decideAllRisks.inc.php";
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
      $obligations[$i0] = array( 'id' => @$r['1.'.$i0.'']
                               , 'risk' => @$r['1.'.$i0.'.0']
                               , 'accepted' => @$r['1.'.$i0.'.1']
                               );
    }
    $decideAllRisks=new decideAllRisks(@$_REQUEST['ID'],$accepted, $obligations);
    if($decideAllRisks->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&decideAllRisks='.urlencode($decideAllRisks->getId()));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['decideAllRisks'])){
    if(!$del || !deldecideAllRisks($_REQUEST['decideAllRisks']))
      $decideAllRisks = readdecideAllRisks($_REQUEST['decideAllRisks']);
    else $decideAllRisks = false; // delete was a succes!
  } else if($new) $decideAllRisks = new decideAllRisks();
  else $decideAllRisks = false;
  if($decideAllRisks){
    writeHead("<TITLE>decideAllRisks - ctxELMTest - Ampersand Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $decideAllRisks->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($decideAllRisks->getId()).'" /></P>';
    else echo '<H1>'.$decideAllRisks->getId().'</H1>';
    ?>
    <DIV class="Floater accepted">
      <DIV class="FloaterHeader">accepted</DIV>
      <DIV class="FloaterContent"><?php
          $accepted = $decideAllRisks->get_accepted();
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
          $obligations = $decideAllRisks->get_obligations();
          echo '
          <UL>';
          foreach($obligations as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_obligations" ID="1.'.$i0.'">';
          
              if(!$edit){
                echo '
              <A class="GotoLink" id="To1.'.$i0.'">';
                echo htmlspecialchars($idv0['id']).'</A>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="'.serviceref('decideObligationRisks',false,$edit, array('decideObligationRisks'=>urlencode($idv0['id']))).'">decideObligationRisks</A></LI>';
                echo '<LI><A HREF="'.serviceref('estimateRisk2',false,$edit, array('estimateRisk2'=>urlencode($idv0['id']))).'">estimateRisk2</A></LI>';
                echo '</UL></DIV>';
              } else echo '<DIV CLASS="item UI_obligations" ID="1.'.$i0.'">'.htmlspecialchars($idv0['id']).'</DIV>';
              echo '
              <DIV>';
                echo 'risk: ';
                //PICK an existing item1.'.$i0.'.0. Creating instances should at most be possible for simple Concepts.
                if(isset($v0['risk'])){
                  echo '<DIV CLASS="item UI_obligations_risk" ID="1.'.$i0.'.0">';
                }else{
                  echo '<DIV CLASS="new UI_obligations_risk" ID="1.'.$i0.'.0">';
                }
                    if(isset($v0['risk']) && $v0['risk']!=''){
                      if(!$edit) echo '
                      <A HREF="'.serviceref('LMH',false,$edit, array('LMH'=>urlencode($v0['risk']))).'">'.htmlspecialchars($v0['risk']).'</A>';
                      else echo htmlspecialchars($v0['risk']);
                    } else {echo '<I>Nothing</I>';}
                echo '</DIV>';
              echo '</DIV>
              <DIV>';
                echo 'accepted: ';
                //PICK an existing item1.'.$i0.'.1. Creating instances should at most be possible for simple Concepts.
                if(isset($v0['accepted'])){
                  echo '<DIV CLASS="item UI_obligations_accepted" ID="1.'.$i0.'.1">';
                }else{
                  echo '<DIV CLASS="new UI_obligations_accepted" ID="1.'.$i0.'.1">';
                }
                    if(isset($v0['accepted']) && $v0['accepted']!=''){
                      if(!$edit){
                        echo '
                      <A class="GotoLink" id="To1.'.$i0.'.1">';
                        echo htmlspecialchars($v0['accepted']).'</A>';
                        echo '<DIV class="Goto" id="GoTo1.'.$i0.'.1"><UL>';
                        echo '<LI><A HREF="'.serviceref('decideObligationRisks',false,$edit, array('decideObligationRisks'=>urlencode($v0['accepted']))).'">decideObligationRisks</A></LI>';
                        echo '<LI><A HREF="'.serviceref('estimateRisk2',false,$edit, array('estimateRisk2'=>urlencode($v0['accepted']))).'">estimateRisk2</A></LI>';
                        echo '</UL></DIV>';
                      } else echo htmlspecialchars($v0['accepted']);
                    } else {echo '<I>Nothing</I>';}
                echo '</DIV>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
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
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in obligations
      function UI_obligations(id){
        return '<DIV>risk: <DIV CLASS="new UI_obligations_risk" ID="'+id+'.0"><I>Nothing</I></DIV></DIV>'
             + '<DIV>accepted: <DIV CLASS="new UI_obligations_accepted" ID="'+id+'.1"><I>Nothing</I></DIV></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1', document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($decideAllRisks->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('decideAllRisks'=>urlencode($decideAllRisks->getId()) )),"Cancel");
     } 
  } else {
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('decideAllRisks'=>urlencode($decideAllRisks->getId()),'edit'=>1)),"Edit");
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('decideAllRisks'=>urlencode($decideAllRisks->getId()),'del'=>1)),"Delete");
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The decideAllRisks is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No decideAllRisks object selected - ctxELMTest - Ampersand Prototype</TITLE>");
      ?><i>No decideAllRisks object selected</i><?php 
    }
  }
  writeTail($buttons);
?>