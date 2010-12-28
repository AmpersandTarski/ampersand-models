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
  require "AssignUserToRole.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $RolePermissionset=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $RolePermissionset[$i0] = @$r['0.'.$i0.''];
    }
    $AssignUserToRole=new AssignUserToRole(@$_REQUEST['ID'],$RolePermissionset);
    if($AssignUserToRole->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&AssignUserToRole='.urlencode($AssignUserToRole->getId()));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['AssignUserToRole'])){
    if(!$del || !delAssignUserToRole($_REQUEST['AssignUserToRole']))
      $AssignUserToRole = readAssignUserToRole($_REQUEST['AssignUserToRole']);
    else $AssignUserToRole = false; // delete was a succes!
  } else if($new) $AssignUserToRole = new AssignUserToRole();
  else $AssignUserToRole = false;
  if($AssignUserToRole){
    writeHead("<TITLE>AssignUserToRole - ctxSessionAccounts - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $AssignUserToRole->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($AssignUserToRole->getId()).'" /></P>';
    else echo '<H1>'.$AssignUserToRole->getId().'</H1>';
    ?>
    <DIV class="Floater Role/Permissionset">
      <DIV class="FloaterHeader">Role/Permissionset</DIV>
      <DIV class="FloaterContent"><?php
          $RolePermissionset = $AssignUserToRole->get_RolePermissionset();
          echo '
          <UL>';
          foreach($RolePermissionset as $i0=>$idv0){
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
                echo '<LI><A HREF="'.serviceref('User',false,$edit, array('User'=>urlencode($idv0))).'">User</A></LI>';
                echo '<LI><A HREF="'.serviceref('UserAccounts',false,$edit, array('UserAccounts'=>urlencode($idv0))).'">UserAccounts</A></LI>';
                echo '<LI><A HREF="'.serviceref('AssignRoleToUser',false,$edit, array('AssignRoleToUser'=>urlencode($idv0))).'">AssignRoleToUser</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
              }
            echo '</LI>';
          }
          if($edit) {
            echo '<LI CLASS="new UI" ID="0.'.count($RolePermissionset).'">enter instance of Role/Permissionset</LI>';
            echo '<LI CLASS="newlink UI" ID="0.'.(count($RolePermissionset)+1).'">';
            echo '<A class="GotoLink" id="To0">new instance of Role/Permissionset</A>';
            echo '<DIV class="Goto" id="GoTo0"><UL>';
            echo '<LI><A HREF="'.serviceref('User',$edit).'">new User</A></LI>';
            echo '<LI><A HREF="'.serviceref('UserAccounts',$edit).'">new UserAccounts</A></LI>';
            echo '<LI><A HREF="'.serviceref('AssignRoleToUser',$edit).'">new AssignRoleToUser</A></LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($AssignUserToRole->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('AssignUserToRole'=>urlencode($AssignUserToRole->getId()) )),"Cancel");
     } 
  } else {
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('AssignUserToRole'=>urlencode($AssignUserToRole->getId()),'edit'=>1)),"Edit");
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('AssignUserToRole'=>urlencode($AssignUserToRole->getId()),'del'=>1)),"Delete");
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The AssignUserToRole is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No AssignUserToRole object selected - ctxSessionAccounts - ADL Prototype</TITLE>");
      ?><i>No AssignUserToRole object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>