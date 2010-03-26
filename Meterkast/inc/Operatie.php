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
  require "Operatie.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $naam = @$r['0'];
    $call = @$r['1'];
    $outputURL = @$r['2'];
    $Operatie=new Operatie($ID,$naam, $call, $outputURL);
    if($Operatie->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Operatie='.urlencode($Operatie->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Operatie'])){
    if(!$del || !delOperatie($_REQUEST['Operatie']))
      $Operatie = readOperatie($_REQUEST['Operatie']);
    else $Operatie = false; // delete was a succes!
  } else if($new) $Operatie = new Operatie();
  else $Operatie = false;
  if($Operatie){
    writeHead("<TITLE>Operatie - Meterkast - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Operatie->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Operatie->getId()).'" /></P>';
    else echo '<H1>'.$Operatie->getId().'</H1>';
    ?>
    <DIV class="Floater naam">
      <DIV class="FloaterHeader">naam</DIV>
      <DIV class="FloaterContent"><?php
          $naam = $Operatie->get_naam();
          echo '<SPAN CLASS="item UI_naam" ID="0">';
            $naam=$naam;
          echo htmlspecialchars($naam);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater call">
      <DIV class="FloaterHeader">call</DIV>
      <DIV class="FloaterContent"><?php
          $call = $Operatie->get_call();
          echo '<SPAN CLASS="item UI_call" ID="1">';
            $call=$call;
          echo htmlspecialchars($call);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater outputURL">
      <DIV class="FloaterHeader">outputURL</DIV>
      <DIV class="FloaterContent"><?php
          $outputURL = $Operatie->get_outputURL();
          echo '<SPAN CLASS="item UI_outputURL" ID="2">';
            $outputURL=$outputURL;
          echo htmlspecialchars($outputURL);
          echo '</SPAN>';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Operatie->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Operatie'=>urlencode($Operatie->getId()) )),"Cancel");
     } 
  } else {
          ifaceButton(serviceref($_REQUEST['content'], array('Operatie'=>urlencode($Operatie->getId()),'edit'=>1)),"Edit");
          ifaceButton(serviceref($_REQUEST['content'], array('Operatie'=>urlencode($Operatie->getId()),'del'=>1)),"Delete");
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Operatie is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Operatie object selected - Meterkast - ADL Prototype</TITLE>");
      ?><i>No Operatie object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>