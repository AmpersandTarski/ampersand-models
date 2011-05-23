<?php // generated with ADL vs. 0.8.10-452
/***************************************\
*                                       *
*   Interface V1.3.1                    *
*   (c) Bas Joosten Jun 2005-Aug 2009   *
*                                       *
*   Using interfaceDef                  *
*                                       *
\***************************************/
  require "interfaceDef.inc.php";
  require "newCase.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $caretakervoordossier = @$r['0'];
    $areaoflaw = @$r['1'];
    $typeofcase = @$r['2'];
    $newCase=new newCase($ID,$caretakervoordossier, $areaoflaw, $typeofcase);
    if($newCase->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?newCase='.urlencode($newCase->getId())); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['newCase'])){
    if(!$del || !delnewCase($_REQUEST['newCase']))
      $newCase = readnewCase($_REQUEST['newCase']);
    else $newCase = false; // delete was a succes!
  } else if($new) $newCase = new newCase();
  else $newCase = false;
  if($newCase){
    writeHead("<TITLE>newCase - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $newCase->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($newCase->getId()).'" /></P>';
    else echo '<H1>'.$newCase->getId().'</H1>';
    ?>
    <DIV class="Floater caretaker voor dossier">
      <DIV class="FloaterHeader">caretaker voor dossier</DIV>
      <DIV class="FloaterContent"><?php
          $caretakervoordossier = $newCase->get_caretakervoordossier();
          echo '<SPAN CLASS="item UI_caretakervoordossier" ID="0">';
          if(!$edit) echo '
          <A HREF="Organ.php?Organ='.urlencode($caretakervoordossier).'">'.htmlspecialchars($caretakervoordossier).'</A>';
          else echo htmlspecialchars($caretakervoordossier);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater area of law">
      <DIV class="FloaterHeader">area of law</DIV>
      <DIV class="FloaterContent"><?php
          $areaoflaw = $newCase->get_areaoflaw();
          echo '<SPAN CLASS="item UI_areaoflaw" ID="1">';
          if(!$edit) echo '
          <A HREF="AreaOfLaw.php?AreaOfLaw='.urlencode($areaoflaw).'">'.htmlspecialchars($areaoflaw).'</A>';
          else echo htmlspecialchars($areaoflaw);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater type of case">
      <DIV class="FloaterHeader">type of case</DIV>
      <DIV class="FloaterContent"><?php
          $typeofcase = $newCase->get_typeofcase();
          echo '<SPAN CLASS="item UI_typeofcase" ID="2">';
          if(!$edit) echo '
          <A HREF="CaseType.php?CaseType='.urlencode($typeofcase).'">'.htmlspecialchars($typeofcase).'</A>';
          else echo htmlspecialchars($typeofcase);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($newCase->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?newCase=".urlencode($newCase->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&newCase=".urlencode($newCase->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&newCase=".urlencode($newCase->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The newCase is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No newCase object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No newCase object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>