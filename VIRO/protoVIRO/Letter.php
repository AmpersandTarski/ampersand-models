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
  require "Letter.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $case=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $case[$i0] = @$r['0.'.$i0.''];
    }
    $type = @$r['1'];
    $from = @$r['2'];
    $to=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $to[$i0] = @$r['3.'.$i0.''];
    }
    $remark = @$r['4'];
    $sentat = @$r['5'];
    if(@$r['6']!=''){
      $receivedat = @$r['6'];
    }else $receivedat=null;
    $Letter=new Letter($ID,$case, $type, $from, $to, $remark, $sentat, $receivedat);
    if($Letter->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Letter='.urlencode($Letter->getId())); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Letter'])){
    if(!$del || !delLetter($_REQUEST['Letter']))
      $Letter = readLetter($_REQUEST['Letter']);
    else $Letter = false; // delete was a succes!
  } else if($new) $Letter = new Letter();
  else $Letter = false;
  if($Letter){
    writeHead("<TITLE>Letter - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Letter->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Letter->getId()).'" /></P>';
    else echo '<H1>'.$Letter->getId().'</H1>';
    ?>
    <DIV class="Floater case">
      <DIV class="FloaterHeader">case</DIV>
      <DIV class="FloaterContent"><?php
          $case = $Letter->get_case();
          echo '
          <UL>';
          foreach($case as $i0=>$v0){
            echo '
            <LI CLASS="item UI_case" ID="0.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="LegalCase.php?LegalCase='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_case" ID="0.'.count($case).'">new case</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater type">
      <DIV class="FloaterHeader">type</DIV>
      <DIV class="FloaterContent"><?php
          $type = $Letter->get_type();
          echo '<SPAN CLASS="item UI_type" ID="1">';
          if(!$edit) echo '
          <A HREF="DocumentType.php?DocumentType='.urlencode($type).'">'.htmlspecialchars($type).'</A>';
          else echo htmlspecialchars($type);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater from">
      <DIV class="FloaterHeader">from</DIV>
      <DIV class="FloaterContent"><?php
          $from = $Letter->get_from();
          echo '<SPAN CLASS="item UI_from" ID="2">';
          if(!$edit){
            echo '
          <A class="GotoLink" id="To2">';
            echo htmlspecialchars($from).'</A>';
            echo '<DIV class="Goto" id="GoTo2"><UL>';
            echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($from).'">Magistrate</A></LI>';
            echo '<LI><A HREF="Party.php?Party='.urlencode($from).'">Party</A></LI>';
            echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($from).'">InterestedParty</A></LI>';
            echo '</UL></DIV>';
          } else echo htmlspecialchars($from);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater to">
      <DIV class="FloaterHeader">to</DIV>
      <DIV class="FloaterContent"><?php
          $to = $Letter->get_to();
          echo '
          <UL>';
          foreach($to as $i0=>$v0){
            echo '
            <LI CLASS="item UI_to" ID="3.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To3.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo3.'.$i0.'"><UL>';
                echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0).'">Magistrate</A></LI>';
                echo '<LI><A HREF="Party.php?Party='.urlencode($v0).'">Party</A></LI>';
                echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0).'">InterestedParty</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_to" ID="3.'.count($to).'">new to</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater remark">
      <DIV class="FloaterHeader">remark</DIV>
      <DIV class="FloaterContent"><?php
          $remark = $Letter->get_remark();
          echo '<SPAN CLASS="item UI_remark" ID="4">';
          echo htmlspecialchars($remark);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater sent at">
      <DIV class="FloaterHeader">sent at</DIV>
      <DIV class="FloaterContent"><?php
          $sentat = $Letter->get_sentat();
          echo '<SPAN CLASS="item UI_sentat" ID="5">';
          echo htmlspecialchars($sentat);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater received at">
      <DIV class="FloaterHeader">received at</DIV>
      <DIV class="FloaterContent"><?php
          $receivedat = $Letter->get_receivedat();
          echo '<SPAN CLASS="item UI_receivedat" ID="6">';
          if(isset($receivedat)){
            echo htmlspecialchars($receivedat);
          }
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Letter->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Letter=".urlencode($Letter->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Letter=".urlencode($Letter->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Letter=".urlencode($Letter->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Letter is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Letter object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Letter object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>