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
  require "CaseParties.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Plaintiffs=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Plaintiffs[$i0] = @$r['0.'.$i0.''];
    }
    $Defendants=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $Defendants[$i0] = @$r['1.'.$i0.''];
    }
    $JoinedParties=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $JoinedParties[$i0] = @$r['2.'.$i0.''];
    }
    $CaseParties=new CaseParties($Plaintiffs, $Defendants, $JoinedParties);
    if($CaseParties->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $CaseParties=new CaseParties();
    writeHead("<TITLE>CaseParties - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>CaseParties</H1>
    <DIV class="Floater Plaintiffs">
      <DIV class="FloaterHeader">Plaintiffs</DIV>
      <DIV class="FloaterContent"><?php
          $Plaintiffs = $CaseParties->get_Plaintiffs();
          echo '
          <UL>';
          foreach($Plaintiffs as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Plaintiffs" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To0.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0).'">Magistrate</A></LI>';
                echo '<LI><A HREF="Party.php?Party='.urlencode($v0).'">Party</A></LI>';
                echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0).'">InterestedParty</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Plaintiffs" ID="0.'.count($Plaintiffs).'">new Plaintiffs</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater Defendants">
      <DIV class="FloaterHeader">Defendants</DIV>
      <DIV class="FloaterContent"><?php
          $Defendants = $CaseParties->get_Defendants();
          echo '
          <UL>';
          foreach($Defendants as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Defendants" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To1.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0).'">Magistrate</A></LI>';
                echo '<LI><A HREF="Party.php?Party='.urlencode($v0).'">Party</A></LI>';
                echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0).'">InterestedParty</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Defendants" ID="1.'.count($Defendants).'">new Defendants</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater Joined Parties">
      <DIV class="FloaterHeader">Joined Parties</DIV>
      <DIV class="FloaterContent"><?php
          $JoinedParties = $CaseParties->get_JoinedParties();
          echo '
          <UL>';
          foreach($JoinedParties as $i0=>$v0){
            echo '
            <LI CLASS="item UI_JoinedParties" ID="2.'.$i0.'">';
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
            <LI CLASS="new UI_JoinedParties" ID="2.'.count($JoinedParties).'">new Joined Parties</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php
    if($edit) echo '</FORM>';
  if(!$edit) $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1","Edit");
  else
    $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1');","Save")
             .ifaceButton($_SERVER['PHP_SELF'],"Cancel");
  writeTail($buttons);
?>