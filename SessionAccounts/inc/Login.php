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
  require "Login.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    if(@$r['0']!=''){
      $username = @$r['0'];
    }else $username=null;
    if(@$r['1']!=''){
      $password = @$r['1'];
    }else $password=null;
    $succes=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $succes[$i0] = @$r['2.'.$i0.''];
    }
    $Login=new Login(@$_REQUEST['ID'],$username, $password, $succes);
    if($Login->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Login='.urlencode($Login->getId()));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Login'])){
    if(!$del || !delLogin($_REQUEST['Login']))
      $Login = readLogin($_REQUEST['Login']);
    else $Login = false; // delete was a succes!
  } else if($new) $Login = new Login();
  else $Login = false;
  if($Login){
    writeHead("<TITLE>Login - ctxSessionAccounts - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Login->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Login->getId()).'" /></P>';
    else echo '<H1>'.$Login->getId().'</H1>';
    ?>
    <DIV class="Floater username">
      <DIV class="FloaterHeader">username</DIV>
      <DIV class="FloaterContent"><?php
          $username = $Login->get_username();
          //PICK an existing item0. Creating instances should at most be possible for simple Concepts.
          if(isset($username)){
            echo '<DIV CLASS="item UI_username" ID="0">';
          }else{
            echo '<DIV CLASS="new UI_username" ID="0">';
          }
              if(isset($username) && $username!=''){
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To0">';
                  echo htmlspecialchars($username).'</A>';
                  echo '<DIV class="Goto" id="GoTo0"><UL>';
                  echo '<LI><A HREF="'.serviceref('User',false,$edit, array('User'=>urlencode($username))).'">User</A></LI>';
                  echo '<LI><A HREF="'.serviceref('UserAccounts',false,$edit, array('UserAccounts'=>urlencode($username))).'">UserAccounts</A></LI>';
                  echo '<LI><A HREF="'.serviceref('AssignRoleToUser',false,$edit, array('AssignRoleToUser'=>urlencode($username))).'">AssignRoleToUser</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($username);
              } else {echo '<I>Nothing</I>';}
          echo '</DIV>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater password">
      <DIV class="FloaterHeader">password</DIV>
      <DIV class="FloaterContent"><?php
          $password = $Login->get_password();
          //PICK an existing item1. Creating instances should at most be possible for simple Concepts.
          if(isset($password)){
            echo '<DIV CLASS="item UI_password" ID="1">';
          }else{
            echo '<DIV CLASS="new UI_password" ID="1">';
          }
              if(isset($password) && $password!=''){
                echo htmlspecialchars($password);
              } else {echo '<I>Nothing</I>';}
          echo '</DIV>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater succes">
      <DIV class="FloaterHeader">succes</DIV>
      <DIV class="FloaterContent"><?php
          $succes = $Login->get_succes();
          echo '
          <UL>';
          foreach($succes as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_succes" ID="2.'.$i0.'">';
          
              if($v0==''){echo '<I>Nothing</I>';}
              else{
              echo htmlspecialchars($v0);
              }
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_succes" ID="2.'.count($succes).'">enter instance of succes</LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Login->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('Login'=>urlencode($Login->getId()) )),"Cancel");
     } 
  } else {
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('Login'=>urlencode($Login->getId()),'edit'=>1)),"Edit");
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('Login'=>urlencode($Login->getId()),'del'=>1)),"Delete");
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Login is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Login object selected - ctxSessionAccounts - ADL Prototype</TITLE>");
      ?><i>No Login object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>