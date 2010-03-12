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
  require "Pattern.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $regels=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $regels[$i0] = @$r['0.'.$i0.''];
    }
    $relaties=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $relaties[$i0] = @$r['1.'.$i0.''];
    }
    $Conceptueeldiagram = @$r['2'];
    $Pattern=new Pattern($ID,$regels, $relaties, $Conceptueeldiagram);
    if($Pattern->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Pattern='.urlencode($Pattern->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Pattern'])){
    if(!$del || !delPattern($_REQUEST['Pattern']))
      $Pattern = readPattern($_REQUEST['Pattern']);
    else $Pattern = false; // delete was a succes!
  } else if($new) $Pattern = new Pattern();
  else $Pattern = false;
  if($Pattern){
    writeHead("<TITLE>Pattern - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Pattern->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Pattern->getId()).'" /></P>';
    else echo '<H1>'.display('Pattern','display',$Pattern->getId()).'</H1>';
    ?>
    <DIV class="Floater regels">
      <DIV class="FloaterHeader">regels</DIV>
      <DIV class="FloaterContent"><?php
          $regels = $Pattern->get_regels();
          echo '
          <UL>';
          foreach($regels as $i0=>$idv0){
            $v0=display('UserRule','display',$idv0);
            echo '
            <LI CLASS="item UI_regels" ID="0.'.$i0.'">';
          
              if(!$edit) echo '
              <A HREF="'.serviceref('UserRule', array('UserRule'=>urlencode($idv0))).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_regels" ID="0.'.count($regels).'">new regels</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater relaties">
      <DIV class="FloaterHeader">relaties</DIV>
      <DIV class="FloaterContent"><?php
          $relaties = $Pattern->get_relaties();
          echo '
          <UL>';
          foreach($relaties as $i0=>$idv0){
            $v0=display('Relation','display',$idv0);
            echo '
            <LI CLASS="item UI_relaties" ID="1.'.$i0.'">';
          
              if(!$edit){
                echo '
              <A class="GotoLink" id="To1.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="'.serviceref('Relatiedetails', array('Relatiedetails'=>urlencode($idv0))).'">Relatiedetails</A></LI>';
                echo '<LI><A HREF="'.serviceref('Populatie', array('Populatie'=>urlencode($idv0))).'">Populatie</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_relaties" ID="1.'.count($relaties).'">new relaties</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php
          $Conceptueeldiagram = $Pattern->get_Conceptueeldiagram();
          echo '<IMG src="'.$Conceptueeldiagram.'"/>';
        ?> 
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Pattern->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Pattern'=>urlencode($Pattern->getId()) )),"Cancel");
     } 
  } else {
          $buttons=$buttons;
          $buttons=$buttons;
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Pattern is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Pattern object selected - Atlas - ADL Prototype</TITLE>");
      ?><i>No Pattern object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>