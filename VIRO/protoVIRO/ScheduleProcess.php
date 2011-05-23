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
  require "ScheduleProcess.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $session = @$r['0'];
    $case = @$r['1'];
    $ScheduleProcess=new ScheduleProcess($ID,$session, $case);
    if($ScheduleProcess->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?ScheduleProcess='.urlencode($ScheduleProcess->getId())); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['ScheduleProcess'])){
    if(!$del || !delScheduleProcess($_REQUEST['ScheduleProcess']))
      $ScheduleProcess = readScheduleProcess($_REQUEST['ScheduleProcess']);
    else $ScheduleProcess = false; // delete was a succes!
  } else if($new) $ScheduleProcess = new ScheduleProcess();
  else $ScheduleProcess = false;
  if($ScheduleProcess){
    writeHead("<TITLE>ScheduleProcess - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $ScheduleProcess->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($ScheduleProcess->getId()).'" /></P>';
    else echo '<H1>'.$ScheduleProcess->getId().'</H1>';
    ?>
    <DIV class="Floater session">
      <DIV class="FloaterHeader">session</DIV>
      <DIV class="FloaterContent"><?php
          $session = $ScheduleProcess->get_session();
          echo '<SPAN CLASS="item UI_session" ID="0">';
          if(!$edit) echo '
          <A HREF="Session.php?Session='.urlencode($session).'">'.htmlspecialchars($session).'</A>';
          else echo htmlspecialchars($session);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater case">
      <DIV class="FloaterHeader">case</DIV>
      <DIV class="FloaterContent"><?php
          $case = $ScheduleProcess->get_case();
          echo '<SPAN CLASS="item UI_case" ID="1">';
          if(!$edit) echo '
          <A HREF="LegalCase.php?LegalCase='.urlencode($case).'">'.htmlspecialchars($case).'</A>';
          else echo htmlspecialchars($case);
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($ScheduleProcess->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?ScheduleProcess=".urlencode($ScheduleProcess->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&ScheduleProcess=".urlencode($ScheduleProcess->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&ScheduleProcess=".urlencode($ScheduleProcess->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The ScheduleProcess is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No ScheduleProcess object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No ScheduleProcess object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>