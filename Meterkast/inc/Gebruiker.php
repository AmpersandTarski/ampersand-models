<?php // generated with ADL vs. 1.1-647
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
  require "Gebruiker.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $sessies=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $sessies[$i0] = @$r['0.'.$i0.''];
    }
    $Gebruiker=new Gebruiker($ID,$sessies);
    if($Gebruiker->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Gebruiker='.urlencode($Gebruiker->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Gebruiker'])){
    if(!$del || !delGebruiker($_REQUEST['Gebruiker']))
      $Gebruiker = readGebruiker($_REQUEST['Gebruiker']);
    else $Gebruiker = false; // delete was a succes!
  } else if($new) $Gebruiker = new Gebruiker();
  else $Gebruiker = false;
  if($Gebruiker){
    writeHead("<TITLE>Gebruiker - Meterkast - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Gebruiker->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Gebruiker->getId()).'" /></P>';
    else echo '<H1>'.$Gebruiker->getId().'</H1>';
    ?>
    <DIV class="Floater sessies">
      <DIV class="FloaterHeader">sessies</DIV>
      <DIV class="FloaterContent"><?php
          $sessies = $Gebruiker->get_sessies();
          echo '
          <UL>';
          foreach($sessies as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
          
              if(!$edit) echo '
              <A HREF="'.serviceref('Session', array('Session'=>urlencode($idv0))).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($sessies).'">new sessies</LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Gebruiker->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Gebruiker'=>urlencode($Gebruiker->getId()) )),"Cancel");
     } 
  } else {
          ifaceButton(serviceref($_REQUEST['content'], array('Gebruiker'=>urlencode($Gebruiker->getId()),'edit'=>1)),"Edit");
          ifaceButton(serviceref($_REQUEST['content'], array('Gebruiker'=>urlencode($Gebruiker->getId()),'del'=>1)),"Delete");
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Gebruiker is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Gebruiker object selected - Meterkast - ADL Prototype</TITLE>");
      ?><i>No Gebruiker object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>