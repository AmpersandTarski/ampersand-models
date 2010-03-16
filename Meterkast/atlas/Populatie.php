<?php // generated with ADL vs. 1.1-640
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
  require "Populatie.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $voorbeeld = @$r['0'];
    if(@$r['1']!=''){
      $uitleg = @$r['1'];
    }else $uitleg=null;
    $populatie=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $populatie[$i0] = @$r['2.'.$i0.''];
    }
    $Populatie=new Populatie($ID,$voorbeeld, $uitleg, $populatie);
    if($Populatie->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Populatie='.urlencode($Populatie->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Populatie'])){
    if(!$del || !delPopulatie($_REQUEST['Populatie']))
      $Populatie = readPopulatie($_REQUEST['Populatie']);
    else $Populatie = false; // delete was a succes!
  } else if($new) $Populatie = new Populatie();
  else $Populatie = false;
  if($Populatie){
    writeHead("<TITLE>Populatie - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Populatie->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Populatie->getId()).'" /></P>';
    else echo '<H1>'.display('Relation','display',$Populatie->getId()).'</H1>';
    ?>
    <DIV class="Floater voorbeeld">
      <DIV class="FloaterHeader">voorbeeld</DIV>
      <DIV class="FloaterContent"><?php
          $voorbeeld = $Populatie->get_voorbeeld();
          echo '<SPAN CLASS="item UI_voorbeeld" ID="0">';
            $voorbeeld=$voorbeeld;
          echo htmlspecialchars($voorbeeld);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater uitleg">
      <DIV class="FloaterHeader">uitleg</DIV>
      <DIV class="FloaterContent"><?php
          $uitleg = $Populatie->get_uitleg();
          if (isset($uitleg)){
            $uitleg=$uitleg;
            echo '<DIV CLASS="item UI_uitleg" ID="1">';
            echo '</DIV>';
            if(isset($uitleg)){
              echo htmlspecialchars($uitleg);
            }
          } else echo '<DIV CLASS="new UI_uitleg" ID="1"><I>Nothing</I></DIV>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater populatie">
      <DIV class="FloaterHeader">populatie</DIV>
      <DIV class="FloaterContent"><?php
          $populatie = $Populatie->get_populatie();
          echo '
          <UL>';
          foreach($populatie as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_populatie" ID="2.'.$i0.'">';
          
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_populatie" ID="2.'.count($populatie).'">new populatie</LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Populatie->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Populatie'=>urlencode($Populatie->getId()) )),"Cancel");
     } 
  } else {
          $buttons=$buttons;
          $buttons=$buttons;
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Populatie is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Populatie object selected - Atlas - ADL Prototype</TITLE>");
      ?><i>No Populatie object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>