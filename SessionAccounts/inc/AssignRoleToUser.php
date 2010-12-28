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
  require "AssignRoleToUser.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Username=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Username[$i0] = @$r['0.'.$i0.''];
    }
    $AssignRoleToUser=new AssignRoleToUser(@$_REQUEST['ID'],$Username);
    if($AssignRoleToUser->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&AssignRoleToUser='.urlencode($AssignRoleToUser->getId()));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['AssignRoleToUser'])){
    if(!$del || !delAssignRoleToUser($_REQUEST['AssignRoleToUser']))
      $AssignRoleToUser = readAssignRoleToUser($_REQUEST['AssignRoleToUser']);
    else $AssignRoleToUser = false; // delete was a succes!
  } else if($new) $AssignRoleToUser = new AssignRoleToUser();
  else $AssignRoleToUser = false;
  if($AssignRoleToUser){
    writeHead("<TITLE>AssignRoleToUser - ctxSessionAccounts - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $AssignRoleToUser->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($AssignRoleToUser->getId()).'" /></P>';
    else echo '<H1>'.$AssignRoleToUser->getId().'</H1>';
    ?>
    <DIV class="Floater Username">
      <DIV class="FloaterHeader">Username</DIV>
      <DIV class="FloaterContent"><?php
          $Username = $AssignRoleToUser->get_Username();
          echo '
          <UL>';
          foreach($Username as $i0=>$idv0){
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
                echo '<LI><A HREF="'.serviceref('AssignUserToRole',false,$edit, array('AssignUserToRole'=>urlencode($idv0))).'">AssignUserToRole</A></LI>';
                echo '<LI><A HREF="'.serviceref('AssignPersonToRole',false,$edit, array('AssignPersonToRole'=>urlencode($idv0))).'">AssignPersonToRole</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
              }
            echo '</LI>';
          }
          if($edit) {
            echo '<LI CLASS="new UI" ID="0.'.count($Username).'">enter instance of Username</LI>';
            echo '<LI CLASS="newlink UI" ID="0.'.(count($Username)+1).'">';
            echo '<A class="GotoLink" id="To0">new instance of Username</A>';
            echo '<DIV class="Goto" id="GoTo0"><UL>';
            echo '<LI><A HREF="'.serviceref('AssignUserToRole',$edit).'">new AssignUserToRole</A></LI>';
            echo '<LI><A HREF="'.serviceref('AssignPersonToRole',$edit).'">new AssignPersonToRole</A></LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($AssignRoleToUser->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('AssignRoleToUser'=>urlencode($AssignRoleToUser->getId()) )),"Cancel");
     } 
  } else {
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('AssignRoleToUser'=>urlencode($AssignRoleToUser->getId()),'edit'=>1)),"Edit");
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('AssignRoleToUser'=>urlencode($AssignRoleToUser->getId()),'del'=>1)),"Delete");
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The AssignRoleToUser is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No AssignRoleToUser object selected - ctxSessionAccounts - ADL Prototype</TITLE>");
      ?><i>No AssignRoleToUser object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>