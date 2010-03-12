<?php // generated with ADL vs. 1.1-632
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
  require "Population2.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $populatie=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $populatie[$i0] = @$r['0.'.$i0.''];
    }
    $Population2=new Population2($ID,$populatie);
    if($Population2->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Population2='.urlencode($Population2->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Population2'])){
    if(!$del || !delPopulation2($_REQUEST['Population2']))
      $Population2 = readPopulation2($_REQUEST['Population2']);
    else $Population2 = false; // delete was a succes!
  } else if($new) $Population2 = new Population2();
  else $Population2 = false;
  if($Population2){
    writeHead("<TITLE>Population2 - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Population2->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Population2->getId()).'" /></P>';
    else echo '<H1>'.display('SubExpression','display',$Population2->getId()).'</H1>';
    ?>
    <DIV class="Floater populatie">
      <DIV class="FloaterHeader">populatie</DIV>
      <DIV class="FloaterContent"><?php
          $populatie = $Population2->get_populatie();
          echo '
          <UL>';
          foreach($populatie as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
          
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($populatie).'">new populatie</LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Population2->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Population2'=>urlencode($Population2->getId()) )),"Cancel");
     } 
  } else {
          $buttons=$buttons;
          $buttons=$buttons;
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Population2 is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Population2 object selected - Atlas - ADL Prototype</TITLE>");
      ?><i>No Population2 object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>