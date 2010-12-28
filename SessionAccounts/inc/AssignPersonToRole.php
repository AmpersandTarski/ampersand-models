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
  require "AssignPersonToRole.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $RoleFunction=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $RoleFunction[$i0] = @$r['0.'.$i0.''];
    }
    $AssignPersonToRole=new AssignPersonToRole(@$_REQUEST['ID'],$RoleFunction);
    if($AssignPersonToRole->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&AssignPersonToRole='.urlencode($AssignPersonToRole->getId()));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['AssignPersonToRole'])){
    if(!$del || !delAssignPersonToRole($_REQUEST['AssignPersonToRole']))
      $AssignPersonToRole = readAssignPersonToRole($_REQUEST['AssignPersonToRole']);
    else $AssignPersonToRole = false; // delete was a succes!
  } else if($new) $AssignPersonToRole = new AssignPersonToRole();
  else $AssignPersonToRole = false;
  if($AssignPersonToRole){
    writeHead("<TITLE>AssignPersonToRole - ctxSessionAccounts - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $AssignPersonToRole->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($AssignPersonToRole->getId()).'" /></P>';
    else echo '<H1>'.$AssignPersonToRole->getId().'</H1>';
    ?>
    <DIV class="Floater Role/Function">
      <DIV class="FloaterHeader">Role/Function</DIV>
      <DIV class="FloaterContent"><?php
          $RoleFunction = $AssignPersonToRole->get_RoleFunction();
          echo '
          <UL>';
          foreach($RoleFunction as $i0=>$idv0){
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
                echo '<LI><A HREF="'.serviceref('Persoon',false,$edit, array('Persoon'=>urlencode($idv0))).'">Persoon</A></LI>';
                echo '<LI><A HREF="'.serviceref('Personen',false,$edit, array('Personen'=>urlencode($idv0))).'">Personen</A></LI>';
                echo '<LI><A HREF="'.serviceref('AssignRoleToPerson',false,$edit, array('AssignRoleToPerson'=>urlencode($idv0))).'">AssignRoleToPerson</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
              }
            echo '</LI>';
          }
          if($edit) {
            echo '<LI CLASS="new UI" ID="0.'.count($RoleFunction).'">enter instance of Role/Function</LI>';
            echo '<LI CLASS="newlink UI" ID="0.'.(count($RoleFunction)+1).'">';
            echo '<A class="GotoLink" id="To0">new instance of Role/Function</A>';
            echo '<DIV class="Goto" id="GoTo0"><UL>';
            echo '<LI><A HREF="'.serviceref('Persoon',$edit).'">new Persoon</A></LI>';
            echo '<LI><A HREF="'.serviceref('Personen',$edit).'">new Personen</A></LI>';
            echo '<LI><A HREF="'.serviceref('AssignRoleToPerson',$edit).'">new AssignRoleToPerson</A></LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($AssignPersonToRole->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('AssignPersonToRole'=>urlencode($AssignPersonToRole->getId()) )),"Cancel");
     } 
  } else {
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('AssignPersonToRole'=>urlencode($AssignPersonToRole->getId()),'edit'=>1)),"Edit");
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('AssignPersonToRole'=>urlencode($AssignPersonToRole->getId()),'del'=>1)),"Delete");
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The AssignPersonToRole is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No AssignPersonToRole object selected - ctxSessionAccounts - ADL Prototype</TITLE>");
      ?><i>No AssignPersonToRole object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>