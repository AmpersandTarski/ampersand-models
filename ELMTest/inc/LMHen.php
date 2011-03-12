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
  require "LMHen.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $LMH=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $LMH[$i0] = @$r['0.'.$i0.''];
    }
    $LMHen=new LMHen($LMH);
    if($LMHen->save()!==false) die('ok:'.serviceref($_REQUEST['content']));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $LMHen=new LMHen();
    writeHead("<TITLE>LMHen - ctxELMtest - Ampersand Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>LMHen</H1>
    <DIV class="Floater LMH">
      <DIV class="FloaterHeader">LMH</DIV>
      <DIV class="FloaterContent"><?php
          $LMH = $LMHen->get_LMH();
          echo '
          <UL>';
          foreach($LMH as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
          
              if($v0==''){echo '<I>Nothing</I>';}
              else{
              if(!$edit) echo '
              <A HREF="'.serviceref('LMH',false,$edit, array('LMH'=>urlencode($idv0))).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
              }
            echo '</LI>';
          }
          if($edit) { //["Select","Edit","Delete","New"]
            echo '<LI CLASS="new UI" ID="0.'.count($LMH).'">enter instance of LMH</LI>';
            echo '<LI CLASS="newlink UI" ID="0.'.(count($LMH)+1).'">';
            echo '<A HREF="'.serviceref('LMH',$edit).'">new instance of LMH</A>';
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