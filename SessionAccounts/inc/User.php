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
  require "User.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    if(@$r['0']!=''){
      $Accountverantwoordelijkepersoon = @$r['0'];
    }else $Accountverantwoordelijkepersoon=null;
    if(@$r['1']!=''){
      $Wachtwoord = @$r['1'];
    }else $Wachtwoord=null;
    $User=new User(@$_REQUEST['ID'],$Accountverantwoordelijkepersoon, $Wachtwoord);
    if($User->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&User='.urlencode($User->getId()));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['User'])){
    if(!$del || !delUser($_REQUEST['User']))
      $User = readUser($_REQUEST['User']);
    else $User = false; // delete was a succes!
  } else if($new) $User = new User();
  else $User = false;
  if($User){
    writeHead("<TITLE>User - ctxSessionAccounts - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $User->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($User->getId()).'" /></P>';
    else echo '<H1>'.$User->getId().'</H1>';
    ?>
    <DIV class="Floater Accountverantwoordelijke (persoon)">
      <DIV class="FloaterHeader">Accountverantwoordelijke (persoon)</DIV>
      <DIV class="FloaterContent"><?php
          $Accountverantwoordelijkepersoon = $User->get_Accountverantwoordelijkepersoon();
          //PICK an existing item0. Creating instances should at most be possible for simple Concepts.
          if(isset($Accountverantwoordelijkepersoon)){
            echo '<DIV CLASS="item UI_Accountverantwoordelijkepersoon" ID="0">';
          }else{
            echo '<DIV CLASS="new UI_Accountverantwoordelijkepersoon" ID="0">';
          }
              if(isset($Accountverantwoordelijkepersoon) && $Accountverantwoordelijkepersoon!=''){
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To0">';
                  echo htmlspecialchars($Accountverantwoordelijkepersoon).'</A>';
                  echo '<DIV class="Goto" id="GoTo0"><UL>';
                  echo '<LI><A HREF="'.serviceref('Persoon',false,$edit, array('Persoon'=>urlencode($Accountverantwoordelijkepersoon))).'">Persoon</A></LI>';
                  echo '<LI><A HREF="'.serviceref('Personen',false,$edit, array('Personen'=>urlencode($Accountverantwoordelijkepersoon))).'">Personen</A></LI>';
                  echo '<LI><A HREF="'.serviceref('AssignRoleToPerson',false,$edit, array('AssignRoleToPerson'=>urlencode($Accountverantwoordelijkepersoon))).'">AssignRoleToPerson</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($Accountverantwoordelijkepersoon);
              } else {echo '<I>Nothing</I>';}
          echo '</DIV>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater Wachtwoord">
      <DIV class="FloaterHeader">Wachtwoord</DIV>
      <DIV class="FloaterContent"><?php
          $Wachtwoord = $User->get_Wachtwoord();
          //PICK an existing item1. Creating instances should at most be possible for simple Concepts.
          if(isset($Wachtwoord)){
            echo '<DIV CLASS="item UI_Wachtwoord" ID="1">';
          }else{
            echo '<DIV CLASS="new UI_Wachtwoord" ID="1">';
          }
              if(isset($Wachtwoord) && $Wachtwoord!=''){
                echo htmlspecialchars($Wachtwoord);
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($User->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('User'=>urlencode($User->getId()) )),"Cancel");
     } 
  } else {
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('User'=>urlencode($User->getId()),'edit'=>1)),"Edit");
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('User'=>urlencode($User->getId()),'del'=>1)),"Delete");
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The User is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No User object selected - ctxSessionAccounts - ADL Prototype</TITLE>");
      ?><i>No User object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>