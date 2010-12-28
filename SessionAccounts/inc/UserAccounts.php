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
  require "UserAccounts.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Accounts = @$r['0'];
    $UserAccounts=new UserAccounts(@$_REQUEST['ID'],$Accounts);
    if($UserAccounts->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&UserAccounts='.urlencode($UserAccounts->getId()));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['UserAccounts'])){
    if(!$del || !delUserAccounts($_REQUEST['UserAccounts']))
      $UserAccounts = readUserAccounts($_REQUEST['UserAccounts']);
    else $UserAccounts = false; // delete was a succes!
  } else if($new) $UserAccounts = new UserAccounts();
  else $UserAccounts = false;
  if($UserAccounts){
    writeHead("<TITLE>UserAccounts - ctxSessionAccounts - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $UserAccounts->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($UserAccounts->getId()).'" /></P>';
    else echo '<H1>'.$UserAccounts->getId().'</H1>';
    ?>
    <DIV class="Floater Accounts">
      <DIV class="FloaterHeader">Accounts</DIV>
      <DIV class="FloaterContent"><?php
          $Accounts = $UserAccounts->get_Accounts();
          //PICK an existing item0. Creating instances should at most be possible for simple Concepts.
          if(isset($Accounts)){
            echo '<DIV CLASS="item UI" ID="0">';
          }else{
            echo '<DIV CLASS="new UI" ID="0">';
          }
              if(isset($Accounts) && $Accounts!=''){
                echo htmlspecialchars($Accounts);
              } else {echo '<I>Nothing</I>';}
          echo '</DIV>';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($UserAccounts->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('UserAccounts'=>urlencode($UserAccounts->getId()) )),"Cancel");
     } 
  } else {
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('UserAccounts'=>urlencode($UserAccounts->getId()),'edit'=>1)),"Edit");
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('UserAccounts'=>urlencode($UserAccounts->getId()),'del'=>1)),"Delete");
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The UserAccounts is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No UserAccounts object selected - ctxSessionAccounts - ADL Prototype</TITLE>");
      ?><i>No UserAccounts object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>