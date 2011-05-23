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
  require "Panel.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $court = @$r['0'];
    $sector = @$r['1'];
    $members=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $members[$i0] = @$r['2.'.$i0.''];
    }
    $sessions=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $sessions[$i0] = @$r['3.'.$i0.''];
    }
    $Panel=new Panel($ID,$court, $sector, $members, $sessions);
    if($Panel->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Panel='.urlencode($Panel->getId())); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Panel'])){
    if(!$del || !delPanel($_REQUEST['Panel']))
      $Panel = readPanel($_REQUEST['Panel']);
    else $Panel = false; // delete was a succes!
  } else if($new) $Panel = new Panel();
  else $Panel = false;
  if($Panel){
    writeHead("<TITLE>Panel - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Panel->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Panel->getId()).'" /></P>';
    else echo '<H1>'.$Panel->getId().'</H1>';
    ?>
    <DIV class="Floater court">
      <DIV class="FloaterHeader">court</DIV>
      <DIV class="FloaterContent"><?php
          $court = $Panel->get_court();
          echo '<SPAN CLASS="item UI_court" ID="0">';
          if(!$edit) echo '
          <A HREF="Court.php?Court='.urlencode($court).'">'.htmlspecialchars($court).'</A>';
          else echo htmlspecialchars($court);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater sector">
      <DIV class="FloaterHeader">sector</DIV>
      <DIV class="FloaterContent"><?php
          $sector = $Panel->get_sector();
          echo '<SPAN CLASS="item UI_sector" ID="1">';
          if(!$edit) echo '
          <A HREF="Sector.php?Sector='.urlencode($sector).'">'.htmlspecialchars($sector).'</A>';
          else echo htmlspecialchars($sector);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater members">
      <DIV class="FloaterHeader">members</DIV>
      <DIV class="FloaterContent"><?php
          $members = $Panel->get_members();
          echo '
          <UL>';
          foreach($members as $i0=>$v0){
            echo '
            <LI CLASS="item UI_members" ID="2.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To2.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo2.'.$i0.'"><UL>';
                echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0).'">Magistrate</A></LI>';
                echo '<LI><A HREF="Party.php?Party='.urlencode($v0).'">Party</A></LI>';
                echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0).'">InterestedParty</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_members" ID="2.'.count($members).'">new members</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater sessions">
      <DIV class="FloaterHeader">sessions</DIV>
      <DIV class="FloaterContent"><?php
          $sessions = $Panel->get_sessions();
          echo '
          <UL>';
          foreach($sessions as $i0=>$v0){
            echo '
            <LI CLASS="item UI_sessions" ID="3.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Session.php?Session='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_sessions" ID="3.'.count($sessions).'">new sessions</LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Panel->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Panel=".urlencode($Panel->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Panel=".urlencode($Panel->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Panel=".urlencode($Panel->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Panel is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Panel object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Panel object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>